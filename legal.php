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
    <title>Mentions Légales - Vente de Voitures</title>
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

        .page-title span {
            color: #d4a338;
        }

        .page-subtitle {
            color: #666;
            margin-bottom: 30px;
        }

        /* Styles de la carte des mentions légales */
        .legal-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            line-height: 1.7;
            color: #444;
        }

        .legal-card h2 {
            font-size: 1.3rem;
            color: #111;
            margin-top: 25px;
            margin-bottom: 12px;
            border-left: 4px solid #d4a338;
            padding-left: 10px;
        }

        .legal-card h2:first-of-type {
            margin-top: 0;
        }

        .legal-card ul {
            margin: 10px 0 20px 20px;
            padding: 0;
        }

        .legal-card ul li {
            margin-bottom: 8px;
        }

        .legal-card p {
            margin-bottom: 15px;
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
            <li><a href="voitures.php" class="link">Voitures</a></li>
            <li><a href="legal.php" class="link" style="font-weight: bold; color: #d4a338;">Mentions legal</a></li>
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
        <h1 class="page-title">Mentions <span>Légales</span></h1>
        <p class="page-subtitle">Dernière mise à jour : <?php echo date('d/m/Y'); ?></p>

        <div class="legal-card">
            <h2>1. Éditeur du site</h2>
            <p>Le site <strong>Vente des voitures</strong> est édité dans le cadre d'une plateforme de vente et présentation de véhicules :</p>
            <ul>
                <li><strong>Nom du projet :</strong> Vente des voitures</li>
                <li><strong>Réalisateurs du projet :</strong> Hamidi Hibat Allah-Eddahby Khadija- Debdoubi Hiba-Dohkane Fatima Zahra </li>
                <li><strong>Email de contact :</strong>hmdhiba1@gmail.com / eddahbykhadija04@gmail.com</li>
            </ul>

            <h2>2. Hébergement</h2>
            <p>Le site et la base de données MySQL sont hébergés par :</p>
            <ul>
                <li><strong>Hébergeur :</strong> InfinityFree</li>
                <li><strong>Site Web :</strong> www.infinityfree.net</li>
            </ul>

            <h2>3. Propriété intellectuelle</h2>
            <p>Tout le contenu présent sur ce site (logos, textes, images, éléments graphiques) est la propriété exclusive de <strong>Vente des voitures</strong>, sauf mention contraire. Toute reproduction ou distribution sans autorisation préalable est interdite.</p>

            <h2>4. Protection des données personnelles</h2>
            <p>Conformément aux réglementations relatives à la protection des données, les informations collectées lors de votre inscription ou demandes de contact sont uniquement utilisées pour la gestion de nos services et ne seront pas cédées à des tiers.</p>

            <h2>5. Cookies</h2>
            <p>Le site utilise des cookies de session nécessaires à la navigation et à l'authentification des utilisateurs.</p>
        </div>
    </div>

    <!-- Footer -->
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