<?php
session_start();
require_once 'Connexion.php';

$total = 0;

echo "<h2>Votre panier</h2>";

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    echo "<p>Votre panier est vide.</p>";
    echo "<a href='Accueil.php'>Retour à l'accueil</a>";
    exit;
}

foreach ($_SESSION['panier'] as $Reference => $item) {
    $quantite = $item['quantite'];
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE Reference = ?");
    $stmt->execute([$Reference]);
    $produit = $stmt->fetch();


    if ($produit) {
        $sous_total = $produit['prix'] * $quantite;
        $total += $sous_total;

        echo "<div class='produit-panier'>";
        echo "<img src='image/{$produit['image']}' alt='Image du produit' style='width:100px'>";
        echo "<p><strong>{$produit['nom']}</strong></p>";
        echo "<p>Prix unitaire : {$produit['prix']} €</p>";
        echo "<form method='post' action='update_quantite.php'>";
        echo "<input type='hidden' name='Reference' value='{$produit['Reference']}'>";
        echo "<button type='submit' name='action' value='decrease'>➖</button>";
        echo "<span>$quantite</span>";
        echo "<button type='submit' name='action' value='increase'>➕</button>";
        echo "</form>";
        echo "<p>Sous-total : $sous_total €</p>";
        echo "</div><hr>";
    }
}

echo "<h3>Total à payer : $total €</h3>";
echo "<a href='choix_paiement.php'>Passer au paiement</a>";
?>
