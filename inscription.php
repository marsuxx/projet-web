<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Page d'inscription</title>
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
        align-items: center;
    }
    .form-container {
        background: #fff;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        width: 300px;
        text-align: center;
        margin-top: 40px; /* Décalage vers le bas */
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
        margin-top: 1rem;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    button:hover {
        background-color: #0056b3;
    }
    .message {
        margin-top: 1rem;
        color: green;
    }
    .home-button {
        padding: 12px 50px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: background-color 0.3s;
        min-width: 180px;
        text-align: center;
        margin-bottom: 20px;
    }
    .home-button:hover {
        background-color: #0056b3;
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

    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <button type="submit">S'inscrire</button>
  </form>

  <?php if (!empty($message)): ?>
    <div class="message"><?= $message ?></div>
  <?php endif; ?>
</div>

<a href="index.php" class="home-button">Accueil</a>

</body>
</html>
