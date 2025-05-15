<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
// Vérifier si l'utilisateur est un admin
if (!isset($_SESSION['perm']) || $_SESSION['perm'] !== 'admin') {
    die("Accès refusé. Vous devez être administrateur pour ajouter un produit.");
}


// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom = $_POST['nom'] ?? '';
  $prix = $_POST['prix'] ?? 0;
  $description = $_POST['description'] ?? '';

  // Connexion à la base de données SQLite
  $db = new PDO('sqlite:SQL.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Préparation de la requête d'insertion
  $stmt = $db->prepare("INSERT INTO produits (nom, prix, description) VALUES (:nom, :prix, :description)");
  $stmt->bindParam(':nom', $nom);
  $stmt->bindParam(':prix', $prix);
  $stmt->bindParam(':description', $description);

  if ($stmt->execute()) {
      echo "Produit ajouté avec succès.";
  } else {
      echo "Erreur lors de l'ajout du produit.";
  }
}
?>
?>

<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Tableau de bord</title>
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
    <a href="catalogue.php" style="color: #242124;"><i class="fa fa-search"></i></a>  
      <a href="panier.php" style="color: #242124;"><i class="fa fa-shopping-cart"></i></a>
      <a href="login.php" style="color: #242124;"><i class="fa fa-user-circle"></i></a>
    </div>
  </header>
  <div class="container">
    <div class="main">
  <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h1>
   <!-- Formulaire HTML -->
<h2>Ajouter un produit</h2>
<form method="POST">
    <label>Nom : <input type="text" name="nom" required></label><br><br>
    <label>Prix : <input type="number" name="prix" step="0.01" required></label><br><br>
    <label>Description : <textarea name="description" required></textarea></label><br><br>
    <input type="submit" value="Ajouter">
</form>
    <a href="logout.php">Se déconnecter</a>
      
    </div>
  </div>

<!-- FOOTER CORRECTEMENT STRUCTURÉ -->
<div class="footer_dashboard_admin">
<footer class="rect-footer">
  <p>© 2025 Music.ia. Tous droits réservés.</p>
</footer>
</div>
</body>
</html>