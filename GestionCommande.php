<?php
// GestionCommande.php
require_once 'Connexion.php';

echo "<h1>Historique des commandes</h1>";

try {
    $stmt = $pdo->query("
        SELECT 
            commande.idCmd,
            commande.dateCmd,
            commande.mode_paiement,
            commande.statut,
            users.nom AS nom_client,
            users.adresse,
            produit.nom AS nom_produit,
            produit.image,
            produit.prix,
            produit.Reference,
            lignedecommande.quantite
        FROM 
            commande
        JOIN users ON commande.idClt = users.id
        JOIN lignedecommande ON commande.idCmd = lignedecommande.Numcmd
        JOIN produit ON lignedecommande.Refprod = produit.Reference
        ORDER BY commande.dateCmd DESC
    ");

    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$commandes) {
        echo "<p>Aucune commande enregistrée.</p>";
    } else {
        $currentCmd = null;

        foreach ($commandes as $commande) {
            if ($commande['idCmd'] !== $currentCmd) {
                if ($currentCmd !== null) echo "</div>"; // Fermer la commande précédente
                $currentCmd = $commande['idCmd'];

                echo "<div style='border:1px solid #ccc; padding:15px; margin-bottom:20px; background:#f9f9f9;'>";
                echo "<h3>Commande n°{$commande['idCmd']}</h3>";
                echo "<p><strong>Date :</strong> {$commande['dateCmd']}</p>";
                echo "<p><strong>Client :</strong> {$commande['nom_client']} ({$commande['email']})</p>";
                echo "<p><strong>Mode de paiement :</strong> {$commande['mode_paiement']}</p>";
                echo "<p><strong>Statut :</strong> {$commande['statut']}</p>";
                echo "<h4>Produits commandés :</h4>";
            }

            echo "<div style='margin-left:20px;'>";
            echo "<img src='image/{$commande['image']}' alt='Image produit' style='width:60px; height:60px; vertical-align:middle; margin-right:10px;'>";
            echo "{$commande['nom_produit']} - {$commande['quantite']} × {$commande['prix']} €";
            echo "</div>";
        }

        echo "</div>"; // Fermer la dernière commande
    }

} catch (PDOException $e) {
    echo "Erreur lors du chargement : " . $e->getMessage();
}
?>
