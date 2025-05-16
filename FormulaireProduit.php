

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="chemin/vers/ton-style-client.css"> <!-- Réutilisation du CSS -->
</head>
<body>
    <h1 style=" text-align:center; ">Ajouter un produit</h1>

    <form action="FormulaireTraitement.php" method="POST" enctype="multipart/form-data">
        <div  style="border: 1px solid #ccc; padding: 20px; width: 350px; margin: auto; border-radius: 10px; ">
        <label for="reference">Référence :</label><br>
        <input type="text" name="reference" id="reference" required><br><br>

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom" required><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" required></textarea><br><br>

        <label for="prix">Prix :</label><br>
        <input type="number" step="0.01" name="prix" id="prix" required><br><br>

         <label for="prixac">PrixAcquisition :</label><br>
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
        

        <input type="submit" name="validerProd" value="Ajouter le produit">
         </div>
    </form>
</body>
</html>

