<?php

?>

<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <main class="main">
      <h1 style="text-align:center;">Mon Panier</h1>
      <p style="text-align:center;">Vous n'avez pas encore ajouté de produits à votre panier.</p>
    <div class="static-part">
      <h3>Mon panier</h3>
    </div>
    <div class="dynamic-part">
      <div class="widget">Widget 1</div>
      <div class="widget">Widget 2</div>
      <div class="widget">Widget 3</div>
      
      <!-- Ajoute ici plus de widgets pour voir l'agrandissement -->
    </div>
</main>
  </div>

 <!-- FOOTER CORRECTEMENT STRUCTURÉ -->
<footer class="rect-footer">
  <p>© 2025 Music.ia. Tous droits réservés.</p>
</footer>
</body>
</html>