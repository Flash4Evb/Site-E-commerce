<?php 

if (isset($_GET['Reference'])) {
    $Reference = $_GET['Reference'];
    include('Connexion.php');

    $stmt = $pdo->prepare("DELETE FROM Produit WHERE Reference = ?");
    $stmt->execute([$Reference]);

    // Redirection sans état d'âme
    header("Location: GestionProduit.php"); 
    exit;
} else {
    echo "ID non fourni. Suppression impossible.";
}
?>
