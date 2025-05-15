<?php
// connexion.php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=boutiqueenligne;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
