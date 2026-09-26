<?php
include 'config.php';

$message = "";
$type_message = ""; // Pour gérer le style du message (succès ou erreur)

if (isset($_POST['inscrire'])) {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($nom) && !empty($email) && !empty($password)) {
        // Vérifier si l'email existe déjà
        $verif = $db->prepare("SELECT * FROM user WHERE email_user = ?");
        $verif->execute([$email]);
        
        if ($verif->rowCount() > 0) {
            $message = "Cet email est déjà utilisé par un autre compte.";
            $type_message = "error";
        } else {
            // Insertion du nouvel utilisateur (Rôle 'user' par défaut)
            $stmt = $db->prepare("INSERT INTO user (nom_user, email_user, mot_de_passe, role_user) VALUES (?, ?, ?, 'user')");
            if ($stmt->execute([$nom, $email, $password])) {
                $message = "Inscription réussie ! Redirection en cours...";
                $type_message = "success";
                header("Refresh: 2; URL=login.php");
            } else {
                $message = "Une erreur est survenue lors de l'inscription.";
                $type_message = "error";
            }
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
        $type_message = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Vente des voitures</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f8f9fa; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
        }

        .register-box { 
            background: #ffffff; 
            padding: 35px 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); 
            width: 350px; 
            border: 1px solid #f0f0f0; 
        }

        .register-box h2 { 
            text-align: center;
            margin: 0 0 5px 0;
            color: #111111; 
            font-size: 1.6rem;
            font-weight: 700;
        }

        .register-box h2 span {
            color: #d4a338;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 13px;
            margin-bottom: 20px;
        }

        label { 
            display: block; 
            text-align: left; 
            margin-top: 12px; 
            margin-bottom: 5px;
            color: #333333; 
            font-size: 13px; 
            font-weight: 600; 
        }

        input { 
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

        input:focus { 
            border-color: #d4a338; 
            box-shadow: 0 0 0 3px rgba(212, 163, 56, 0.15); 
        }

        .btn-submit { 
            background-color: #111111; 
            color: #ffffff; 
            border: none; 
            width: 100%; 
            padding: 12px; 
            margin-top: 20px; 
            cursor: pointer; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 15px; 
            transition: background-color 0.2s ease, transform 0.1s ease; 
        }

        .btn-submit:hover { 
            background-color: #d4a338; 
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* Messages de notification */
        .msg { 
            padding: 10px; 
            border-radius: 6px; 
            text-align: center; 
            font-size: 13px; 
            margin-bottom: 15px; 
            font-weight: 500; 
        }

        .msg.error {
            color: #dc2626;
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
        }

        .msg.success {
            color: #15803d;
            background-color: #dcfce7;
            border: 1px solid #86efac;
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

<div class="register-box">
    <h2>Créer un compte <span>.</span></h2>
    <div class="subtitle">Rejoignez Vente des voitures</div>

    <?php if(!empty($message)): ?>
        <div class="msg <?= $type_message ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nom complet :</label>
        <input type="text" name="nom" required placeholder>

        <label>Adresse Email :</label>
        <input type="email" name="email" required placeholder>

        <label>Mot de passe :</label>
        <input type="password" name="password" required placeholder>

        <button type="submit" name="inscrire" class="btn-submit">S'inscrire</button>
    </form>

    <div class="switch-link">
        Déjà un compte ? <a href="login.php">Connectez-vous ici</a>
    </div>
</div>

</body>
</html>