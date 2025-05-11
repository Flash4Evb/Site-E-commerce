<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
</head>
<body>


    <form action="FormulaireTraitement" method="post">
    <div  style="border: 1px solid #ccc; padding: 20px; width: 350px; margin: auto; border-radius: 10px; ">
        <h2>Inscription</h2>
        <label for="nom">Nom:</label><br/>
        <input type="text" name="nom" id="nom" placeholder=" votre Nom Complet" requiered><br/>

        <label for="tel">Téléphone:</label><br/>
        <input type="text" name="tel" id="tel" placeholder="Numéro de téléphone"><br/>

        <label for="ville">Ville:</label><br/>
        <input type="text" name="ville" id="ville" placeholder="Votre Ville"><br/>

        <label for="adresse">Adresse e-mail:</label><br/>
        <input type="email" name="adresse" id="adresse" placeholder="e-mail@gmail.com" required><br/>

        <label for="mdp">Mot de passe :</label><br>
        <input type="password" name="mdp" id="mdp" placeholder="Créer un mot de passe" required><br><br>

        <input type="submit" name="s'inscrire" value="S'inscrire">
    </div>

    </form>



</body>
</html>