 
 <?php
include 'Connexion.php'; // ta connexion PDO

$clients = []; // initialisation du tableau

if (isset($_POST['afficher_clients'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'client'");
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="GestionClient.css">
    <title>Gestion Client</title>

</head>
<body>
    <h1>Gestion des Clients</h1>
  <form method="post">
  <table>
    <!-- Ligne spéciale avec boutons -->
    <tr class="button-row">
      <td colspan="5">
        <button type="submit" name="afficher_clients" class="btn">Afficher les clients</button>
        <a href="FormulaireInscription.php" class="btn">Ajouter un client</a>
       
      </td>
    </tr>

    <!-- En-tête des colonnes -->
    <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Tel</th>
      <th>Ville</th>
      <th>Adresse</th>
      <th>Actions</th>
    </tr>
    <!--Recuperation des clients-->

     <?php if (!empty($clients)) : ?>
      <?php foreach ($clients as $client) : ?>
        <tr>
          <td><?= htmlspecialchars($client['id']) ?></td> <!--  -->
          <td><?= htmlspecialchars($client['nom']) ?></td>
          <td><?= htmlspecialchars($client['tel']) ?></td>
          <td><?= htmlspecialchars($client['ville']) ?></td>
           <td><?= htmlspecialchars($client['adresse']) ?></td>
          <td>
            <a href="FormulaireInscription.php?id=<?= $client['id'] ?>" class="btn">✏️ Modifier</a> <!-- 1_URL avec paramètre 2_raccourci -->
           <a href="SuppressionClient.php?id=<?= $client['id'] ?>" 
             class="btn" 
             onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ? Cette action est irréversible.');">
            🗑️ Supprimer
            </a>
            
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    <tr>
      
  </table>
      </form>
</body>
</html>