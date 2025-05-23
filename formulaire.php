<?php
session_start();
$pdo = new PDO('mysql:host=172.17.0.80;dbname=Projet-Web;charset=utf8', 'phpmyadmin', '0550002D', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

// Récupérer l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();

// Traiter l'envoi du formulaire
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = isset($_POST['note']) ? intval($_POST['note']) : 0;
    $commentaire = trim($_POST['avis'] ?? '');
    $destinationId = intval($_POST['destination'] ?? 0);

    if ($note >= 1 && $note <= 5 && strlen($commentaire) > 0 && $destinationId > 0) {
        $stmt = $pdo->prepare("INSERT INTO Avis (id_utilisateur, id_destination, note, commentaire, date_avis) VALUES (?, ?, ?, ?, CURDATE())");
        $stmt->execute([$user['id_utilisateur'], $destinationId, $note, $commentaire]);
        $successMessage = "Merci pour votre avis !";
    } else {
        $errorMessage = "Veuillez remplir tous les champs.";
    }
}

// Récupérer les destinations
$destinations = $pdo->query("SELECT id_destination, nom FROM Destinations")->fetchAll();

// Récupérer les avis récents
$avisRecents = $pdo->query("
    SELECT a.note, a.commentaire, a.date_avis, u.username, d.nom AS destination
    FROM Avis a
    JOIN Utilisateur u ON u.id_utilisateur = a.id_utilisateur
    JOIN Destinations d ON d.id_destination = a.id_destination
    ORDER BY a.date_avis DESC, a.id_avis DESC
    LIMIT 5
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Donner votre avis</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
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
            width: 100%;
            max-width: 500px;
            text-align: center;
            margin-bottom: 2rem;
        }
        h2 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        .star-rating {
            direction: rtl;
            display: flex;
            justify-content: center;
            margin: 1rem 0;
        }
        .star-rating input[type="radio"] {
            display: none;
        }
        .star-rating label {
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
        }
        .star-rating input[type="radio"]:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f5c518;
        }
        select, textarea, button {
            width: 100%;
            margin-bottom: 1rem;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        button {
            background-color: #a8edea;
            font-weight: 600;
            cursor: pointer;
        }
        button:hover {
            background-color: #91d5d1;
        }
        .message {
            font-weight: 600;
            margin: 1rem 0;
        }
        .success { color: #2e7d32; }
        .error { color: #d32f2f; }

        .button-accueil {
            display: inline-block;
            background-color: #a8edea;
            color: #333;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .button-accueil:hover {
            background-color: #91d5d1;
        }

        .carousel-container {
            max-width: 600px;
            overflow: hidden;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .carousel-track {
            display: flex;
            transition: transform 0.6s ease-in-out;
            width: 100%;
        }
        .avis-card {
            min-width: 100%;
            padding: 20px;
            text-align: left;
        }
        .avis-card h4 {
            margin: 0 0 5px;
            font-size: 1.1rem;
            color: #34495e;
        }
        .avis-card p {
            margin: 0;
            font-size: 1rem;
            color: #555;
        }
        .avis-card .note {
            color: #f5c518;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Donnez votre avis</h2>

    <!-- Bouton Accueil -->
    <a href="index.php" class="button-accueil">Accueil</a>

    <?php if ($errorMessage): ?>
        <p class="message error"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>
    <?php if ($successMessage): ?>
        <p class="message success"><?= htmlspecialchars($successMessage) ?></p>
    <?php endif; ?>

    <form method="post" action="formulaire.php">
        <select name="destination" required>
            <option value="">-- Choisissez une destination --</option>
            <?php foreach ($destinations as $dest): ?>
                <option value="<?= $dest['id_destination'] ?>"><?= htmlspecialchars($dest['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <div class="star-rating">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <input type="radio" id="star<?= $i ?>" name="note" value="<?= $i ?>" />
                <label for="star<?= $i ?>">&#9733;</label>
            <?php endfor; ?>
        </div>

        <textarea name="avis" placeholder="Écrivez votre avis ici..." required></textarea>
        <button type="submit">Envoyer</button>
    </form>
</div>

<!-- Avis récents -->
<div class="carousel-container">
    <div class="carousel-track" id="avis-track">
        <?php foreach ($avisRecents as $avis): ?>
            <div class="avis-card">
                <h4><?= htmlspecialchars($avis['username']) ?> sur <?= htmlspecialchars($avis['destination']) ?> (<?= $avis['date_avis'] ?>)</h4>
                <p class="note"><?= str_repeat('★', $avis['note']) . str_repeat('☆', 5 - $avis['note']) ?></p>
                <p><?= htmlspecialchars($avis['commentaire']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    const track = document.getElementById('avis-track');
    const cards = document.querySelectorAll('.avis-card');
    let current = 0;

    setInterval(() => {
        current = (current + 1) % cards.length;
        track.style.transform = `translateX(-${current * 100}%)`;
    }, 10000);
</script>

</body>
</html>
