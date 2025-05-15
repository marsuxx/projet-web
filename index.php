<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Mon Site545454</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }
        main {
            padding: 40px;
            text-align: center;
        }
        footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenue sur mon site</h1>
        <nav>
            <a href="#">Accueil</a>
            <a href="#">À propos</a>
            <a href="#">Contact</a>
        </nav>
    </header>

    <main>
        <h2>Page d'accueil</h2>
        <p>oui.</p>
        <p>non?</p>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Mon Site. Tous droits réservés.
    </footer>
</body>
</html>
