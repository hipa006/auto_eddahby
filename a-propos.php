<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - Vente des voitures</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333333;
        }

        /* Hero Banner */
        .about-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('back.webp') center/cover no-repeat;
            color: #ffffff;
            text-align: center;
            padding: 80px 20px;
        }

        .about-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .about-hero h1 span {
            color: #d4a338;
        }

        .about-hero p {
            font-size: 1.1rem;
            color: #dddddd;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Container principal */
        .about-container {
            max-width: 1100px;
            margin: -40px auto 60px auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        /* Carte Présentation */
        .about-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-top: 4px solid #d4a338;
            margin-bottom: 40px;
        }

        .about-card h2 {
            font-size: 1.8rem;
            color: #1a1a1a;
            margin-top: 0;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .about-card h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: #d4a338;
        }

        .about-card p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555555;
            margin: 0;
        }

        /* Section Nos Engagements / Valeurs */
        .values-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .value-box {
            flex: 1 1 280px;
            background: #ffffff;
            border-radius: 10px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .value-box:hover {
            transform: translateY(-9px);
            box-shadow: 0 10px 20px rgba(212, 163, 56, 0.2);
        }

        .value-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: inline-block;
        }

        .value-box h3 {
            font-size: 1.2rem;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .value-box p {
            font-size: 0.95rem;
            color: #666666;
            line-height: 1.5;
            margin: 0;
        }

        /* Appels à l'action (CTA) */
        .about-cta {
            text-align: center;
            margin-top: 50px;
            background: #1a1a1a;
            color: #ffffff;
            padding: 40px 20px;
            border-radius: 12px;
        }

        .about-cta h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .about-cta p {
            color: #aaa;
            margin-bottom: 25px;
        }

        .btn-gold {
            display: inline-block;
            background-color: #d4a338;
            color: #ffffff;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-gold:hover {
            background-color: #b88b28;
            transform: scale(1.03);
        }

        @media (max-width: 768px) {
            .about-hero h1 { font-size: 2rem; }
            .about-card { padding: 25px 20px; }
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
        <li><a href="index.php" class="link">Accueil</a></li>
        <li><a href="voitures.php" class="link">Voitures</a></li>
        <li><a href="legal.php" class="link">Mentions legal</a></li>
        <li><a href="#" class="link"  style="font-weight: bold; color: #d4a338;">À propos</a></li>
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
<!-- En-tête / Hero Section -->
<section class="about-hero">
    <h1>À propos de <span>Notre Concession</span></h1>
    <p>Découvrez notre passion pour l'automobile et notre engagement envers nos clients.</p>
</section>

<!-- Contenu Principal -->
<div class="about-container">

    <!-- Présentation principale -->
    <div class="about-card">
        <h2>Qui sommes-nous ?</h2>
        <p>
            Bienvenue sur notre plateforme dédiée à la vente de véhicules neufs. Nous mettons à votre disposition un large éventail de voitures modernes, alliant sécurité, performance et confort. Notre objectif est de vous offrir une expérience d'achat transparente, simple et personnalisée.
        </p>
    </div>

    <!-- Piliers & Engagements -->
    <div class="values-grid">
        <div class="value-box">
            <span class="value-icon">🛡️</span>
            <h3>Sécurité Avant Tout</h3>
            <p>Des véhicules rigoureusement contrôlés répondant aux normes de sécurité les plus strictes.</p>
        </div>

        <div class="value-box">
            <span class="value-icon">⚡</span>
            <h3>Performance & Confort</h3>
            <p>Une sélection de modèles modernes dotés des meilleures technologies du marché.</p>
        </div>

        <div class="value-box">
            <span class="value-icon">🤝</span>
            <h3>Transparence Totale</h3>
            <p>Une expérience d'achat claire, sans frais cachés, adaptée à vos besoins et votre budget.</p>
        </div>
    </div>

    <!-- Appel à l'action -->
    <div class="about-cta">
        <h3>Prêt à trouver votre prochaine voiture ?</h3>
        <p>Explorez notre catalogue de véhicules disponibles dès maintenant.</p>
        <a href="voitures.php" class="btn-gold">Découvrir nos voitures</a>
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