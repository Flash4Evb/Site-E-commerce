<?php
// Connexion à la base via PDO
include("Connexion.php");

try {
    // Requête SQL pour récupérer tous les produits de la catégorie "maquillage"
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE categorie = 'maquillage'");
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
    <title>Nos Maquillages</title>
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
    <!-- BOUCLE pour afficher chaque produit dynamiquement -->
    <?php foreach ($produits as $prod): ?>
        <div class="parfum">
            <!-- Image du produit : le nom de l'image est récupéré depuis la base -->
            <img src="image/<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['nom']) ?>">

            <!-- Description du produit : récupérée depuis la base -->
            <p><?= htmlspecialchars($prod['description']) ?></p>

            <!-- Prix du produit -->
            <p class="prix"><?= htmlspecialchars($prod['prix']) ?>€</p>

            <!-- Formulaire pour ajouter au panier -->
            <form method="post" action="AjouterPanier.php">
                <!-- On envoie l’ID du produit dans un champ caché -->
                <input type="hidden" name="id_produit" value="<?= $prod['Reference'] ?>">
                <button type="submit" class="btn-panier">Ajouter au panier</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>