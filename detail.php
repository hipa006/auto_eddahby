<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';

// Récupérer l'ID de la voiture depuis l'URL (ex: detail.php?id=1)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Requête SQL pour récupérer les détails de la voiture
$stmt = $db->prepare("SELECT * FROM voitures WHERE id = ?");
$stmt->execute([$id]);
$voiture = $stmt->fetch(PDO::FETCH_ASSOC);

// Si la voiture n'existe pas, redirection vers la liste
if (!$voiture) {
    header("Location: voitures.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele']); ?> - Détails</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Bouton Retour */
        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            color: #d4a338;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-back:hover { text-decoration: underline; }

        /* Disposition principale */
        .detail-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        /* Section Image */
        .detail-image {
            flex: 1 1 450px;
            text-align: center;
        }
        .detail-image img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Section Infos */
        .detail-info {
            flex: 1 1 400px;
        }

        .detail-info h1 {
            margin: 0 0 10px 0;
            font-size: 2rem;
            color: #1a1a1a;
        }

        .price-tag {
            font-size: 1.8rem;
            font-weight: bold;
            color: #d4a338;
            margin-bottom: 25px;
        }

        /* Grille des 4 caractéristiques principales */
        .specs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .spec-item {
            background: #f8f9fa;
            border-left: 4px solid #d4a338;
            padding: 12px 15px;
            border-radius: 6px;
        }

        .spec-item label {
            display: block;
            font-size: 0.8rem;
            color: #777;
            text-transform: uppercase;
        }

        .spec-item span {
            font-size: 1.05rem;
            font-weight: 700;
            color: #222;
        }

        /* Description */
        .description-box {
            margin-bottom: 30px;
        }
        .description-box h3 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #333;
        }
        .description-box p {
            line-height: 1.6;
            color: #555;
        }

        /* Boutons de contact */
        .contact-actions {
            display: flex;
            gap: 15px;
        }
        .btn-contact {
            flex: 1;
            text-align: center;
            padding: 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            transition: 0.3s;
        }
        .btn-call {
            background-color: #d4a338;
            color: #ffffff;
        }
        .btn-call:hover {
            background-color: #b88b28;
        }
        .btn-whatsapp {
            background-color: #25D366;
            color: #ffffff;
        }
        .btn-whatsapp:hover {
            background-color: #1eb954;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="btn-back">&larr; Retour à la page d"Accueil</a>

    <div class="detail-wrapper">
        <!-- Image de la voiture -->
        <div class="detail-image">
            <img src="uploads/<?php echo htmlspecialchars($voiture['image']); ?>" alt="<?php echo htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele']); ?>">
        </div>

        <!-- Informations détaillées -->
        <div class="detail-info">
            <h1><?php echo htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele']); ?></h1>
            
            <div class="price-tag">
                <?php echo number_format($voiture['prix'], 2, ',', ' '); ?> DH
            </div>

            <!-- Caractéristiques sous forme de cartes -->
            <div class="specs-grid">
                <div class="spec-item">
                    <label>Année</label>
                    <span>📅 <?php echo htmlspecialchars($voiture['annee']); ?></span>
                </div>
                <div class="spec-item">
                    <label>Kilométrage</label>
                    <span>🛣️ <?php echo number_format($voiture['kilometrage'], 0, ' ', ' '); ?> km</span>
                </div>
                <div class="spec-item">
                    <label>Carburant</label>
                    <span>⛽ <?php echo htmlspecialchars($voiture['carburant']); ?></span>
                </div>
                <div class="spec-item">
                    <label>Marque</label>
                    <span>🚗 <?php echo htmlspecialchars($voiture['marque']); ?></span>
                </div>
            </div>

            <!-- Description -->
            <div class="description-box">
                <h3>Description</h3>
                <p><?php echo nl2br(htmlspecialchars($voiture['description'])); ?></p>
            </div>

            <!-- Boutons d'action -->
            <div class="contact-actions">
                <a href="contact.php" class="btn-contact btn-call">📞 Prendre un rendez_vous</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>