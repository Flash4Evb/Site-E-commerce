<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>
<form action="FormulaireTraitement.php" method="post"> 
    <div  style="border: 1px solid #ccc; padding: 20px; width: 350px; margin: auto; border-radius: 10px; background-color: #f9f9f9;" >

        <h2><b>S'identifier</b></h2>

        <label for="login">Login :</label><br>
        <input type="text" name="login" id="login"><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" name="password" id="password" ><br><br>

        <input type="submit" name="connexion" value="Se connecter">
        <input type="submit" name="creerCmpt" value="Créer un compte"><br>
    
</div>
</form>

</body>
</html>