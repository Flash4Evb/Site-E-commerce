<?php
session_start();

if (isset($_POST['Reference']) && isset($_POST['action'])) {
    $Reference = $_POST['Reference'];
    $action = $_POST['action'];

    if (isset($_SESSION['panier'][$Reference])) {
        if ($action === 'increase') {
            $_SESSION['panier'][$Reference]['quantite'] += 1;
        } elseif ($action === 'decrease') {
            $_SESSION['panier'][$Reference]['quantite'] -= 1;

            // Si la quantité devient 0 ou moins, on supprime le produit
            if ($_SESSION['panier'][$Reference]['quantite'] <= 0) {
                unset($_SESSION['panier'][$Reference]);
            }
        }
    }
}

// Redirection vers le panier
header('Location: panier.php');
exit;
?>
