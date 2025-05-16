<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=Projet-Web;charset=utf8', 'root', '');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Récupérer les infos de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Modifier le pseudo
    if (!empty($_POST['pseudo'])) {
        $newPseudo = htmlspecialchars($_POST['pseudo']);
        $stmt = $pdo->prepare("UPDATE utilisateurs SET pseudo = ? WHERE id = ?");
        $stmt->execute([$newPseudo, $username]);
        $user['pseudo'] = $newPseudo;
    }

    // Modifier le mot de passe
    if (!empty($_POST['mot_de_passe'])) {
        $newPassword = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?");
        $stmt->execute([$newPassword, $username]);
    }

    // Upload photo de profil
    if (!empty($_FILES['photo']['name'])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            $stmt = $pdo->prepare("UPDATE utilisateurs SET photo_profil = ? WHERE id = ?");
            $stmt->execute([$fileName, $username]);
            $user['photo_profil'] = $fileName;
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
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($user['pseudo']) ?></h1>
    <img src="uploads/<?= htmlspecialchars($user['photo_profil']) ?>" width="150" alt="Photo de profil">

    <form action="compte.php" method="POST" enctype="multipart/form-data">
        <p>
            <label>Changer de pseudo : </label>
            <input type="text" name="pseudo" value="<?= htmlspecialchars($user['pseudo']) ?>">
        </p>
        <p>
            <label>Nouveau mot de passe : </label>
            <input type="password" name="mot_de_passe">
        </p>
        <p>
            <label>Changer la photo de profil : </label>
            <input type="file" name="photo">
        </p>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
