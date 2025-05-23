<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=172.17.0.80;dbname=Projet-Web;charset=utf8', 'phpmyadmin', '0550002D');

// Traitement du formulaire
$messageEnvoye = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO contact (nom, email, message) VALUES (?, ?, ?)");
    if ($stmt->execute([$nom, $email, $message])) {
        $messageEnvoye = true;

        // (Facultatif) Envoi par e-mail
        $to = "contact@voyagezen.com";
        $subject = "Nouveau message de $nom via le site Voyage Zen";
        $headers = "From: $email\r\n" .
                   "Reply-To: $email\r\n" .
                   "Content-Type: text/plain; charset=utf-8\r\n";
        $body = "Nom: $nom\nEmail: $email\n\nMessage:\n$message";

        mail($to, $subject, $body, $headers); // Peut échouer en local si mail() n'est pas configuré
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact - Voyage Zen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #333;
            padding: 40px 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
            text-align: center;
        }
        p {
            margin-bottom: 10px;
            text-align: center;
        }
        a {
            color: #007B8F;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            margin-top: 30px;
        }
        label {
            display: block;
            margin-top: 20px;
            font-weight: 600;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: inherit;
            font-size: 1rem;
        }
        button {
            margin-top: 30px;
            background-color: #007B8F;
            color: white;
            border: none;
            padding: 14px 25px;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #005f6b;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 6px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div style="text-align: right; margin-bottom: 20px;">
        <a href="index.php" style="
            background-color: #007B8F;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            display: inline-block;">
            ← Accueil
        </a>
    </div>

    <h1>Contactez Voyage Zen</h1>
    <p><strong>Adresse :</strong> 42 rue du Voyage, 75000 Paris, France</p>
    <p><strong>Email :</strong> <a href="mailto:contact@voyagezen.com">contact@voyagezen.com</a></p>
    <p><strong>Site web :</strong> <a href="http://www.voyagezen.com" target="_blank">www.voyagezen.com</a></p>

    <?php if ($messageEnvoye): ?>
        <div class="success">Votre message a été envoyé et enregistré avec succès. Merci !</div>
    <?php endif; ?>

    <form method="post" action="contact.php">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="6" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</div>
</body>
</html>

