<?php
if(isset($_POST['creerCmpt'])){
    header("Location:FormulaireInscription.php");
    exit();
}

//Ajout manuel de l'admin
include ('Connexion.php');
try { 
    $nom = "Admin";
    $tel = "0000000000";
    $ville = "Serveur";
    $adresse= "admin1234@boutique.com";
    $password = password_hash("admin_mdp123", PASSWORD_DEFAULT);
    $role = "admin";

    $sql = "INSERT INTO users (nom, tel, ville, adresse, motDePass, role) 
            VALUES (:nom, :tel, :ville, :adresse, :password, :role)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':tel' => $tel,
        ':ville' => $ville,
        ':adresse' => $adresse,
        ':password' => $password,
        ':role' => $role
    ]);

    echo "Compte admin créé avec succès.";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

//Ajout du client dans la bd depuis le formulaire d'inscription

if (isset($_POST['valider'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $tel = $_POST['tel'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];
    $mdp = password_hash($_POST['mdp'] , PASSWORD_DEFAULT) ? : null ;  // Hasher le mot de passe

    try {
        // définir la requête SQL
        $sql = "INSERT INTO users (nom, tel, ville, adresse, motDePass) 
                VALUES (:nom, :tel, :ville, :adresse, :mdp)";

        $stmt = $pdo->prepare($sql);  // préparer la requête

        // Lier les paramètres à la requête préparée
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':mdp', $mdp);

        // Exécuter la requête
        $stmt->execute();

        // Afficher un message de succès
        echo "Client ajouté avec succès !";

    } catch (PDOException $e) {
        // En cas d'erreur de connexion ou d'exécution de la requête
        echo "Erreur : " . $e->getMessage();
    }
}




session_start(); // Pour pouvoir stocker des infos utilisateur

if (isset($_POST['connexion'])) {
    $login = $_POST['login']; // Nom du champ dans le formulaire de connexion
    $password = $_POST['password'];

    // Préparer la requête
    $stmt = $pdo->prepare("SELECT * FROM users WHERE adresse = :email");
    $stmt->execute([':email' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['motDePass'])) {
        // Connexion réussie : on stocke les infos en session
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom'] = $user['nom'];

        // Redirection selon le rôle
        if ($user['role'] === 'admin') {
            header('Location: dashBoard.php');
            exit();
        } else {
            header('Location: dashboard_client.php');//ATTENTION PAS ENCORE FAIT
            exit();
        }
    } else {
        echo "Identifiants incorrects.";
    }
} 
  
    //BLOC POUR LA MODIFICATION D'UN CLIENT
    //On récupère les valeurs modifier dans le formulaire d'inscription pour la bd

   if (isset($_POST['valider'])) {
    $nom = $_POST['nom'];
    $tel = $_POST['tel'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];
    $id = $_POST['id'] ?? null;

    if ($id) {
        // Mise à jour SANS changer le mot de passe
        $sql = "UPDATE users SET nom = ?, tel = ?, ville = ?, adresse = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $tel, $ville, $adresse, $id]);
        echo "Client modifié avec succès.";

    } else {
        // Insertion AVEC mot de passe
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (nom, tel, ville, adresse, motDePass) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $tel, $ville, $adresse, $mdp]);
        echo "Client ajouté avec succès.";
    }
}

//-----------------------GESTION DES PRODUITS----------------------------------------------------

if (isset($_POST['validerProd'])) {
   
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $prixacquisition = $_POST['prixac'];
    $categorie = $_POST['categorie'];
    $image = $_POST['image']; 

    try {
        $stmt = $pdo->prepare("INSERT INTO produit ( nom, description, prix, categorie, prixacquisition, image)
                 VALUES ( :nom, :description, :prix, :categorie, :prixacquisition, :image)");
       
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->bindParam(':prixacquisition', $prixacquisition);
        $stmt->bindParam(':image', $image); // On stocke juste le nom
        $stmt->execute();

         // Redirection selon la catégorie
        switch ($categorie) {
            case 'sac':
                header("Location: AfficherSac.php");
                break;
            case 'bijou':
                header("Location: AfficherBijou.php");
                break;
            case 'parfum':
                header("Location: AfficherParfum.php");
                break;
            case 'appareil':
                header("Location: AfficherAppareil.php");
                break;
            case 'maquillage':
                header("Location: Maquillage.php");
                break;
            default:
                header("Location: Accueil.php");
        }
        exit();
        echo "Produit ajouté avec succès !";
        
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }
}
/*-----------MODIFICATION-------------*/
if (isset($_POST['modifierProd'])) {
    $reference = $_POST['reference'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    try {
        // Récupérer la catégorie du produit pour la redirection
        $stmt = $pdo->prepare("SELECT categorie FROM produit WHERE Reference = ?");
        $stmt->execute([$reference]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $categorie = $result['categorie'];

        // Mise à jour du produit
        $stmt = $pdo->prepare("UPDATE produit 
                               SET nom = :nom, description = :description, prix = :prix 
                               WHERE Reference = :reference");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':reference', $reference);
        $stmt->execute();

        // Redirection selon la catégorie
        switch ($categorie) {
            case 'sac':
                header("Location: AfficherSac.php");
                break;
            case 'bijou':
                header("Location: AfficherBijou.php");
                break;
            case 'parfum':
                header("Location: AfficherParfum.php");
                break;
            case 'appareil':
                header("Location: AfficherAppareil.php");
                break;
            case 'maquillage':
                header("Location: Maquillage.php");
                break;
            default:
                header("Location: Accueil.php");
        }
        exit();

    } catch (PDOException $e) {
        echo "Erreur SQL (modification) : " . $e->getMessage();
    }
}


?>

 




