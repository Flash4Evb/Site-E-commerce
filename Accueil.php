<?php 
require_once("Connexion.php");
$stmt = $pdo->query("SELECT DISTINCT categorie FROM produit");
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title><!--le Titre de cette-->
     <link rel="stylesheet" type="text/css" href="Site.css">
    <link rel="stylesheet" type="text/css" href="Accueil.css">
</head>
<body>
 
<!-- Le navbar-->
    <div class="entête1">
     <!-- Logo -->
    <div class="logo-texte">JYLOWS</div>

    <div class="menu-container">
    <input type="checkbox" id="menu-toggle">
    <label for="menu-toggle" class="menu-btn">☰ Catégories</label>

    
    <ul class="menu-list">
        <?php foreach ($categories as $cat) : ?>
            <?php $nomFichier = 'Afficher' . ucfirst($cat['categorie']) . '.php'; ?>
            <li>
                <a href="<?= $nomFichier ?>">
                    <?= htmlspecialchars(ucfirst($cat['categorie'])) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
       <!-- Barre de recherche -->
        <div class="search-container">
            <form>
                <input type="search" name="Rech" placeholder="Que cherchez-vous ?">
            </form>
        </div>
    
        <!-- Authentification + Panier -->
        <div class="auth-panier">
            <a href="FormulaireConnexion.php">👤 Authentification</a>
            <a href="#">🛒 Panier</a>
        </div>
    </div>

    <div>
        <nav>
            <ul>
                <li> <a href=" ">Localisation</a> </li>
                <li> <a href="Accueil.php">Accueil</a> </li>
                <li> <a href="parfum.html">Parfum</a> </li>
                <li> <a href="Maquillage.html">Maquillage</a> </li><!--Ajout des liens pour chq fichier-->
                <li> <a href="Sac.html">Sac</a> </li>
                <li> <a href="AppareilElectronique.html">Appareil electronique</a> </li>
                <li> <a href="Bijou.html">Bijou</a> </li>
            </ul>
        </nav>
    </div>
    
      
      
      
      
      
      

    <!-- 🔹 FOOTER -->
    <footer>
        <p>&copy; 2025 - JYLOWS | Tous droits réservés</p>
        <div class="social-links">
            <a href="#">Facebook</a> |
            <a href="#">Instagram</a> |
            <a href="#">Twitter</a>
        </div>
    </footer>
    
</body>
</html>