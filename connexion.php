<?php
session_start(); // Démarrer la session

$message = "";

// Rediriger vers la page d'accueil si l'utilisateur est déjà connecté
if (isset($_SESSION['username'])) {
    // L'utilisateur est déjà connecté
    header("Location: index.php");
    exit();
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    if (!empty($username) && !empty($password)) {
        $servername = "localhost";
        $dbname = "Projet-Web";
        $dbusername = "phpmyadmin";
        $dbpassword = "0550002D";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT password FROM Utilisateur WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    // Stocker les infos de session
                    $_SESSION['username'] = $username;

                    // Redirection vers la page protégée
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Mot de passe incorrect.";
                }
            } else {
                $message = "Nom d'utilisateur non trouvé.";
            }
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }

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
  <title>Page de connexion</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #333;
        padding: 40px 20px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .form-container {
        background: #fff;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        width: 300px;
        text-align: center;
        margin-bottom: 2rem;
    }
    h2 {
        font-weight: 600;
        font-size: 2rem;
        color: #2c3e50;
        margin-bottom: 1rem;
    }
    label {
        margin-top: 1rem;
        display: block;
        font-weight: 600;
        text-align: left;
    }
    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }
    button {
        width: 100%;
        margin-top: 1.5rem;
        padding: 10px;
        background-color: #a8edea;
        color: #333;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    button:hover {
        background-color: #91d5d1;
    }
    .message {
        margin-top: 1rem;
        color: red;
        text-align: center;
    }
    .home-button {
        display: inline-block;
        margin-top: 2rem;
        padding: 12px 24px;
        background-color: #a8edea;
        color: #333;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .home-button:hover {
        background-color: #91d5d1;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Connexion</h2>
  <form method="POST" action="">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Se connecter</button>
  </form>

  <?php if (!empty($message)): ?>
    <div class="message"><?= $message ?></div>
  <?php endif; ?>
</div>

<a href="index.php" class="home-button">Accueil</a>

</body>
</html>
