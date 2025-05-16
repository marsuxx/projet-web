<?php
// Connexion à la base de données
$host = '172.17.0.80';
$db   = 'Projet-Web';
$user = 'phpmyadmin';
$pass = '0550002D'; // modifie selon ta config
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Destinations de Voyage</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
      color: #333;
    }
    header {
      text-align: center;
      padding: 2rem 1rem 1rem;
      background: linear-gradient(135deg, #ff6e7f 0%, #bfe9ff 100%);
      color: white;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    header h1 {
      margin: 0;
      font-weight: 700;
      font-size: 2.5rem;
      letter-spacing: 2px;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }
    main {
      max-width: 1200px;
      margin: 2rem auto 4rem;
      padding: 0 1rem;
    }
    .destinations-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }
    .card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 15px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 16px 30px rgba(0,0,0,0.15);
    }
    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      display: block;
    }
    .card-content {
      padding: 1rem 1.2rem 1.5rem;
    }
    .card-content h2 {
      margin-top: 0;
      font-weight: 700;
      font-size: 1.5rem;
      color: #ff6e7f;
    }
    .card-content p {
      font-size: 1rem;
      line-height: 1.4;
      color: #555;
      margin-bottom: 0;
    }
    @media (max-width: 400px) {
      header h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Destinations de Voyage</h1>
  </header>
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
</body>
</html>
