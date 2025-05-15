<?php
include 'Connexion.php'; // ta connexion PDO

$produit = []; // initialisation du tableau

if (isset($_POST['afficher_produit'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM produit ");
        $stmt->execute();
        $produit = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="GestionClient.css">
    <title>Gestion Produit</title>
</head>
<body>
    <h1>Gestion des Produits</h1>
  <form method="post">
  <table>
    <!-- Ligne spéciale avec boutons -->
    <tr class="button-row">
      <td colspan="5">
        <button type="submit" name="afficher_prod" class="btn">Afficher les Produits</button>
        <a href="FormulaireProduit.php" class="btn">Ajouter un Produit</a>
      </td>
    </tr>

    <!-- En-tête des colonnes -->
    <tr>
      <th>Reference</th>
      <th>Nom</th>
      <th>Description</th>
      <th>Prix</th>
      <th>Categorie</th>
      <th>PrixAcquisition</th>
      <th>Image</th>
      <th>Actions</th>
    </tr>
     <!--Recuperation des produits-->

     <?php if (!empty($produit)) : ?>
      <?php foreach ($produit as $produits) : ?>
        <tr>
          <td><?= htmlspecialchars($produits['Reference']) ?></td> <!--  -->
          <td><?= htmlspecialchars($produits['Nom']) ?></td>
          <td><?= htmlspecialchars($produits['Description']) ?></td>
          <td><?= htmlspecialchars($produits['Prix']) ?></td>
           <td><?= htmlspecialchars($produits['Categorie']) ?></td>
           <td><?= htmlspecialchars($produits['PrixAcquisition']) ?></td>
           <td><?= htmlspecialchars($produits['Image']) ?></td>
            <td>
            <a href="FormulaireProduit.php?id=<?= $produits['id'] ?>" class="btn">✏️ Modifier</a> <!-- 1_URL avec paramètre 2_raccourci -->
           <a href="Suppresion_Produit.php?id=<?= $produits['id'] ?>" class="btn">🗑️ Supprimer</a>
            </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    <tr>
      
  </table>
      </form>
</body>
</html>