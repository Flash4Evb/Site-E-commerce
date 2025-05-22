<?php
session_start();
require_once 'connexion.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['id'])) {
    header("Location: FormulaireConnexion.php");
    exit;
}

$idClient = $_SESSION['id'];
$message = "";

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mettreAJour'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $nouveauMdp = $_POST['motdepasse'];

    try {
        if (!empty($nouveauMdp)) {
            // Si mot de passe fourni → on le met à jour
            $motdepasseHash = password_hash($nouveauMdp, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET nom = ?, email = ?, motdepasse = ? WHERE id = ?");
            $stmt->execute([$nom, $email, $motdepasseHash, $idClient]);
        } else {
            // Sinon → on ne change pas le mot de passe
            $stmt = $pdo->prepare("UPDATE uers SET nom = ?, email = ? WHERE id = ?");
            $stmt->execute([$nom, $email, $idClient]);
        }

        $message = "Profil mis à jour avec succès !";
    } catch (PDOException $e) {
        $message = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}

// Récupérer les données du client pour affichage
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$idClient]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    echo "Client introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil du Client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: #f5f5f5;
            padding: 25px;
            border-radius: 10px;
        }
        label, input {
            display: block;
            margin-bottom: 10px;
            width: 100%;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .message {
            color: green;
            margin-bottom: 15px;
        }
        .links {
            margin-top: 20px;
        }
        .links a {
            display: inline-block;
            margin-right: 15px;
            color: #007BFF;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Mon Profil</h2>
        <?php if (!empty($message)) : ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label>Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" required>

            <label>Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($client['adresse']) ?>" required>

            <label>Nouveau mot de passe :</label>
            <input type="password" name="motdepasse" placeholder="Laisser vide pour ne pas changer">

            <input type="submit" name="mettreAJour" value="Mettre à jour">
        </form>
    </div>
    <div class="links">
    <a href="dashboard_client.php">← Retour au Dashboard</a>
    <a href="historique_commandes.php">📦 Historique des commandes</a>
    <a href="logout.php">🔒 Déconnexion</a>
</div>

</body>
</html>
