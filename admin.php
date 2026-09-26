<?php
include 'config.php';

// 1. SÉCURITÉ : Vérification de l'accès Administrateur
if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    header("Location: login.php");
    exit;
}

// Variables pour l'édition d'une voiture
$id_edit = null;
$voiture_edit = [
    'marque' => '', 'modele' => '', 'prix' => '', 
    'annee' => '', 'kilometrage' => '', 'carburant' => 'Essence', 
    'description' => '', 'image' => ''
];

// --- GESTION DES ACTIONS DES VOITURES ---

// Suppression d'un véhicule
if (isset($_GET['supprimer_voiture'])) {
    $id_sup = intval($_GET['supprimer_voiture']);
    $stmt = $db->prepare("DELETE FROM voitures WHERE id = ?");
    $stmt->execute([$id_sup]);
    header("Location: admin.php");
    exit;
}

// Chargement des données pour modification
if (isset($_GET['modifier_voiture'])) {
    $id_edit = intval($_GET['modifier_voiture']);
    $stmt = $db->prepare("SELECT * FROM voitures WHERE id = ?");
    $stmt->execute([$id_edit]);
    $voiture_edit = $stmt->fetch() ?: $voiture_edit;
}

// Traitement du formulaire (Ajout / Modification)
if (isset($_POST['enregistrer_voiture'])) {
    $marque = trim($_POST['marque']);
    $modele = trim($_POST['modele']);
    $prix = floatval($_POST['prix']);
    $annee = intval($_POST['annee']);
    $kilometrage = intval($_POST['kilometrage']);
    $carburant = trim($_POST['carburant']);
    $description = trim($_POST['description']);
    $id_voiture = isset($_POST['id_voiture']) ? intval($_POST['id_voiture']) : null;

    // Traitement de l'image
    $nom_image = $_POST['image_actuelle'] ?? 'default.jpg';
    if (isset($_FILES['image_voiture']) && $_FILES['image_voiture']['error'] === 0) {
        $dossier = 'uploads/';
        if (!file_exists($dossier)) { mkdir($dossier, 0777, true); }
        $ext = pathinfo($_FILES['image_voiture']['name'], PATHINFO_EXTENSION);
        $nom_image = time() . '_' . bin2hex(random_bytes(3)) . '.' . $ext;
        move_uploaded_file($_FILES['image_voiture']['tmp_name'], $dossier . $nom_image);
    }

    if (!empty($marque) && !empty($modele)) {
        if ($id_voiture) {
            $stmt = $db->prepare("UPDATE voitures SET marque = ?, modele = ?, prix = ?, annee = ?, kilometrage = ?, carburant = ?, description = ?, image = ? WHERE id = ?");
            $stmt->execute([$marque, $modele, $prix, $annee, $kilometrage, $carburant, $description, $nom_image, $id_voiture]);
        } else {
            $stmt = $db->prepare("INSERT INTO voitures (marque, modele, prix, annee, kilometrage, carburant, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$marque, $modele, $prix, $annee, $kilometrage, $carburant, $description, $nom_image]);
        }
        header("Location: admin.php");
        exit;
    }
}

// --- GESTION DES ACTIONS DES RENDEZ-VOUS ---

if (isset($_GET['supprimer_rdv'])) {
    $id_rdv = intval($_GET['supprimer_rdv']);
    $stmt = $db->prepare("DELETE FROM rendez_vous WHERE id = ?");
    $stmt->execute([$id_rdv]);
    header("Location: admin.php");
    exit;
}

// --- CHARGEMENT DES DONNÉES ---
$liste_voitures = $db->query("SELECT * FROM voitures ORDER BY id DESC")->fetchAll();
$liste_rdv = $db->query("SELECT * FROM rendez_vous ORDER BY date_rdv DESC, heure_rdv DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Vente des voitures</title>
    <style>
        :root {
            --bg-body: #f8f9fa;
            --card-bg: #ffffff;
            --primary: #d4a373;
            --primary-dark: #c18c5d;
            --text-main: #333333;
            --text-muted: #6c757d;
            --border-color: #e9ecef;
            --danger: #d9534f;
        }

        body { 
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bg-body); 
            color: var(--text-main); 
            margin: 0; 
            padding: 30px 20px; 
        }

        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            display: flex; 
            flex-direction: column; 
            gap: 25px; 
        }

        /* En-tête */
        .header { 
            background: var(--card-bg); 
            padding: 20px 30px; 
            border-radius: 12px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            border: 1px solid var(--border-color);
        }

        .header h2 { 
            margin: 0; 
            color: var(--primary); 
            font-size: 22px; 
            font-weight: 700;
        }

        .header span { 
            color: var(--text-muted); 
            font-size: 14px; 
        }

        /* Grille & Cartes */
        .grid { 
            display: grid; 
            grid-template-columns: 1fr 2fr; 
            gap: 25px; 
        }

        .card { 
            background: var(--card-bg); 
            padding: 25px; 
            border-radius: 12px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--primary);
        }

        .card h3 { 
            margin-top: 0; 
            color: var(--primary-dark); 
            font-size: 18px; 
            font-weight: 700;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        /* Formulaires */
        label { 
            font-size: 13px; 
            font-weight: 600; 
            color: var(--text-main); 
            margin-top: 12px; 
            display: block; 
        }

        input, select, textarea { 
            width: 100%; 
            padding: 10px; 
            margin-top: 5px; 
            background: #ffffff; 
            border: 1px solid #ced4da; 
            color: var(--text-main); 
            border-radius: 6px; 
            box-sizing: border-box; 
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--primary);
        }

        /* Boutons */
        .btn { 
            padding: 8px 16px; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            text-decoration: none; 
            font-weight: 600; 
            font-size: 13px; 
            display: inline-block; 
            transition: all 0.2s;
        }

        .btn-primary { 
            background: var(--primary); 
            color: #ffffff; 
            width: 100%; 
            margin-top: 18px; 
            padding: 11px; 
            text-align: center;
        }

        .btn-primary:hover { 
            background: var(--primary-dark); 
        }

        .btn-outline { 
            border: 1px solid var(--primary); 
            color: var(--primary-dark); 
            background: transparent; 
        }

        .btn-outline:hover { 
            background: var(--primary); 
            color: #ffffff; 
        }

        .btn-danger { 
            color: var(--danger); 
            text-decoration: none; 
            font-weight: 600; 
        }

        /* Tableaux */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }

        th, td { 
            padding: 12px; 
            border-bottom: 1px solid var(--border-color); 
            text-align: left; 
            font-size: 13.5px; 
        }

        th { 
            background: #f8f9fa; 
            color: var(--text-muted); 
            font-weight: 600; 
        }

        tr:hover { 
            background: #fafafa; 
        }

        .img-thumb { 
            width: 55px; 
            height: 40px; 
            object-fit: cover; 
            border-radius: 6px; 
            border: 1px solid var(--border-color);
        }

        .badge { 
            background: #f0f0f0; 
            color: var(--text-main); 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 11px; 
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- En-tête -->
    <div class="header">
        <div>
            <h2>Vente des voitures | Administration 🚘</h2>
            <span>Salut, <strong><?= htmlspecialchars($_SESSION['user_nom'] ?? 'Directeur') ?></strong></span>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="index.php" class="btn btn-outline">Voir le site</a>
            <a href="logout.php" class="btn-danger" style="margin-left: 10px;">Déconnexion</a>
        </div>
    </div>

    <!-- Section Voitures -->
    <div class="grid">
        
        <!-- Formulaire -->
        <div class="card">
            <h3><?= $id_edit ? "✏️ Modifier le véhicule" : "➕ Ajouter un véhicule" ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <?php if ($id_edit): ?>
                    <input type="hidden" name="id_voiture" value="<?= $id_edit ?>">
                    <input type="hidden" name="image_actuelle" value="<?= htmlspecialchars($voiture_edit['image']) ?>">
                <?php endif; ?>

                <label>Marque :</label>
                <input type="text" name="marque" value="<?= htmlspecialchars($voiture_edit['marque']) ?>" required placeholder>

                <label>Modèle :</label>
                <input type="text" name="modele" value="<?= htmlspecialchars($voiture_edit['modele']) ?>" required placeholder>

                <div style="display:flex; gap:10px;">
                    <div>
                        <label>Prix (€) :</label>
                        <input type="number" step="0.01" name="prix" value="<?= htmlspecialchars($voiture_edit['prix']) ?>" required placeholder>
                    </div>
                    <div>
                        <label>Année :</label>
                        <input type="number" name="annee" value="<?= htmlspecialchars($voiture_edit['annee']) ?>" placeholder>
                    </div>
                </div>

                <div style="display:flex; gap:10px;">
                    <div>
                        <label>Kilométrage :</label>
                        <input type="number" name="kilometrage" value="<?= htmlspecialchars($voiture_edit['kilometrage']) ?>" placeholder>
                    </div>
                    <div>
                        <label>Carburant :</label>
                        <select name="carburant">
                            <option value="Diesel" <?= $voiture_edit['carburant'] === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                            <option value="Essence" <?= $voiture_edit['carburant'] === 'Essence' ? 'selected' : '' ?>>Essence</option>
                            <option value="Hybride" <?= $voiture_edit['carburant'] === 'Hybride' ? 'selected' : '' ?>>Hybride</option>
                            <option value="Électrique" <?= $voiture_edit['carburant'] === 'Électrique' ? 'selected' : '' ?>>Électrique</option>
                        </select>
                    </div>
                </div>

                <label>Description :</label>
                <textarea name="description" rows="3" placeholder="Description du véhicule..."><?= htmlspecialchars($voiture_edit['description']) ?></textarea>

                <label>Image du véhicule :</label>
                <input type="file" name="image_voiture" accept="image/*">

                <button type="submit" name="enregistrer_voiture" class="btn btn-primary">
                    <?= $id_edit ? "Enregistrer les modifications" : "Ajouter le véhicule" ?>
                </button>
                <?php if ($id_edit): ?>
                    <a href="admin.php" class="btn btn-outline" style="width:100%; text-align:center; margin-top:8px; box-sizing:border-box;">Annuler</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Tableau des véhicules -->
        <div class="card">
            <h3>🚗 Parc Automobile (<?= count($liste_voitures) ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Visuel</th>
                        <th>Véhicule</th>
                        <th>Prix</th>
                        <th>Carburant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($liste_voitures as $v): ?>
                        <?php 
                            $image_path = 'uploads/' . $v['image'];
                            if (!file_exists($image_path) && file_exists('images/' . $v['image'])) {
                                $image_path = 'images/' . $v['image'];
                            }
                        ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($image_path) ?>" 
                                     onerror="this.src='https://placehold.co/55x40?text=Auto'" 
                                     class="img-thumb" alt="Véhicule">
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($v['marque']) ?> <?= htmlspecialchars($v['modele']) ?></strong><br>
                                <small style="color:var(--text-muted);"><?= $v['annee'] ?> • <?= number_format($v['kilometrage'], 0, ',', ' ') ?> km</small>
                            </td>
                            <td><strong style="color:var(--primary-dark);"><?= number_format($v['prix'], 2, ',', ' ') ?> €</strong></td>
                            <td><span class="badge"><?= htmlspecialchars($v['carburant']) ?></span></td>
                            <td>
                                <a href="admin.php?modifier_voiture=<?= $v['id'] ?>" style="color:var(--primary-dark); text-decoration:none; font-weight:600;">✏️</a>
                                <a href="admin.php?supprimer_voiture=<?= $v['id'] ?>" onclick="return confirm('Supprimer ce véhicule ?');" class="btn-danger" style="margin-left:10px;">🗑️</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Section Rendez-vous -->
    <div class="card">
        <h3>📅 Rendez-vous Clients (<?= count($liste_rdv) ?>)</h3>
        <table>
            <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Contact</th>
                    <th>Date & Heure</th>
                    <th>Motif</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($liste_rdv)): ?>
                    <tr><td colspan="6" style="text-align:center; color:var(--text-muted); padding:20px;">Aucun rendez-vous enregistré.</td></tr>
                <?php else: ?>
                    <?php foreach ($liste_rdv as $rdv): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($rdv['nom_complet']) ?></strong></td>
                            <td>
                                📧 <?= htmlspecialchars($rdv['email']) ?><br>
                                📞 <?= htmlspecialchars($rdv['telephone']) ?>
                            </td>
                            <td><strong style="color:var(--primary-dark);"><?= $rdv['date_rdv'] ?></strong> à <?= $rdv['heure_rdv'] ?></td>
                            <td><span class="badge"><?= htmlspecialchars($rdv['motif']) ?></span></td>
                            <td><small style="color:var(--text-muted);"><?= htmlspecialchars($rdv['message']) ?></small></td>
                            <td>
                                <a href="admin.php?supprimer_rdv=<?= $rdv['id'] ?>" onclick="return confirm('Supprimer ce rendez-vous ?');" class="btn-danger" style="font-size:12px;">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>