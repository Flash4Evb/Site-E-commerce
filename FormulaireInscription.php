 <?php
 //recupération de l'id depuis l'url
if (isset($_GET['id'])) {
    include('Connexion.php');
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
</head>
<body>

    <form action="FormulaireTraitement.php" method="post">
    <div  style="border: 1px solid #ccc; padding: 20px; width: 350px; margin: auto; border-radius: 10px; ">
        <h2>Inscription</h2>

        <label for="nom">Nom:</label><br/>
        <input type="text" name="nom" id="nom" placeholder=" votre Nom Complet" value="<?= $client['nom'] ?? '' ?>" required><br/>
        
        <label for="tel">Téléphone:</label><br/>
        <input type="text" name="tel" id="tel" placeholder="Numéro de téléphone" value="<?= $client['tel'] ?? '' ?>"><br/>

        <label for="ville">Ville:</label><br/>
        <input type="text" name="ville" id="ville" placeholder="Votre Ville" value="<?= $client['ville'] ?? '' ?>"><br/>

       <label for="adresse">Adresse e-mail:</label><br/>
       <input type="email" name="adresse" id="adresse" placeholder="e-mail@gmail.com" value="<?= $client['adresse'] ?? '' ?>" <?= isset($client) ? 'disabled' : 'required' ?>><br/>
       <!-- op coalescence, si la valeur n'est pas null alors utilise là sinon prends celle par défaut-->
       <!--exp ternaire On vérifie si la variable n'est pas null si c'est vrai d sinon r -->

       <?php if (isset($client)) : ?>
    <!-- Champ caché pour transmettre quand même l’adresse e-mail parce qu'etant disabled il n'est pas envoyé-->
    <input type="hidden" name="adresse" value="<?= $client['adresse'] ?>">
       <?php endif; ?>

        <!-- Le champ mot de passe reste vide, l'admin ne le modifie jamais -->
        <label for="mdp">Mot de passe :</label><br>
        <input type="password" name="mdp" id="mdp" placeholder="Créer un mot de passe" <?= isset($client) ? 'disabled' : 'required' ?>><br><br>

        <?php if (isset($client)) : ?>
        <input type="hidden" name="id" value="<?= $client['id'] ?>">
        <?php endif; ?>


        <input type="submit" name="valider" value="Valider">
    </div>

    </form>



</body>
</html>