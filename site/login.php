<?php

session_start();

if(isset($_POST['connexion'])){
  if(empty($_POST['username'])){
    echo "Renseignez un nom d'uttilisateur";
  } else {
    if(empty($_POST['password'])){
      echo "Renseignez le mot-de-passe";
    } else {
      $NomUser = htmlentities($_POST['username'], ENT_QUOTES, "UTF-8");
      $Password = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
      $Db = new SQLite3('SQL.db');

      $Resultat = $Db->query("SELECT * FROM users WHERE Nom_users = '".$NomUser"' AND Password = '".$Password"'");
      if($Resultat->numRows() == 0){
        echo "Nom d'uttilisateur ou mot-de-pass Incorect";
      } else {
        $_SESSION['username'] = $NomUser;
        echo "Connexion réussit !"
      }
    }
  }
}
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
    <a href="main.php" style="color: white;">
      <i class="fa fa-home"></i>
</a>  
    </div>
    <div class="nav-center">
    <a href="main.php" style="height: 90px;">  
    <img src="logo.png" alt="Logo" class="logo">
</a>   
        </div>
    <div class="nav-right">
      <i class="fa fa-search"></i>
      <a href="panier.php" style="color: white;">
      <i class="fa fa-shopping-cart"></i>
</a>
      <a href="login.php" style="color: white;">
  <i class="fa fa-user-circle"></i>
</a>
    </div>
  </header>

  <div class="container">
    <div class="main">
    <h1>Connexion</h1>
    <h3>Login</h3>
    <input type="text" placeholder="Nom d'utilisateur" name="username" required>
    <br>
    <h3>Mot de passe</h3>
    <input type="password" placeholder="Mot de passe" name="password" required>
    <br>
    <br>
    <button type="submit" name="connexion">Se connecter</button>

  </div>
</div>


</body>
</html>