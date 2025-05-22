<?php
session_start();

// Vérifier que le client est connecté
if (!isset($_SESSION['id'])) {
    header("Location: FormulaireConnexion.php");
    exit;
}

$nomClient = $_SESSION['nom'] ?? 'Client';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8fb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
        }

        .btn-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            background-color: #008CBA;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background-color: #005f7a;
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
    <h1>Bienvenue, <?= htmlspecialchars($nomClient) ?> !</h1>

    <div class="btn-container">
        <a href="panier.php" class="btn">🛒 Voir mon panier</a>
        <a href="Choix_paiement.php" class="btn">💳 Passer au paiement</a>
        <a href="profil.php" class="btn">👤 Mes informations</a>
        <a href="historique_commandes.php" class="btn">📦 Historique des commandes</a>
        <a href="logout.php" class="btn">🚪 Déconnexion</a>
    </div>
</div>
<div class="links">
    <a href="Accueil.php">← Retour à l'accueil</a>
    <a href="historique_commandes.php">📦 Historique des commandes</a>
    <a href="logout.php">🔒 Déconnexion</a>
</div>
</body>
</html>
