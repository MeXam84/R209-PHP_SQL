<?php
// Connexion à la base SQLite
try {
    $db = new PDO('sqlite:SQL.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération de tous les produits
$produits = $db->query('SELECT * FROM Music')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <title>Catalogue</title>
 </head>
<body>
<header class="navbar">
    <div class="nav-left">
    <a href="main.php" style="color: #242124;">
      <i class="fa fa-home"></i>
</a> 
    </div>
    <div class="nav-center">
      <a href="main.php" class="logo-link">
      <img src="logo.png" alt="Logo" class="logo">
  </a>  
        </div>
    <div class="nav-right"> 
      <i class="fa fa-search" style="color: #242124;"></i> 
      <a href="panier.php" style="color: #242124;">
      <i class="fa fa-shopping-cart"></i>
</a>
      <a href="login.php" style="color: #242124;">
  <i class="fa fa-user-circle"></i>
</a>
    </div>
  </header>
    <h1 style="text-align:center;">Catalogue de produits</h1>
    <div class="catalogue">
        <?php foreach ($produits as $produit): ?>
            <a class="carte-produit" href="produit.php?id=<?php echo $produit['Id_music']; ?>">
                <img src="img_music/<?php echo htmlspecialchars($produit['Id_music']); ?>.png">
                <div class="nom-produit"><?php echo htmlspecialchars($produit['Nom_music']); ?></div>
                <div class="prix"><?php echo htmlspecialchars($produit['Prix'], 2); ?></div>
            </a>
        <?php endforeach; ?>
    </div>

</body>
</html>
