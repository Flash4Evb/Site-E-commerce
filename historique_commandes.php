<?php
session_start();
require_once 'connexion.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['id'])) {
    header("Location: FormulaireConnexion.php");
    exit;
}

$idClient = $_SESSION['id'];

// Récupérer toutes les commandes du client
$stmt = $pdo->prepare("SELECT * FROM commande WHERE idClt = ? ORDER BY dateCmd DESC");
$stmt->execute([$idClient]);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des commandes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        .commande {
            margin-bottom: 30px;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .produit {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #aaa;
            padding-bottom: 10px;
        }
        .produit img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
        }
        .produit-info {
            flex-grow: 1;
        }
        .total {
            font-weight: bold;
            color: #007bff;
            margin-top: 10px;
        }
        h2 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Mon historique de commandes</h1>

    <?php if (count($commandes) === 0): ?>
        <p>Vous n'avez passé aucune commande pour le moment.</p>
    <?php else: ?>
        <?php foreach ($commandes as $commande): ?>
            <div class="commande">
                <h2>Commande #<?= $commande['idCmd'] ?> — <?= $commande['dateCmd'] ?></h2>

                <?php
                // Récupérer les lignes de commande pour cette commande
                $stmtLignes = $pdo->prepare("SELECT lc.quantite, p.nom, p.prix, p.image 
                                             FROM lignedecommande lc
                                             JOIN produit p ON lc.Refprod = p.Reference
                                             WHERE lc.Numcmd= ?");
                $stmtLignes->execute([$commande['idCmd']]);
                $lignes = $stmtLignes->fetchAll(PDO::FETCH_ASSOC);

                $total = 0;
                foreach ($lignes as $ligne):
                    $sousTotal = $ligne['prix'] * $ligne['quantite'];
                    $total += $sousTotal;
                ?>
                    <div class="produit">
                        <img src="image/<?= $ligne['image'] ?>" alt="<?= htmlspecialchars($ligne['nom']) ?>">
                        <div class="produit-info">
                            <strong><?= htmlspecialchars($ligne['nom']) ?></strong><br>
                            Prix unitaire : <?= number_format($ligne['prix'], 2) ?> €<br>
                            Quantité : <?= $ligne['quantite'] ?><br>
                            Sous-total : <?= number_format($sousTotal, 2) ?> €
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="total">Total commande : <?= number_format($total, 2) ?> €</div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
