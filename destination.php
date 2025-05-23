<?php
session_start();
$host = '172.17.0.80';
$db   = 'Projet-Web';
$user = 'phpmyadmin';
$pass = '0550002D';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
  $stmt = $pdo->query("SELECT * FROM Destinations");
  $destinations = $stmt->fetchAll();
} catch (PDOException $e) {
  echo "Erreur de connexion : " . $e->getMessage();
  exit;
}

$currentUser = null;
$photoSrc = null;

if (isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $currentUser = $stmt->fetch();

    if (!empty($currentUser['photo_profil'])) {
        $photoSrc = filter_var($currentUser['photo_profil'], FILTER_VALIDATE_URL)
            ? $currentUser['photo_profil']
            : 'uploads/' . $currentUser['photo_profil'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Destinations</title>
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
    .destinations-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 30px;
      max-width: 1000px;
      margin: 0 auto;
    }
    .card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      display: block;
    }
    .card-content {
      padding: 20px;
    }
    .card-content h2 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #34495e;
      margin-bottom: 10px;
    }
    .card-content p {
      font-size: 1rem;
      color: #555;
      line-height: 1.5;
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

<!-- Zone utilisateur -->
<div class="top-right">
  <?php if ($currentUser): ?>
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

<!-- En-tÃªte -->
<header>
  <h1>Destinations de Voyage</h1>
  <nav class="main-nav">
    <a href="index.php">Accueil</a>
    <a href="apropos.php">Ã€ propos</a>
    <a href="<?= $currentUser ? 'formulaire.php' : '#' ?>" 
       onclick="<?= $currentUser ? '' : 'alert(\'Vous n\\\'Ãªtes pas connectÃ©.\'); return false;' ?>">Avis</a>
    <a href="destination.php">Destinations</a>
  </nav>
</header>

<!-- Grille des destinations -->
<main>
  <div class="destinations-grid">
    <?php foreach ($destinations as $dest): ?>
      <div class="card">
        <img src="<?= htmlspecialchars($dest['image_url']) ?>" alt="<?= htmlspecialchars($dest['nom']) ?>" />
        <div class="card-content">
          <h2><?= htmlspecialchars($dest['nom']) ?></h2>
          <p><?= htmlspecialchars($dest['description']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<footer>
  &copy; <?= date('Y') ?> Site de Voyage - Tous droits rÃ©servÃ©s
</footer>

</body>
</html>
