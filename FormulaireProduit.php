<?php
// Récupération de la référence depuis l’URL (en modification)
if (isset($_GET['Reference'])) {
    include('Connexion.php');
    $reference = $_GET['Reference'];
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE Reference = ?");
    $stmt->execute([$reference]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($produit) ? "Modifier le produit" : "Ajouter un produit" ?></title>
    <link rel="stylesheet" href="chemin/vers/ton-style-client.css">
</head>
<body>
    <h1 style="text-align:center;">
        <?= isset($produit) ? "Modifier le produit" : "Ajouter un produit" ?>
    </h1>

    <form action="FormulaireTraitement.php" method="POST" enctype="multipart/form-data">
        <div style="border: 1px solid #ccc; padding: 20px; width: 350px; margin: auto; border-radius: 10px;">

        <?php if (isset($produit)) : ?>
            <!-- En modification, on envoie la référence en champ caché -->
            <input type="hidden" name="reference" value="<?= $produit['Reference'] ?>">
        <?php endif; ?>

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom" value="<?= $produit['nom'] ?? '' ?>" required><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" required><?= $produit['description'] ?? '' ?></textarea><br><br>

        <label for="prix">Prix :</label><br>
        <input type="number" step="0.01" name="prix" id="prix" value="<?= $produit['prix'] ?? '' ?>" required><br><br>

        <?php if (!isset($produit)) : ?>
            <label for="prixac">Prix Acquisition :</label><br>
            <input type="number" step="0.01" name="prixac" id="prixac" required><br><br>

            <label for="categorie">Catégorie :</label><br>
            <select name="categorie" id="categorie" required>
                <option value="sac">Sac</option>
                <option value="bijou">Bijou</option>
                <option value="parfum">Parfum</option>
                <option value="appareil">Appareil</option>
                <option value="maquillage">Maquillage</option>
            </select><br><br>

            <label for="image">Nom du fichier image (ex: bijou1.jpeg) :</label><br>
            <input type="text" name="image" id="image" required><br><br>
        <?php endif; ?>

        <input type="submit" name="<?= isset($produit) ? 'modifierProd' : 'validerProd' ?>" 
               value="<?= isset($produit) ? 'Modifier le produit' : 'Ajouter le produit' ?>">
        </div>
    </form>
</body>
</html>
