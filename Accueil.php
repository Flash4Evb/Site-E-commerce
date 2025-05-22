<?php 
require_once("Connexion.php");
$stmt = $pdo->query("SELECT DISTINCT categorie FROM produit");
$categories = $stmt->fetchAll();

session_start();

$inactif_max = 600; // 10 minutes

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactif_max)) {
    session_unset();
    session_destroy();
    header("Location: FormulaireConnexion.php?timeout=1");
    exit;
}

$_SESSION['last_activity'] = time();

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
<!-- 🔸 MODALE PANIER NON CONNECTÉ -->
<div id="modalPanier" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background-color:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
    
    <div style="background:white; padding:30px; border-radius:12px; max-width:400px; text-align:center; position:relative;">
        <!-- Croix de fermeture -->
        <span onclick="fermerModale()" style="position:absolute; top:10px; right:15px; font-size:24px; cursor:pointer;">&times;</span>
        
        <p style="font-size:18px; margin-bottom:20px;">Oups ! votre panier est vide.</p>
        <a href="FormulaireConnexion.php" style="background-color:black; color:white; padding:10px 20px; 
            text-decoration:none; border-radius:8px;">Me connecter</a>
    </div>
</div>

<script>
    function verifierConnexion() {
        const estConnecte = <?php echo isset($_SESSION['id_client']) ? 'true' : 'false'; ?>;
        
        if (estConnecte) {
            window.location.href = "profil.php"; // Remplace par le bon fichier panier
        } else {
            document.getElementById("modalPanier").style.display = "flex";
        }
    }

    function fermerModale() {
        document.getElementById("modalPanier").style.display = "none";
    }

    // Fermer la modale si clic en dehors de la boîte
    window.onclick = function(event) {
        let modal = document.getElementById("modalPanier");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
</script>

<!-- 🔸 JS pour bannière et carrousel -->

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
        <a href="AfficherMaquillage.php">Maquillage</a>
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
        <form method="GET" action="recherche.php">
        <input type="search" name="motcle" placeholder="Que recherchez vous ?" required>
       
       </form>
       </div>

        <!-- 🔹 Authentification et Panier -->
        <div class="auth-panier">
    <a href="FormulaireConnexion.php">👤 Authentification</a>
    <a href="#" onclick="verifierConnexion()">🛒 Panier</a>
      </div>

    </div>

    <!-- 🔸 Navigation principale -->
     <div class="banniere">
    <img src="image/banniere.jpg" alt="Bannière JYLOWS">
    <div class="texte-banniere">
        <h1>Bienvenue chez JYLOWS</h1>
        <p>Des offres exceptionnelles vous attendent !</p>
    </div>
</div>

    
        <!-- 🔸 image cliquable  -->
<div class="categories-cliquables">
    <a href="AfficherSac.php"><img src="image/SacAccueil1.jpeg" alt="Sacs"><p>Sacs</p></a>
    <a href="AfficherBijou.php"><img src="image/AccueilBijou.jpeg" alt="Bijoux"><p>Bijoux</p></a>
    <a href="AfficherMaquillage.php"><img src="image/AccueilCrèmeALèvre.jpeg" alt="Maquillage"><p>Maquillage</p></a>
    <a href="AfficherParfum.php"><img src="image/AccueilParfum3.webp" alt="Parfums"><p>Parfums</p></a>
    <a href="AfficherAppareil.php"><img src="image/AccueilSkin.jpeg" alt="Appareils"><p>Appareils</p></a>
</div>
 
<div class="parfum-container">
        <div class="parfum">
            <img src="image/SacAccueil6.jpeg" alt="Sac">
            <p>Sac à main Gucci</p>
            <p class="prix">200€</p>
            <button class="btn-panier" name="btn_panier" value="Ajouter au panier">Ajouter au panier</button>
        </div>

        <div class="parfum">
            <img src="image/sècheCheveux2.jpeg" alt="Appareil">
            <p>Sèche Cheveux</p>
            <p class="prix">500€</p>
            <button class="btn-panier" name="btn_panier" value="Ajouter au panier">Ajouter au panier</button>
        </div>
        <div class="parfum">
            <img src="image/bijou4.jpg" alt="Bijou 3">
            <p>Ensemble Colier-Bague</p>
            <p class="prix">200€</p>
            <button class="btn-panier" name="btn_panier" value="Ajouter au panier">Ajouter au panier</button>
        </div>
        <div class="parfum">
            <img src="image/AcueilCrèmeLèvre.jpg" alt="Crème à lèvre">
            <p>Adoucis les lèvres</p>
            <p class="prix">20€</p>
            <button class="btn-panier" name="btn_panier" value="Ajouter au panier">Ajouter au panier</button>
        </div>
        <div class="parfum">
            <img src="image/AccueilParfum.jpeg" alt="Crème à lèvre">
            <p>Senteur Rose</p>
            <p class="prix">20€</p>
            <button class="btn-panier" name="btn_panier" value="Ajouter au panier">Ajouter au panier</button>
        </div>

</div>       
    <!-- 🔸 Footer -->
<footer style="background-color:black; color: white; padding: 40px 20px; font-family: Arial, sans-serif;">
  <div style="text-align: center; margin-bottom: 30px;">
    <a href="#" style="color: white; text-decoration: none;">Retour en haut</a>
  </div>

  <div style="display: flex; flex-wrap: wrap; justify-content: space-around; max-width: 1200px; margin: 0 auto;">
    <!-- Colonne 1 -->
    <div>
      <h4 style="color: white;">Pour mieux nous connaître</h4>
      <ul style="list-style: none; padding: 0;">
        <li><a href="#" style="color: #ddd; text-decoration: none;">À propos</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Carrières</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Durabilité</a></li>
      </ul>
    </div>

    <!-- Colonne 2 -->
    <div>
      <h4 style="color: white;">Gagnez de l'argent</h4>
      <ul style="list-style: none; padding: 0;">
        <li><a href="#" style="color: #ddd; text-decoration: none;">Vendez chez JYLOWS</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">JYLOWS Business</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Développez votre marque</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Expédié par JYLOWS</a></li>
      </ul>
    </div>

    <!-- Colonne 3 -->
    <div>
      <h4 style="color: white;">Moyens de paiement Amazon</h4>
      <ul style="list-style: none; padding: 0;">
        <li><a href="#" style="color: #ddd; text-decoration: none;">Cartes de paiement</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Paiement en plusieurs fois</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Cartes cadeaux</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Recharge en ligne</a></li>
      </ul>
    </div>

    <!-- Colonne 4 -->
    <div>
      <h4 style="color: white;">Besoin d'aide ?</h4>
      <ul style="list-style: none; padding: 0;">
       <li><a href="#" style="color: #ddd; text-decoration: none;">Suivre vos commandes</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Options de livraison</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Retours</a></li>
        <li><a href="#" style="color: #ddd; text-decoration: none;">Garantie légale</a></li>
      </ul>
    </div>
  </div>
</footer>


</body>
</html>
