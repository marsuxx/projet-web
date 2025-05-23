<?php
session_start();
$pdo = new PDO('mysql:host=172.17.0.80;dbname=Projet-Web;charset=utf8', 'phpmyadmin', '0550002D');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit();
}

$username = $_SESSION['username'];

// Récupérer les infos de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    echo "Veuillez vous reconnecter.";
    exit();
}

$userId = $user['id_utilisateur'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Modifier le pseudo
    if (!empty($_POST['username'])) {
        $newPseudo = htmlspecialchars($_POST['username']);
        $stmt = $pdo->prepare("UPDATE Utilisateur SET username = ? WHERE id_utilisateur = ?");
        if ($stmt->execute([$newPseudo, $userId])) {
            $_SESSION['username'] = $newPseudo; // mettre à jour la session aussi
            $user['username'] = $newPseudo;
        } else {
            echo "Erreur lors de la mise à jour du pseudo.";
        }
    }

    // Modifier le mot de passe
    if (!empty($_POST['mot_de_passe'])) {
        $newPassword = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE Utilisateur SET password = ? WHERE id_utilisateur = ?");
        if (!$stmt->execute([$newPassword, $userId])) {
            echo "Erreur lors de la mise à jour du mot de passe.";
        }
    }

    // Mettre à jour l'URL de la photo de profil
    if (!empty($_POST['photo_url'])) {
        $photoUrl = filter_var($_POST['photo_url'], FILTER_SANITIZE_URL);
        if (filter_var($photoUrl, FILTER_VALIDATE_URL)) {
            $stmt = $pdo->prepare("UPDATE Utilisateur SET photo_profil = ? WHERE id_utilisateur = ?");
            if ($stmt->execute([$photoUrl, $userId])) {
                $user['photo_profil'] = $photoUrl;
            } else {
                echo "Erreur lors de la mise à jour de la photo de profil.";
            }
        } else {
            echo "URL de photo non valide.";
        }
    }

    header("Location: compte.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Compte</title>
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

        .top-right img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            transition: box-shadow 0.3s ease;
        }

        .top-right img:hover {
            box-shadow: 0 0 0 2px #555;
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

        footer {
            margin-top: 60px;
            text-align: center;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        form p {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #555;
        }

        img.profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            display: block;
            margin: 10px auto 20px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="top-right">
        <a href="index.php" class="small-button">Accueil</a>
        <a href="compte.php">
            <?php if (!empty($user['photo_profil'])): ?>
                <img src="<?= htmlspecialchars($user['photo_profil']) ?>" alt="Profil">
            <?php else: ?>
                <span class="small-button">Profil</span>
            <?php endif; ?>
        </a>
    </div>

    <div class="header-area">
        <h1>Bienvenue, <?= htmlspecialchars($user['username']) ?></h1>
    </div>

    <div class="white-area">
        <?php if (!empty($user['photo_profil'])): ?>
            <img src="<?= htmlspecialchars($user['photo_profil']) ?>" alt="Photo de profil" class="profile-pic">
        <?php else: ?>
            <p>Aucune photo de profil</p>
        <?php endif; ?>

        <form action="compte.php" method="POST">
            <p>
                <label>Changer de pseudo :</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>">
            </p>
            <p>
                <label>Nouveau mot de passe :</label>
                <input type="password" name="mot_de_passe">
            </p>
            <p>
                <label>URL de la photo de profil :</label>
                <input type="text" name="photo_url" placeholder="Entrez l'URL de la photo de profil">
            </p>
            <button type="submit">Mettre à jour</button>
        </form>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> Mon Site Web. Tous droits réservés.</p>
    </footer>
</body>
</html>
