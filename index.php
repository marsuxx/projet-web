<?php
session_start();
$pdo = new PDO('mysql:host=172.17.0.80;dbname=Projet-Web;charset=utf8', 'phpmyadmin', '0550002D');

$user = null;
$photoSrc = null;

if (isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch();

    if (!empty($user['photo_profil'])) {
        $photoSrc = filter_var($user['photo_profil'], FILTER_VALIDATE_URL)
            ? $user['photo_profil']
            : 'uploads/' . $user['photo_profil'];
    }
}

$stmt = $pdo->query("SELECT * FROM Destinations");
$destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Site de Voyage - Accueil</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        html, body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #333;
            height: 100%;
            padding: 40px 20px;
        }
        body {
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .top-right {
            position: absolute;
            top: 40px;
            right: 40px;
            display: flex;
            gap: 15px;
            font-size: 25px;
            font-weight: 600;
            align-items: center;
        }
        .small-button {
            background: none;
            border: none;
            color: #333;
            cursor: pointer;
            text-decoration: none;
            padding: 0;
            font-size: 18px;
        }
        .small-button:hover {
            text-decoration: underline;
        }
        .profile-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #ccc;
        }
        .header-area {
            text-align: center;
            padding-top: 80px;
        }
        h1 {
            margin-bottom: 20px;
            font-weight: 700;
        }
        .main-nav {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }
        a.nav-button {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            font-size: 18px;
        }
        a.nav-button:hover {
            text-decoration: underline;
        }

        .carousel-container {
            max-width: 600px;
            margin: 50px auto;
            position: relative;
            overflow: hidden;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .carousel-track {
            display: flex;
            transition: transform 0.6s ease-in-out;
        }

        .destination-card {
            min-width: 100%;
            box-sizing: border-box;
            padding: 30px;
            text-align: center;
        }

        .destination-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .destination-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .destination-country {
            font-size: 1.1rem;
            font-style: italic;
            color: #888;
        }

        .destination-desc {
            margin-top: 15px;
            font-size: 1.1rem;
            color: #555;
        }

        footer {
            margin-top: 60px;
            text-align: center;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="top-right">
    <?php if ($user): ?>
        <a href="compte.php" class="small-button" title="Voir mon profil">
            <?php if (!empty($photoSrc)): ?>
                <img src="<?= htmlspecialchars($photoSrc) ?>" alt="Profil" class="profile-image">
            <?php else: ?>
                ðŸ‘¤
            <?php endif; ?>
        </a>
        <a href="deconnexion.php" class="small-button">DÃ©connexion</a>
    <?php else: ?>
        <a href="inscription.php" class="small-button">Inscription</a>
        <a href="connexion.php" class="small-button">Connexion</a>
    <?php endif; ?>
</div>

<div class="header-area">
    <h1>Bienvenue sur la page d'accueil</h1>
    <nav class="main-nav">
        <a href="apropos.php" class="nav-button">Ã€ propos</a>
        <a href="<?= $user ? 'formulaire.php' : '#' ?>" 
           class="nav-button" 
           onclick="<?= $user ? '' : 'alert(\'Vous n\'Ãªtes pas connectÃ©.\'); return false;' ?>">Avis</a>
        <a href="destination.php" class="nav-button">Destinations</a>
        <a href="contact.php" class="nav-button">Contact</a>
    </nav>
</div>

<header>
    <br><br><br>
    <center><h2>DÃ©couvrez des Destinations de Voyage</h2></center>
    <br>
</header>

<main>
    <div class="carousel-container">
        <div class="carousel-track" id="carousel-track">
            <?php foreach ($destinations as $dest): ?>
                <div class="destination-card">
                    <?php if (!empty($dest['image_url'])): ?>
                        <img src="<?= htmlspecialchars($dest['image_url']) ?>" alt="<?= htmlspecialchars($dest['nom']) ?>">
                    <?php endif; ?>
                    <div class="destination-title"><?= htmlspecialchars($dest['nom']) ?></div>
                    <div class="destination-country"><?= htmlspecialchars($dest['pays']) ?></div>
                    <div class="destination-desc"><?= htmlspecialchars($dest['description']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<footer>
    &copy; <?= date('Y') ?> Site de Voyage - Tous droits rÃ©servÃ©s
</footer>

<script>
    const track = document.getElementById('carousel-track');
    const slides = document.querySelectorAll('.destination-card');
    let index = 0;

    setInterval(() => {
        index = (index + 1) % slides.length;
        track.style.transform = `translateX(-${index * 100}%)`;
    }, 10000); // 10 secondes
</script>

</body>
</html>
