<?php
session_start();

// Connexion à la base de données
$pdo = new PDO('mysql:host=172.17.0.80;dbname=Projet-Web;charset=utf8', 'phpmyadmin', '0550002D');

// Récupérer l'utilisateur connecté s'il existe
$user = null;
if (isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch();
}
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
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #333;
            padding: 40px 20px;
            min-height: 100vh;
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
            transition: text-decoration 0.3s ease;
        }

        .small-button:hover {
            text-decoration: underline;
        }

        .profile-image {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            vertical-align: middle;
        }

        .header-area {
            padding-top: 80px;
            text-align: center;
            flex-shrink: 0;
        }

        h1 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #333;
        }

        .main-nav {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-bottom: 0;
        }

        a.nav-button {
            background: none;
            border: none;
            color: #333;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            cursor: pointer;
            padding: 8px 20px;
            border-radius: 0;
            transition: text-decoration 0.3s ease;
        }

        a.nav-button:hover {
            text-decoration: underline;
        }

        .white-area {
            background-color: white;
            color: #333;
            flex-grow: 1;
            padding: 40px 30px;
            width: 100%;
            margin-top: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .destinations {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .destination-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            padding: 25px 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: default;
        }

        .destination-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }

        .destination-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .destination-country {
            font-size: 1.1rem;
            font-weight: 300;
            color: #7f8c8d;
            font-style: italic;
        }

        .destination-desc {
            margin-top: 15px;
            font-size: 1.1rem;
            line-height: 1.5;
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
        <a href="compte.php" class="small-button" title="Mon compte">
            <?php if (!empty($user['photo_profil'])): ?>
                <img src="uploads/<?= htmlspecialchars($user['photo_profil']) ?>" alt="Profil" class="profile-image">
            <?php else: ?>
                👤
            <?php endif; ?>
        </a>
        <a href="deconnexion.php" class="small-button">Déconnexion</a>
    <?php else: ?>
        <a href="inscription.php" class="small-button">Inscription</a>
        <a href="connexion.php" class="small-button">Connexion</a>
    <?php endif; ?>
</div>

<div class="header-area">
    <h1>Bienvenue sur la page d'accueil</h1>
    <nav class="main-nav">
        <a href="apropos.php" class="nav-button">À propos</a>
        <a href="formulaire.php" class="nav-button">Contact</a>
        <a href="destination.php" class="nav-button">Destinations</a>
    </nav>
</div>

<header>
    <br><br><br>
    <center>
        <h2>Découvrez des Destinations de Voyage</h2>
    </center>
    <br>
</header>

<main>
<?php
$destinations = [
    [
        "city" => "Paris",
        "country" => "France",
        "description" => "Ville romantique célèbre pour la Tour Eiffel et ses musées."
    ],
    [
        "city" => "Tokyo",
        "country" => "Japon",
        "description" => "Capitale ultra-moderne mêlée de traditions, temples et technologies."
    ],
    [
        "city" => "New York",
        "country" => "États-Unis",
        "description" => "Ville qui ne dort jamais, connue pour Times Square et Central Park."
    ],
    [
        "city" => "Le Caire",
        "country" => "Égypte",
        "description" => "Ville historique au bord du Nil, proche des pyramides de Gizeh."
    ],
    [
        "city" => "Barcelone",
        "country" => "Espagne",
        "description" => "Ville ensoleillée connue pour Gaudí, les plages et la vie nocturne."
    ],
    [
        "city" => "Vancouver",
        "country" => "Canada",
        "description" => "Ville entourée de montagnes et d'océans, idéale pour les activités de plein air."
    ],
    [
        "city" => "Moscou",
        "country" => "Russie",
        "description" => "Capitale historique avec la Place Rouge et le Kremlin."
    ],
    [
        "city" => "Pékin",
        "country" => "Chine",
        "description" => "Ville impériale connue pour la Cité interdite et la Grande Muraille."
    ],
    [
        "city" => "Rome",
        "country" => "Italie",
        "description" => "Ville antique regorgeant de monuments historiques comme le Colisée."
    ]
];
?>

<div class="destinations">
    <?php foreach ($destinations as $dest): ?>
        <article class="destination-card">
            <div class="destination-title">
                <span><?= htmlspecialchars($dest['city']) ?></span>
                <span class="destination-country"><?= htmlspecialchars($dest['country']) ?></span>
            </div>
            <p class="destination-desc"><?= htmlspecialchars($dest['description']) ?></p>
        </article>
    <?php endforeach; ?>
</div>
</main>

<footer>
    &copy; <?= date('Y') ?> Site de Voyage - Tous droits réservés
</footer>
</body>
</html>

