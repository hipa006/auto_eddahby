<?php 
session_start();
include 'config.php';

$query = $db->query("SELECT * FROM voitures ORDER BY id DESC LIMIT 4;");
$voitures = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vente de Voitures</title>
    <style>
        body {
            background-color: #f8f9fa;
            box-sizing: border-box;
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

        .article {
            display: flex;
            justify-content: space-between;
            background-color: #ffffff;
            padding: 10px 3%;
            box-shadow: 0 20px 10px rgba(0, 0, 0, 0.05);
        }

        .m {
            display: flex;
            gap: 130px;
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

        .link:hover, .link.active {
            color: #d4a338;
            text-decoration: underline;
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

        h1 { font-size: 2.5rem; margin-bottom: 15px; color: #0c0c0c; text-align: left; }

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

        .search-box {
            margin-top: 25px;
        }

        .search-box input { 
            padding: 14px 25px; 
            width: 350px; 
            max-width: 90%;
            border-radius: 25px; 
            border: 1px solid #ddd; 
            outline: none; 
            transition: 0.3s; 
            font-size: 1rem;
        }

        .search-box input:focus { 
            border-color: #d4a338; 
            box-shadow: 0 0 10px rgba(212, 163, 56, 0.5); 
        }

        /* Container de la section */
        .cars-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            font-size: 1.8rem;
            color: #111;
            margin: 0;
        }

        .see-all {
            color: #d4a338;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .see-all:hover {
            text-decoration: underline;
        }

        /* Dynamic Grid */
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }

        /* Modern Card Design */
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
            height: 170px;
        }

        .card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Badge 'À la une' */
        .badge-featured {
            position: absolute;
            top: 12px;
            left: 12px;
            background-color: #d4a338;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 4px;
        }

        /* Bouton Favoris */
        .btn-favorite {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.3);
            border: none;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .btn-favorite:hover {
            background: rgba(0, 0, 0, 0.6);
        }

        /* Card Body */
        .card-content {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .car-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #111;
            margin: 0 0 10px 0;
        }

        /* Specs (Année, Carburant, Kilométrage) */
        .car-specs {
            display: flex;
            gap: 12px;
            font-size: 0.82rem;
            color: #666;
            margin-bottom: 15px;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 4px;
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
            font-size: 1.15rem;
            font-weight: 700;
            color: #d4a338;
        }

        .btn-details {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: color 0.2s;
        }

        .btn-details:hover {
            color: #d4a338;
        }

        /* Container principal */
        .article {
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Alignement des cartes sur une ligne */
        .m {
            display: flex;
            justify-content: center;
            align-items: stretch;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 100px;
        }

        /* Style de chaque carte */
        .m li {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #e9ecef;
            border-top: 4px solid #d4a338;
            border-radius: 10px;
            padding: 15px 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .m li:hover {
            transform: translateY(-9px);
            box-shadow: 0 10px 20px rgba(212, 163, 56, 0.2);
        }

        .m li p {
            margin: 0;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1.3;
        }

        /* ================= SECTION CATALOGUE PDF ================= */
        .catalog-pdf-section {
            background-color: #ffffff;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            padding: 50px 20px;
            margin: 40px 0;
        }

        .catalog-pdf-box {
            max-width: 900px;
            margin: 0 auto;
            background: linear-gradient(135deg, #111111 0%, #2a2a2a 100%);
            border-radius: 15px;
            padding: 40px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            gap: 20px;
        }

        .catalog-pdf-content h2 {
            margin: 0 0 10px 0;
            font-size: 1.8rem;
            color: #ffffff;
        }

        .catalog-pdf-content h2 span {
            color: #d4a338;
        }

        .catalog-pdf-content p {
            margin: 0;
            color: #cccccc;
            font-size: 1rem;
        }

        .btn-pdf {
            background-color: #d4a338;
            color: #ffffff;
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(212, 163, 56, 0.3);
        }

        .btn-pdf:hover {
            background-color: #b88a28;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(212, 163, 56, 0.4);
        }

        @media (max-width: 768px) {
            .catalog-pdf-box {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <!-- Logo -->
    <a href="index.php" class="logo">
        <img src="logo.jpeg" alt="Logo" class="logo-img">
        <div class="logo-text">Vente <span>des voitures</span></div>
    </a>

    <!-- Navigation Links -->
    <ul class="menu">
        <li><a href="#" class="link" style="font-weight: bold; color: #d4a338;">Accueil</a></li>
        <li><a href="voitures.php" class="link">Voitures</a></li>
        <li><a href="legal.php" class="link">Mentions legal</a></li>
        <li><a href="a-propos.php" class="link">À propos</a></li>
        <li><a href="contact.php" class="link">Contact</a></li>
    </ul>

    <!-- Zone Utilisateur / Connexion -->
    <div>
        <?php if (!empty($_SESSION['user_nom'])): ?>
            <span style="margin-left: 20px; font-weight: 500; color: #333;">
                Salut, <strong><?php echo htmlspecialchars($_SESSION['user_nom']); ?></strong>
            </span>
            <a href="logout.php" style="color: #dc3545; margin-left: 15px; text-decoration: none; font-weight: bold;">Déconnexion</a>
        <?php else: ?>
            <a href="login.php" class="btn">Connexion</a>
        <?php endif; ?>
    </div>
</nav>
    <header> 
        <div>
            <img src="back.webp" alt="">

            <div class="h">
                <div class="h-text">Trouvez la voiture qui<br><span>vous correspond</span></div>
                <p>Des véhicules fiables, bien entretenus et à des prix compétitifs.</p>
            </div> 

        </div>
    </header>
    
<article class="article">
    <ul class="m">
        <li><p>Large choix <br>des voitures</p></li>
        <li><p>Véhicules vérifiés <br>et garantis</p></li>
        <li><p>Prix compétitifs</p></li>
        <li><p>Service client <br>à votre écoute</p></li>
        <li><p>Transaction sécurisée</p></li>
    </ul>
</article>

    <!-- SECTION BANNIÈRE CATALOGUE PDF -->
    <section class="catalog-pdf-section">
        <div class="catalog-pdf-box">
            <div class="Catalog-pdf-content">
                <h2>Découvrez notre <span>Catalogue PDF</span></h2>
                <p>Téléchargez ou consultez l'intégralité de nos véhicules disponibles en format PDF.</p>
            </div>
            <!-- Modifiez 'catalogue.pdf' ci-dessous par le chemin exact vers votre fichier PDF -->
            <a href="Catalogue.pdf" target="_blank" class="btn-pdf">
                📄 Télécharger le catalogue
            </a>
        </div>
    </section>

    <section class="cars-section">
        <div class="section-header">
            <h2>Nos voitures à la une</h2>
            <a href="voitures.php" class="see-all">Voir toutes les voitures &rarr;</a>
        </div>

        <div class="cars-grid">
            <?php foreach ($voitures as $voiture): ?>
                <div class="car-card">
                    <div class="card-image-wrapper">
                        <span class="badge-featured">À la une</span>
                    
                        <img src="uploads/<?php echo htmlspecialchars($voiture['image']); ?>" alt="<?php echo htmlspecialchars($voiture['marque']); ?>">
                    </div>

                    <div class="card-content">
                        <h3 class="car-title"><?php echo htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele']); ?></h3>
                        
                        <div class="car-specs">
                            <span class="spec-item">📅 <?php echo htmlspecialchars($voiture['annee']); ?></span>
                            <span class="spec-item">• <?php echo htmlspecialchars($voiture['carburant']); ?></span>
                            <?php if (isset($voiture['kilometrage'])): ?>
                                <span class="spec-item">• 🛣️ <?php echo htmlspecialchars($voiture['kilometrage']); ?> km</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer">
                            <span class="car-price"><?php echo number_format($voiture['prix'], 0, ' ', ' '); ?> MAD</span>
                            <a href="detail.php?id=<?php echo $voiture['id']; ?>" class="btn-details">voir détails &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    
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