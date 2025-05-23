<?php
// Connexion à la base via PDO
include("Connexion.php");

try {
    // Requête SQL pour récupérer tous les produits de la catégorie "maquillage"
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE categorie = 'parfum'");
    $stmt->execute();
    $produits = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Parfums</title>
    <link rel="stylesheet" href="cadreProduit.css">
    <link rel="stylesheet" href="Accueil.css">
    <link rel="stylesheet" href="Site.css">
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
    <!-- BOUCLE pour afficher chaque produit dynamiquement -->
     <div class="liste-produits"> <!--  conteneur parent -->
    <?php foreach ($produits as $prod): ?>
        <div class="parfum">
            <!-- Image du produit : le nom de l'image est récupéré depuis la base -->
            <img src="image/<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['nom']) ?>">

            <!-- Description du produit : récupérée depuis la base -->
            <p><?= htmlspecialchars($prod['description']) ?></p>

            <!-- Prix du produit -->
            <p class="prix"><?= htmlspecialchars($prod['prix']) ?>€</p>

            <!-- Formulaire pour ajouter au panier -->
           <form method="post" action="ajouter_au_panier.php">
                <!-- On envoie l’ID du produit dans un champ caché -->
                <input type="hidden" name="Reference" value="<?= $prod['Reference'] ?>">
                <button type="submit" class="btn-panier" name="ajoutPanier">Ajouter au panier</button>
            </form>
        </div>
    <?php endforeach; ?>
    </div>

    <footer style="background-color:rgb(41, 46, 52); color: white; padding: 40px 20px; font-family: Arial, sans-serif;">
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