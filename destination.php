<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Site de Voyage - Destinations</title>
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
            min-height: 100vh;
        }
        header {
            text-align: center;
            margin-bottom: 50px;
        }
        header h1 {
            font-weight: 600;
            font-size: 3rem;
            color: #2c3e50;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.1);
        }
        .destinations {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(320px,1fr));
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
<header>
    <h1>Découvrez des Destinations de Voyage</h1>
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

