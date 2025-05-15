<?php
// Traitement du formulaire
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Connexion à la base de données
        $servername = "localhost"; // Remplacez par votre serveur
        $dbname = "Projet-Web"; // Nom de votre base de données
        $dbusername = "phpmyadmin"; // Nom d'utilisateur de la base de données
        $dbpassword = "0550002D"; // Mot de passe de la base de données

        try {
            // Créer une connexion
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
            // Définir le mode d'erreur PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparer la requête d'insertion
            $stmt = $conn->prepare("INSERT INTO Utilisateur (username, email, password) VALUES (:username, :email, :password)");
            // Lier les paramètres
            $stmt->bindParam(':username', $username); // Correction ici
            $stmt->bindParam(':email', $email);
            // Hachage du mot de passe pour la sécurité
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashedPassword); // Correction ici

            // Exécuter la requête
            $stmt->execute();
            $message = "Inscription réussie pour : <strong>$username</strong>";
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }

        // Fermer la connexion
        $conn = null;
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Page d'inscription</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 300px;
    }

    h2 {
      text-align: center;
    }

    label {
      margin-top: 1rem;
      display: block;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      margin-top: 1rem;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .message {
      margin-top: 1rem;
      color: green;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Inscription</h2>
  <form method="POST" action="">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Adresse email :</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">S'inscrire</button>
  </form>

  <?php if (!empty($message)): ?>
    <div class="message"><?= $message ?></div>
  <?php endif; ?>
</div>

</body>
</html>
