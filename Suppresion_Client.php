<?php 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include('Connexion.php');

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    // Redirection sans état d'âme
    header("Location: GestionClientèle.php"); 
    exit;
} else {
    echo "ID non fourni. Suppression impossible.";
}
?>
