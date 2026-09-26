<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';

// Récupération de la recherche transmise via l'URL
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    // Si une recherche est faite : sélectionne TOUTES les voitures (anciennes + nouvelles) correspondant à la marque ou au modèle
    $stmt = $db->prepare("SELECT * FROM voitures WHERE marque LIKE ? OR modele LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$search%", "%$search%"]);
    $voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si aucun mot-clé : affiche TOUTES les voitures de la base de données
    $query = $db->query("SELECT * FROM voitures ORDER BY id DESC");
    $voitures = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toutes nos voitures - Vente de Voitures</title>
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

                 .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 15px 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
 /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-img {
            height: 40px;
        }

        .logo-text {
            font-size: 1.4rem;
            font-weight: bold;
            color: #111111;
        }

        .logo-text span {
            color: #d4a338;
        }

        /* Menu Navigation */
        .menu {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        .link {
            text-decoration: none;
            color: #333333;
            font-size: 0.95rem;
            font-weight: 500;
        }

 

        /* Bouton Connexion */
        .btn {
            background-color: #fdf8eb;
            color: #d4a338;
            border: 1px solid #f3e5be;
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .btn:hover {
            background-color: #d4a338;
            color: #ffffff;
        }

        /* Header avec l'image en arrière-plan complet */
        header { 
            text-align: center; 
            padding: 100px 20px; 
            border-bottom: 1px solid #eee;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('back.webp') center/cover no-repeat;
            color: #ffffff;
        }

        header img {
            display: none;
        }

       

        .h-text {
            font-size: 2.2rem;
            font-weight: bold;
            color: #ffffff;
            line-height: 1.2;
        }

        .h-text span {
            color: #d4a338;
        }

        header p {
            margin-top: 10px;
            font-size: 1.1rem;
            color: #dddddd;
        }

        /* Container Principal */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 2rem;
            color: #111;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: #666;
            margin-bottom: 30px;
        }

        /* Grille des Voitures */
        #cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        /* Carte Voiture */
        .car-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #f0f0f0;
            display: flex;
            flex-direction: column;
        }

        .car-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-image-wrapper {
            position: relative;
            width: 100%;
            height: 180px;
        }

        .card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .car-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #111;
            margin: 0 0 10px 0;
        }

        .car-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 15px;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid #f5f5f5;
        }

        .car-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #d4a338;
        }

        .btn-details {
            background-color: #d4a338;
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .btn-details:hover {
            background-color: #b88b28;
        }

        .no-cars {
            text-align: center;
            font-size: 1.2rem;
            color: #777;
            grid-column: 1 / -1;
            padding: 50px 0;
        }
        /* Container de la barre de recherche */
.search-box {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 550px;
    margin: 30px auto;
    gap: 0; /* Aligne parfaitement l'input et le bouton */
}

/* Champ de saisie (Input) */
.search-box input[type="text"] {
    flex: 1;
    padding: 12px 20px;
    font-size: 1rem;
    font-family: inherit;
    border: 1px solid #ddd;
    border-right: none; /* Enlève la bordure droite pour fusionner avec le bouton */
    border-radius: 25px 0 0 25px; /* Arrondi sur le côté gauche uniquement */
    outline: none;
    transition: all 0.3s ease;
    background-color: #ffffff;
}

.search-box input[type="text"]:focus {
    border-color: #d4a338;
    box-shadow: 0 0 8px rgba(212, 163, 56, 0.3);
}

/* Bouton de recherche */
.search-box button.btn {
    padding: 12px 24px;
    font-size: 0.95rem;
    font-weight: bold;
    color: #ffffff;
    background-color: #d4a338;
    border: 1px solid #d4a338;
    border-radius: 0 25px 25px 0; /* Arrondi sur le côté droit uniquement */
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.1s ease;
}

.search-box button.btn:hover {
    background-color: #b88b28;
    border-color: #b88b28;
}

.search-box button.btn:active {
    transform: scale(0.98);
}

/* Adaptation pour écrans mobiles */
@media (max-width: 600px) {
    .search-box {
        flex-direction: column;
        gap: 10px;
        padding: 0 15px;
    }

    .search-box input[type="text"] {
        border-right: 1px solid #ddd;
        border-radius: 25px;
        width: 100%;
        box-sizing: border-box;
    }

    .search-box button.btn {
        border-radius: 25px;
        width: 100%;
    }
}
    </style>
</head>
<body>

    <!-- Navigation -->
<nav class="navbar">
    <!-- Logo -->
    <a href="index.php" class="logo">
        <img src="logo.jpeg" alt="Logo" class="logo-img">
        <div class="logo-text">Vente <span>des voitures</span></div>
    </a>

    <!-- Navigation Links -->
    <ul class="menu">
        <li><a href="index.php" class="link">Accueil</a></li>
        <li><a href="#" class="link"  style="font-weight: bold; color: #d4a338;">Voitures</a></li>
        <li><a href="legal.php" class="link">Mentions legal</a></li>
        <li><a href="a-propos.php" class="link">À propos</a></li>
        <li><a href="contact.php" class="link">Contact</a></li>
    </ul>

    <!-- Zone Utilisateur / Connexion -->
    <div>
        <?php if (isset($_SESSION['id_user']) && !empty($_SESSION['nom_user'])): ?>
            <span style="margin-left: 20px; font-weight: 500; color: #333;">
                Salut, <strong><?php echo htmlspecialchars($_SESSION['nom_user']); ?></strong>
            </span>
            <a href="logout.php" style="color: #dc3545; margin-left: 15px; text-decoration: none; font-weight: bold;">Déconnexion</a>
        <?php else: ?>
            <a href="login.php" class="btn">Connexion</a>
        <?php endif; ?>
    </div>
</nav>
    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">Toutes nos voitures</h1>
        <p class="page-subtitle">Découvrez l'ensemble de nos véhicules disponibles à la vente.</p>
        <form action="voitures.php" method="GET" class="search-box" style="margin-bottom: 30px; text-align: center;">
    <input type="text" name="search" placeholder="Rechercher une voiture ?" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit" class="btn" style="cursor: pointer; padding: 12px 20px;">Rechercher</button>
</form>
        <div id="cars-grid">
            <?php if (!empty($voitures)): ?>
                <?php foreach ($voitures as $voiture): ?>
                    <div class="car-card">
                        <div class="card-image-wrapper">
                            <img src="uploads/<?php echo htmlspecialchars($voiture['image']); ?>" alt="<?php echo htmlspecialchars($voiture['marque']); ?>">
                        </div>

                        <div class="card-content">
                            <h3 class="car-title"><?php echo htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele']); ?></h3>
                            
                            <div class="car-specs">
                                <span>📅 <?php echo htmlspecialchars($voiture['annee']); ?></span>
                                <span>• ⛽ <?php echo htmlspecialchars($voiture['carburant']); ?></span>
                                <?php if (!empty($voiture['kilometrage'])): ?>
                                    <span>• 🛣️ <?php echo htmlspecialchars($voiture['kilometrage']); ?> km</span>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <span class="car-price"><?php echo number_format($voiture['prix'], 0, ' ', ' '); ?> MAD</span>
                                <a href="detail.php?id=<?php echo $voiture['id']; ?>" class="btn-details">Détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-cars">Aucune voiture n'est disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
 <footer class="footer">
    <div class="footer-container">
        <!-- Colonne 1 : À propos / Logo -->
        <div class="footer-col">
            <h3 class="footer-logo">Vente des <span>voitures</span></h3>
            <p class="footer-desc">
                Votre partenaire de confiance pour l'achat et la vente de véhicules d'occasion et neufs au meilleur prix au Maroc.
            </p>
        </div>

        <!-- Colonne 2 : Liens rapides -->
        <div class="footer-col">
            <h4>Navigation</h4>
            <ul class="footer-links">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="voitures.php">Nos Voitures</a></li>
                <li><a href="a-propos.php">À propos</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>

        <!-- Colonne 3 : Contact & Horaires -->
        <div class="footer-col">
            <h4>Contact</h4>
            <ul class="footer-contact">
                <li>📍 Casablanca, Maroc</li>
                <li>📞 053-456-7890</li>
                <li>✉️ vehiculecasa@gmail.com</li>
                <li>🕒 Lun - Sam: 9h00 - 19h00</li>
            </ul>
        </div>
    </div>

    <!-- Bas de page / Copyright -->
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Vente des voitures. Tous droits réservés.</p>
    </div>
</footer>

</body>
<style>
    /* Container global du footer */
.footer {
    background-color: #1a1a1a;
    color: #cccccc;
    padding-top: 50px;
    margin-top: 60px;
    border-top: 3px solid #d4a338;
    font-family: inherit;
}

/* Grille pour les colonnes */
.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px 40px 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
}

/* Titre / Logo dans le footer */
.footer-logo {
    color: #ffffff;
    font-size: 1.4rem;
    margin-bottom: 15px;
}

.footer-logo span {
    color: #d4a338;
}

.footer-desc {
    line-height: 1.6;
    font-size: 0.9rem;
    color: #aaa;
}

/* Titres des colonnes */
.footer-col h4 {
    color: #ffffff;
    font-size: 1.1rem;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 8px;
}

.footer-col h4::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 35px;
    height: 2px;
    background-color: #d4a338;
}

/* Listes de liens et contact */
.footer-links,
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: #aaa;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease, padding-left 0.3s ease;
}

.footer-links a:hover {
    color: #d4a338;
    padding-left: 5px;
}

.footer-contact li {
    margin-bottom: 12px;
    font-size: 0.9rem;
    color: #aaa;
}

/* Section Copyright */
.footer-bottom {
    background-color: #111111;
    text-align: center;
    padding: 15px 20px;
    border-top: 1px solid #2a2a2a;
    font-size: 0.85rem;
    color: #777777;
}

.footer-bottom p {
    margin: 0;
}

/* Responsive sur mobile */
@media (max-width: 768px) {
    .footer-container {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}
</style>
</html>