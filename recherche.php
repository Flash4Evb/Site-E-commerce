<?php
require_once("Connexion.php");

if (isset($_GET['motcle'])) {
    $motcle = htmlspecialchars($_GET['motcle']);

    // Recherche simple dans nom, description ou catégorie
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE nom LIKE :motcle OR description LIKE :motcle OR categorie LIKE :motcle");
    $stmt->execute(['motcle' => "%$motcle%"]);
    $resultats = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" type="text/css" href="Site.css">
</head>
<body>
    <h1>Résultats pour : <?= htmlentities($motcle) ?></h1>

    <?php if (!empty($resultats)): ?>
        <div class="produits">
            <?php foreach ($resultats as $produit): ?>
                <div class="produit">
                    <img src="image/<?= $produit['image'] ?>" alt="<?= $produit['nom'] ?>" width="150">
                    <h3><?= $produit['nom'] ?></h3>
                    <p><?= $produit['description'] ?></p>
                    <p><strong><?= $produit['prix'] ?>€</strong></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun résultat .</p>
    <?php endif; ?>
</body>
</html>
