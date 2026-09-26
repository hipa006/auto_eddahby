<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';

$message_status = "";

// Traitement du formulaire de réservation
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom_complet']);
    $email = trim($_POST['email']);
    $tel = trim($_POST['telephone']);
    $date = $_POST['date_rdv'];
    $heure = $_POST['heure_rdv'];
    $motif = $_POST['motif'];
    $msg = trim($_POST['message']);

    if (!empty($nom) && !empty($email) && !empty($tel) && !empty($date) && !empty($heure) && !empty($motif)) {
        try {
            $stmt = $db->prepare("INSERT INTO rendez_vous (nom_complet, email, telephone, date_rdv, heure_rdv, motif, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $email, $tel, $date, $heure, $motif, $msg]);
            $message_status = "<div class='alert success'>✅ Votre demande de rendez-vous a été enregistrée avec succès ! Nous vous contacterons pour confirmation.</div>";
        } catch (PDOException $e) {
            $message_status = "<div class='alert error'>❌ Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.</div>";
        }
    } else {
        $message_status = "<div class='alert error'>⚠️ Veuillez remplir tous les champs obligatoires.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Prise de Rendez-vous - Vente des voitures</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333333;
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
        .btn_cnx {
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

        .btn_cnx:hover {
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
        /* Hero Banner */
        .contact-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('back.webp') center/cover no-repeat;
            color: #ffffff;
            text-align: center;
            padding: 70px 20px;
        }

        .contact-hero h1 {
            font-size: 2.3rem;
            margin-bottom: 10px;
        }

        .contact-hero h1 span {
            color: #d4a338;
        }

        .contact-hero p {
            color: #dddddd;
            font-size: 1.05rem;
        }

        /* Main Container */
        .contact-container {
            max-width: 1100px;
            margin: -40px auto 60px auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        /* Messages de confirmation / Erreur */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Double Colonne (Infos + Formulaire) */
        .contact-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        /* Colonne Gauche : Infos de contact */
        .contact-info {
            flex: 1 1 350px;
            background: #ffffff;
            border-radius: 12px;
            padding: 35px 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border-top: 4px solid #d4a338;
        }

        .contact-info h2 {
            font-size: 1.5rem;
            color: #1a1a1a;
            margin-top: 0;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-icon {
            font-size: 1.5rem;
            background: #fdf8eb;
            color: #d4a338;
            padding: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            box-sizing: border-box;
        }

        .info-text h4 {
            margin: 0 0 5px 0;
            color: #1a1a1a;
            font-size: 1rem;
        }

        .info-text p {
            margin: 0;
            color: #666;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        /* Colonne Droite : Formulaire RDV */
        .contact-form-card {
            flex: 1 1 500px;
            background: #ffffff;
            border-radius: 12px;
            padding: 35px 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border-top: 4px solid #d4a338;
        }

        .contact-form-card h2 {
            font-size: 1.5rem;
            color: #1a1a1a;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: #444;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 15px;
            font-size: 0.95rem;
            font-family: inherit;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.3s;
            background-color: #fdfdfd;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #d4a338;
            box-shadow: 0 0 5px rgba(212, 163, 56, 0.3);
        }

        /* Bouton Valider */
        .btn-submit {
            background-color: #d4a338;
            color: #ffffff;
            font-size: 1rem;
            font-weight: bold;
            padding: 14px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s, transform 0.1s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #b88b28;
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: span 1;
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
        <li><a href="index.php" class="link active">Accueil</a></li>
        <li><a href="voitures.php" class="link">Voitures</a></li>
        <li><a href="legal.php" class="link">Mentions legal</a></li>
        <li><a href="a-propos.php" class="link">À propos</a></li>
        <li><a href="#" class="link"  style="font-weight: bold; color: #d4a338;">Contact</a></li>
    </ul>
    <!-- Zone Utilisateur / Connexion -->
    <div>
        <?php if (isset($_SESSION['id_user']) && !empty($_SESSION['nom_user'])): ?>
            <span style="margin-left: 20px; font-weight: 500; color: #333;">
                Salut, <strong><?php echo htmlspecialchars($_SESSION['nom_user']); ?></strong>
            </span>
            <a href="logout.php" style="color: #dc3545; margin-left: 15px; text-decoration: none; font-weight: bold;">Déconnexion</a>
        <?php else: ?>
            <a href="login.php" class="btn_cnx">Connexion</a>
        <?php endif; ?>
    </div>
</nav>
<!-- Bannière d'en-tête -->
<section class="contact-hero">
    <h1>Contact & <span>Prise de Rendez-vous</span></h1>
    <p>Une question ? Envie d'essayer un véhicule ? Réservez votre créneau en quelques clics.</p>
</section>

<div class="contact-container">

    <?php echo $message_status; ?>

    <div class="contact-wrapper">

        <!-- Colonne Gauche : Coordonnées -->
        <div class="contact-info">
            <h2>Nos Coordonnées</h2>

            <div class="info-item">
                <div class="info-icon">📍</div>
                <div class="info-text">
                    <h4>Adresse</h4>
                    <p>Casablanca, Maroc</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📞</div>
                <div class="info-text">
                    <h4>Téléphone</h4>
                    <p>053-456-7890</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">✉️</div>
                <div class="info-text">
                    <h4>Email</h4>
                    <p>vehiculecasa@gmail.com</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">🕒</div>
                <div class="info-text">
                    <h4>Horaires d'ouverture</h4>
                    <p>Lundi - Samedi : 09h00 - 19h00<br>Dimanche : Fermé</p>
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Formulaire -->
        <div class="contact-form-card">
            <h2>Réserver un rendez-vous</h2>

            <form action="contact.php" method="POST">
                <div class="form-grid">
                    
                    <div class="form-group full-width">
                        <label for="nom_complet">Nom complet *</label>
                        <input type="text" name="nom_complet" id="nom_complet" placeholder required>
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse Email *</label>
                        <input type="email" name="email" id="email" placeholder required>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Numéro de Téléphone *</label>
                        <input type="tel" name="telephone" id="telephone" placeholder required>
                    </div>

                    <div class="form-group">
                        <label for="date_rdv">Date souhaitée *</label>
                        <input type="date" name="date_rdv" id="date_rdv" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="heure_rdv">Heure souhaitée *</label>
                        <select name="heure_rdv" id="heure_rdv" required>
                            <option value="">Choisissez l'heure</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="motif">Motif du rendez-vous *</label>
                        <select name="motif" id="motif" required>
                            <option value="">Sélectionnez un motif</option>
                            <option value="Essai de véhicule">Essai de véhicule</option>
                            <option value="Achat de véhicule">Information / Achat de véhicule</option>
                            <option value="Service Après-Vente">Service Après-Vente / Entretien</option>
                            <option value="Autre">Autre demande</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="message">Message ou précision (Optionnel)</label>
                        <textarea name="message" id="message" rows="4" placeholder="Précisez le modèle qui vous intéresse ou toute autre remarque..."></textarea>
                    </div>

                </div>

                <button type="submit" class="btn-submit">Confirmer le rendez-vous</button>
            </form>
        </div>

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