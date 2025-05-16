<?php 
require_once("Connexion.php");
$stmt = $pdo->query("SELECT DISTINCT categorie FROM produit");
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
      <link rel="stylesheet" type="text/css" href="Site.css">
       <link rel="stylesheet" type="text/css" href="Accueil.css"> 
</head>
<body>

    <!-- 🔸 EN-TÊTE -->
    <div class="entête1">
        
        <!-- 🔹 Logo -->
        <div class="logo-texte">JYLOWS</div>

        <!-- 🔹 Menu catégories (placement spécifique page d'accueil) -->
       <div style="position: relative;">
    <span class="menu-icon" onclick="toggleMenu()">☰ Catégorie</span>
    <div class="menu-categories" id="categoriesMenu">
        <a href="AfficherSac.php">Sacs</a>
        <a href="AfficherBijou.php">Bijoux</a>
        <a href="Maquillage.php">Maquillage</a>
        <a href="AfficherParfum.php">Parfums</a>
        <a href="AfficherAppareil.php">Appareils électroniques</a>
    </div>
</div>

<script>
function toggleMenu() {
    var menu = document.getElementById('categoriesMenu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}
</script>

        <!-- 🔹 Barre de recherche -->
        <div class="search-container">
            <form>
                <input type="search" name="Rech" placeholder="Que cherchez-vous ?">
            </form>
        </div>

        <!-- 🔹 Authentification et Panier -->
        <div class="auth-panier">
            <a href="FormulaireConnexion.php">👤 Authentification</a>
            <a href="#">🛒 Panier</a>
        </div>
    </div>

    <!-- 🔸 Navigation principale -->
    <nav>
        <ul>
            <li><a href="#">Localisation</a></li>
            <li><a href="Accueil.php">Accueil</a></li>
            <li><a href="parfum.html">Parfum</a></li>
            <li><a href="Maquillage.html">Maquillage</a></li>
            <li><a href="Sac.html">Sac</a></li>
            <li><a href="AppareilElectronique.html">Appareil électronique</a></li>
            <li><a href="Bijou.html">Bijou</a></li>
        </ul>
    </nav>

    <!-- 🔸 Footer -->
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
