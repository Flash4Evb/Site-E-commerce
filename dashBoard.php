<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" type="text/css" href="dashBoard.css">
</head>
<body>
<h1>Admin Dashboard</h1>
     <form method="post" class="dashboard">
    <input type="submit" class="btn client" name="btnClt" value="Client">
    <input type="submit" class="btn produit" name="btnPrd" value="Produit">
    <input type="submit" class="btn commande" name="btnCmd" value="Commande">
  </form>
    <?php
  if (isset($_POST['btnClt'])) {
    header("Location: GestionClientèle.php");
    exit();
  } elseif (isset($_POST['btnPrd'])) {
    header("Location: GestionProduit.php");
    exit();
  } elseif (isset($_POST['btnCmd'])) {
    header("Location: GestionCommande.php");
    exit();
  }
  ?>
</body>
</html>