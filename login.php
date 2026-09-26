<?php 
// Sécurité : Démarrage de la session si elle ne l'est pas déjà
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php'; 

$erreur = "";

// ==================== DYNAMIQUE : RÉCUPÉRATION DES RÔLES DEPUIS LA BDD ====================
$stmt_roles = $db->query("SELECT DISTINCT role_user FROM user ORDER BY role_user DESC");
$liste_roles = $stmt_roles->fetchAll(PDO::FETCH_COLUMN); 

// ==================== TRAITEMENT DE LA CONNEXION 
if (isset($_POST['connexion'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role_choisi = trim($_POST['role']); 

    if (!empty($email) && !empty($password) && !empty($role_choisi)) {
        // On récupère l'utilisateur par son email
        $stmt = $db->prepare("SELECT * FROM user WHERE email_user = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Utilisation de FETCH_ASSOC

        // On vérifie le mot de passe ET si le rôle en BDD correspond au rôle choisi
        if ($user && $password === $user['mot_de_passe'] && $user['role_user'] === $role_choisi) {
            
         // ✅ Stockage cohérent des variables de session pour admin.php
$_SESSION['user_id']   = $user['id_user'] ?? $user['id'];
$_SESSION['user_nom']  = $user['nom_user'] ?? $user['nom'];
$_SESSION['user_role'] = strtolower(trim($user['role_user'])); // Sensibilité aux majuscules/espaces gérée

// Redirection selon le rôle
if ($_SESSION['user_role'] === 'admin') {
    header("Location: admin.php");
} else {
    header("Location: index.php");
}
exit;
        } else {
            $erreur = "Email, mot de passe ou rôle incorrect.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-box {
    background: #ffffff;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    width: 350px;
    border: 1px solid #f0f0f0;
}

.login-box h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #111111;
    font-size: 1.6rem;
    font-weight: 700;
}

.login-box h2 span {
    color: #d4a338;
}

label {
    font-weight: 600;
    color: #333333;
    font-size: 13px;
    display: block;
    margin-top: 12px;
    margin-bottom: 5px;
}

input, select {
    width: 100%;
    padding: 12px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-sizing: border-box;
    font-family: inherit;
    font-size: 14px;
    background-color: #ffffff;
    color: #333;
    transition: all 0.2s ease;
    outline: none;
}

input:focus, select:focus {
    border-color: #d4a338;
    box-shadow: 0 0 0 3px rgba(212, 163, 56, 0.15);
}

.btn-submit {
    background-color: #111111;
    color: #ffffff;
    border: none;
    width: 100%;
    padding: 12px;
    cursor: pointer;
    font-weight: 600;
    font-size: 15px;
    border-radius: 8px;
    margin-top: 20px;
    transition: background-color 0.2s ease, transform 0.1s ease;
}

.btn-submit:hover {
    background-color: #d4a338;
}

.btn-submit:active {
    transform: scale(0.98);
}

.error {
    color: #dc2626;
    background-color: #fee2e2;
    border: 1px solid #fca5a5;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    font-size: 13px;
    margin-bottom: 15px;
    font-weight: 500;
}

.switch-link {
    margin-top: 20px;
    font-size: 13px;
    color: #666666;
    text-align: center;
}

.switch-link a {
    color: #d4a338;
    text-decoration: none;
    font-weight: bold;
}

.switch-link a:hover {
    text-decoration: underline;
}
    </style>
</head>
<body>

<div class="login-box">
    <h2>Connexion <span>...</span></h2>
    
    <?php if(!empty($erreur)): ?>
        <p class="error"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Adresse Email :</label>
        <input type="email" name="email" required placeholder>
        
        <label>Mot de passe :</label>
        <input type="password" name="password" required placeholder>
        
        <label>Se connecter en tant que :</label>
        <select name="role" required>
            <option value="" disabled selected>Choisissez votre rôle</option>
            <?php foreach ($liste_roles as $role): ?>
                <option value="<?= htmlspecialchars($role) ?>">
                    <?= ucfirst(htmlspecialchars($role)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" name="connexion" class="btn-submit">Se connecter</button>
    </form>
    
    <div class="switch-link">
        Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a>
    </div>
</div>

</body>
</html>