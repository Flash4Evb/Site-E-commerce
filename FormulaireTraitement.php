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

// ======= CRÉATION DE COMPTE OU MODIFICATION =========

if (isset($_POST['valider'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $tel = $_POST['tel'];
    $ville = $_POST['ville'];
    $email = $_POST['adresse'];
    $mdp = password_hash($_POST['mdp'] , PASSWORD_DEFAULT) ? : null ;  // Hasher le mot de passe

    try {
        // définir la requête SQL
        $sql = "INSERT INTO users (nom, tel, ville, adresse, motDePass) 
                VALUES (:nom, :tel, :ville, :email, :mdp)";

        $stmt = $pdo->prepare($sql);  // préparer la requête

        // Lier les paramètres à la requête préparée
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':email', $adresse);
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
         $_SESSION['id_client'] = $user['id']; // pour les commandes
         $_SESSION['email'] = $user['adresse'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom'] = $user['nom'];

        // Redirection selon le rôle
        if ($user['role'] === 'admin') {
            header('Location: dashBoard.php');
            exit();
        } else {
            header('Location: dashboard_client.php');//ATTENTION PAS ENCORE FAIT, it's okayyyy
            exit();
        }
    } else {
        echo "<script>alert('Email ou mot de passe incorrect.'); window.location.href='FormulaireConnexion.php';</script>";
        exit;
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
        // Mise à jour du profil (sans changer le mot de passe)
        $sql = "UPDATE users SET nom = ?, tel = ?, ville = ?, adresse = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $tel, $ville, $adresse, $id]);
        echo "Client modifié avec succès.";

    } else {
        // Création de compte
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
         $role = 'client'; // par défaut
        $sql = "INSERT INTO users (nom, tel, ville, adresse, motDePass) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $tel, $ville, $adresse, $mdp]);
        echo "<script>alert('Inscription réussie !'); window.location.href='FormulaireConnexion.php';</script>";
        exit;
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
    $reference= $_POST['reference'] ?? null;


    if($reference){
         // Mise à jour 
        $sql = "UPDATE produit SET nom = ?, description = ?, prix = ?, prixacquisition = ? WHERE Reference = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $description, $prix, $prixacquisition, $reference]);
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
                header("Location: AfficherMaquillage.php");
                break;
            default:
                header("Location: Accueil.php");
        }
        exit();
        echo "Produit modifié avec succès !";
        
    }
        
    else {
        // Insertion avec image et categorie
        $sql = "INSERT INTO produit (nom, description, prix,categorie, prixacquisition, image) VALUES (?, ?, ?, ?, ?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $description, $prix, $categorie, $prixacquisition,$image]);
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
                header("Location: AfficherMaquillage.php");
                break;
            default:
                header("Location: Accueil.php");
        }
        exit();
        echo "Produit ajouté avec succès !";
        
    
}
}
?>

 




