<?php
session_start();
require_once 'connexion.php';

if (isset($_POST['ajoutPanier'])) {
    // ⚠️ Vérifier si le client est connecté
    if (!isset($_SESSION['id'])) {
        // Il n'est pas connecté → afficher une alerte JS et rediriger
        echo "<script>
                alert('Vous devez être connecté pour ajouter un produit au panier.');
                window.location.href = 'FormulaireConnexion.php';
              </script>";
        exit;
    }

    $Reference = $_POST['Reference'];

    // Récupérer les infos du produit depuis la BD
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE Reference = ?");
    $stmt->execute([$Reference]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produit) {
        echo "Produit non trouvé.";
        exit;
    }

    // Initialiser le panier s'il n'existe pas encore
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Ajouter le produit ou augmenter la quantité
    if (isset($_SESSION['panier'][$Reference])) {
        $_SESSION['panier'][$Reference]['quantite'] += 1;
    } else {
        $_SESSION['panier'][$Reference] = [
            'nom' => $produit['nom'],
            'prix' => $produit['prix'],
            'image' => $produit['image'],
            'quantite' => 1
        ];
    }

    // Afficher la modale HTML
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Produit ajouté</title>
        <style>
            .modal {
                position: fixed;
                top: 30%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #fff;
                border: 2px solid #aaa;
                padding: 20px;
                box-shadow: 0 0 15px rgba(0,0,0,0.3);
                z-index: 1000;
                text-align: center;
                border-radius: 10px;
            }
            .modal button {
                margin: 10px;
                padding: 10px 15px;
                background: #008CBA;
                border: none;
                color: white;
                cursor: pointer;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="modal">
            <h3>Produit ajouté au panier !</h3>
            <button onclick="window.location.href='Choix_paiement.php'">Passer au paiement</button>
            <button onclick="window.location.href='panier.php'">Voir le panier</button>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "Aucun produit sélectionné.";
}
