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
    <title>Formulaire d'Ajout de Produit</title>
</head>
<body>
       <form action="FormulaireTraitement.php" method="POST" enctype="multipart/form-data">
        <div style="border: 1px solid #ccc; padding: 20px; width: 350px; margin: auto; border-radius: 10px;">
            <h1>Ajout Produit</h1>

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom" value="<?= $produit['nom'] ?? '' ?>" required><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" required><?= $produit['description'] ?? '' ?></textarea><br><br>

        <label for="prix">Prix :</label><br>
        <input type="number" step="0.01" name="prix" id="prix" value="<?= $produit['prix'] ?? '' ?>" ><br><br>

        <label for="prixac">Prix Acquisition :</label><br>
        <input type="number" step="0.01" name="prixac" id="prixac" value="<?= $produit['prixacquisition'] ?? ''?>" <?= isset($produit) ? 'disabled' : 'required' ?>><br><br>

        <?php if (isset($produit)) : ?>
    <!-- Champ caché pour transmettre quand même le prixac parce qu'etant disabled il n'est pas envoyé-->
         <input type="hidden" name="prixac" value="<?= $produit['prixacquisition'] ?>">
        <?php endif; ?>

            <label for="categorie">Catégorie :</label><br>
            <select name="categorie" id="categorie" value="<?= $produit['categorie'] ?? ''?>" <?= isset($produit) ? 'disabled' : 'required' ?>>
                <?php
                $categories = ['sac', 'bijou', 'parfum', 'appareil', 'maquillage'];
                foreach ($categories as $cat) {
                    $selected = (isset($produit) && $produit['categorie'] === $cat) ? 'selected' : '';
                    echo "<option value=\"$cat\" $selected>$cat</option>";
                }
                ?>
            </select><br><br>
            <?php if (isset($produit)) : ?>
                <!-- ✅ Champ caché pour envoyer la catégorie même si elle est disabled -->
                <input type="hidden" name="categorie" value="<?= $produit['categorie'] ?>">
            <?php endif; ?>

            <label for="image">Nom du fichier image (ex: bijou1.jpeg) :</label><br>
            <input type="text" name="image" id="image" value="<?= $produit['image'] ?? ''?>" <?=isset($produit) ? 'disabled' : 'required' ?>><br><br>
             <?php if (isset($produit)) : ?>
                <!-- ✅ Champ caché pour envoyer l’image même si elle est disabled -->
                <input type="hidden" name="image" value="<?= $produit['image'] ?>">
                <input type="hidden" name="reference" value="<?= $produit['Reference'] ?>">
            <?php endif; ?>

        <input type="submit" name="validerProd" value="Valider">
    </form>
</body>
</html>
