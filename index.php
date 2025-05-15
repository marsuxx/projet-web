<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Accueil</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #333;
        padding: 40px 20px;
        min-height: 100vh;
        box-sizing: border-box;
    }
    body {
        display: flex;
        flex-direction: column;
        position: relative;
    }
    /* Top right buttons container */
    .top-right {
        position: absolute;
        top: 40px;
        right: 40px;
        display: flex;
        gap: 15px;
        font-size: 14px;
        font-weight: 600;
    }
    .small-button {
        background: none;
        border: none;
        color: #333;
        cursor: pointer;
        text-decoration: none;
        padding: 0;
        font-size: 14px;
        transition: text-decoration 0.3s ease;
    }
    .small-button:hover {
        text-decoration: underline;
    }
    /* Content header */
    .header-area {
        padding-top: 80px; /* to give space for top right buttons */
        text-align: center;
        flex-shrink: 0;
    }
    h1 {
        margin-bottom: 20px;
        font-weight: 700;
        color: #333;
    }
    /* Navigation container */
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
    /* White background area below navigation */
    .white-area {
        background-color: white;
        color: #333;
        flex-grow: 1;
        padding: 40px 30px;
        box-sizing: border-box;
        width: 100%;
        margin-top: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
</head>
<body>

<div class="top-right">
    <a href="inscription.php" class="small-button">Inscription</a>
    <a href="connexion.php" class="small-button">Connexion</a>
</div>

<div class="header-area">
    <h1>Bienvenue sur la page d'accueil</h1>
    <nav class="main-nav">
        <a href="accueil.php" class="nav-button">Accueil</a>
        <a href="apropos.php" class="nav-button">À propos</a>
        <a href="contact.php" class="nav-button">Contact</a>
        <a href="destinations.php" class="nav-button">Destinations</a>
    </nav>
</div>

<div class="white-area">
    <!-- Content area below navigation with white background -->
    <p>Ici, le contenu de la page peut être placé avec fond blanc.</p>
</div>

</body>
</html>
