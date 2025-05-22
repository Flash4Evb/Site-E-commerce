<?php
session_start();
require_once 'Connexion.php';

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    echo "Votre panier est vide.";
    exit;
}

$id_client = $_SESSION['id_client'] ?? null;

$email_saisie= $_POST['email'] ?? '';
$mode=$_POST['mode'] ?? '';
$email_session=$_SESSION['email']?? '';
if($email_saisie !== $email_session){
    echo "L'email saisi ne correspond pas à votre compte .";
    exit;
}

try {
    $pdo->beginTransaction();

    // 1. Créer une commande
     $stmt = $pdo->prepare("INSERT INTO commande (idClt, statut, mode_paiement) VALUES (?, ?, ?)");
    $stmt->execute([$id_client, 'en cours', $mode]);
    $idCmd = $pdo->lastInsertId();

    // 2. Ajouter les lignes de commande
    foreach ($_SESSION['panier'] as $Reference => $item) {
        $quantite = $item['quantite'];
        $stmt = $pdo->prepare("INSERT INTO lignedecommande (Numcmd, Refprod, quantite) VALUES (?, ?, ?)");
        $stmt->execute([$idCmd, $Reference, $quantite]);
    }

    $pdo->commit();

    // 3. Vider le panier
    unset($_SESSION['panier']);

    echo "<h2>Commande validée !</h2>";
    echo "<p>Commande n°$idCmd enregistrée avec succès.</p>";
    echo "<a href='Accueil.php'>Retour à l'accueil</a>";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erreur lors de la validation : " . $e->getMessage();
}
?>
