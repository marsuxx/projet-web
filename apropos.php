<?php
session_start();
$user = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>À propos - VoyageZen</title>
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
    }
    .top-right {
      position: absolute;
      top: 40px;
      right: 40px;
      display: flex;
      gap: 15px;
      font-size: 18px;
      align-items: center;
    }
    .small-button {
      background: none;
      border: none;
      color: #333;
      cursor: pointer;
      text-decoration: none;
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
    header {
      text-align: center;
      padding-top: 60px;
      margin-bottom: 30px;
    }
    header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #333;
    }
    nav.main-nav {
      display: flex;
      justify-content: center;
      gap: 25px;
      margin-top: 20px;
    }
    nav.main-nav a {
      text-decoration: none;
      color: #333;
      font-weight: 600;
      font-size: 18px;
    }
    nav.main-nav a:hover {
      text-decoration: underline;
    }
    .content {
      max-width: 900px;
      margin: 50px auto;
      background: white;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .content h2 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #ff6e7f;
    }
    .content p {
      font-size: 1.1rem;
      line-height: 1.7;
      margin-bottom: 20px;
    }
    .content ul {
      margin-left: 20px;
      list-style-type: "✈️ ";
      font-size: 1.05rem;
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
    <a href="compte.php" class="small-button">Mon compte</a>
    <a href="deconnexion.php" class="small-button">Déconnexion</a>
  <?php else: ?>
    <a href="inscription.php" class="small-button">Inscription</a>
    <a href="connexion.php" class="small-button">Connexion</a>
  <?php endif; ?>
</div>

<header>
  <h1>À propos de VoyageZen</h1>
  <nav class="main-nav">
    <a href="index.php">Accueil</a>
    <a href="formulaire.php" onclick="<?= $user ? '' : 'alert(\'Vous n\\\'êtes pas connecté.\'); return false;' ?>">Avis</a>
    <a href="destination.php">Destinations</a>
  </nav>
</header>

<main class="content">
  <h2>Notre mission</h2>
  <p>
    Chez <strong>VoyageZen</strong>, nous croyons que voyager devrait être une expérience accessible, sereine et profondément enrichissante.
    Nous avons créé une plateforme moderne et intuitive pour que chaque voyageur puisse réserver en toute simplicité des aventures
    authentiques à travers le monde.
  </p>

  <h2>Ce que nous proposons</h2>
  <ul>
    <li>Des réservations de vols, hôtels et activités 100% en ligne</li>
    <li>Des circuits touristiques personnalisés selon vos goûts</li>
    <li>Une assistance client disponible 24h/24, 7j/7</li>
    <li>Des offres exclusives, des promotions de dernière minute</li>
    <li>Un accompagnement de la planification jusqu’au retour</li>
  </ul>

  <h2>Nos valeurs</h2>
  <p>
    VoyageZen repose sur trois piliers : <strong>transparence, accessibilité et humanité</strong>. Nous sélectionnons des partenaires de confiance,
    affichons des prix clairs sans frais cachés, et privilégions les expériences locales.
  </p>

  <h2>Pourquoi nous choisir ?</h2>
  <p>
    Que vous partiez seul, en couple, en famille ou en groupe, notre équipe est là pour concevoir un voyage à votre image. 
    Grâce à notre technologie et notre réseau mondial, vous profitez des meilleurs prix sans compromis sur la qualité.
  </p>

  <h2>Une plateforme pensée pour vous</h2>
  <p>
    Naviguez depuis votre ordinateur ou votre mobile, explorez les destinations, consultez les avis, gérez vos réservations,
    et accédez à tout moment à votre espace personnel.
  </p>
</main>

<footer>
  &copy; <?= date('Y') ?> VoyageZen - Tous droits réservés
</footer>

</body>
</html>
