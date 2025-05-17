<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Vérification session
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_SESSION['perm']) || $_SESSION['perm'] !== 'admin') {
    die("Accès refusé. Vous devez être administrateur pour ajouter un produit.");
}

// Connexion à la base
try {
    $db = new PDO('sqlite:SQL.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_TIMEOUT, 10);
} catch (PDOException $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['nom'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $nomArtiste = trim($_POST['artiste'] ?? '');

    try {
        $db->beginTransaction();

        // Vérifie ou insère l'artiste
        $stmtCheck = $db->prepare("SELECT Id_artiste FROM Artiste WHERE Nom_artiste = :nom");
        $stmtCheck->execute([':nom' => $nomArtiste]);
        $artiste = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($artiste) {
            $idArtiste = $artiste['Id_artiste'];
        } else {
            $descArtiste = "Aucune description";
            $stmtInsert = $db->prepare("INSERT INTO Artiste (Nom_artiste, Description) VALUES (:nom, :desc)");
            $stmtInsert->execute([':nom' => $nomArtiste, ':desc' => $descArtiste]);
            $idArtiste = $db->lastInsertId();
        }

        // Insère la musique
        $stmtMusic = $db->prepare("INSERT INTO Music (Titre, Prix, Description, Id_artiste)
                                   VALUES (:titre, :prix, :description, :id_artiste)");
        $stmtMusic->execute([
            ':titre' => $titre,
            ':prix' => $prix,
            ':description' => $description,
            ':id_artiste' => $idArtiste
        ]);
        $idMusic = $db->lastInsertId();

        // Répertoires
        $imageDir = 'img_music/';
        $songDir = 'song/';
        if (!is_dir($imageDir)) mkdir($imageDir, 0777, true);
        if (!is_dir($songDir)) mkdir($songDir, 0777, true);

        // Image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $extImg = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imagePath = $imageDir . $idMusic . '.' . $extImg;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                echo "<p>Image uploadée : $imagePath</p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de l'upload de l'image.</p>";
            }
        }

        // Fichier audio
        if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
            $extAudio = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
            $fichierPath = $songDir . $idMusic . '.' . $extAudio;
            if (move_uploaded_file($_FILES['fichier']['tmp_name'], $fichierPath)) {
                echo "<p>Fichier audio uploadé : $fichierPath</p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de l'upload du fichier audio.</p>";
            }
        }

        $db->commit();
        echo "<p style='color: green;'>Musique ajoutée avec succès !</p>";
    } catch (Exception $e) {
        $db->rollBack();
        echo "<p style='color: red;'>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une musique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
</head>
<body>
<header class="navbar">
    <div class="nav-left">
        <a href="main.php" style="color: #242124;"><i class="fa fa-home"></i></a> 
    </div>
    <div class="nav-center">
        <a href="main.php" class="logo-link">
            <img src="logo.png" alt="Logo" class="logo">
        </a>  
    </div>
    <div class="nav-right"> 
        <i class="fa fa-search" style="color: #242124;"></i> 
        <a href="panier.php" style="color: #242124;"><i class="fa fa-shopping-cart"></i></a>
        <a href="login.php" style="color: #242124;"><i class="fa fa-user-circle"></i></a>
    </div>
</header>

<div class="page">
<main class="main">
    <h1>Ajouter une musique</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Titre : <input type="text" name="nom" required></label><br><br>
        <label>Artiste : <input type="text" name="artiste" required></label><br><br>
        <label>Prix (€) : <input type="number" name="prix" step="0.01" required></label><br><br>
        <label>Description : <textarea name="description" required></textarea></label><br><br>
        <label>Image : <input type="file" class="filtre" name="image" accept="image/*" required></label><br><br>
        <label>Fichier audio : <input type="file" class="filtre" name="fichier" accept="audio/*" required></label><br><br>
        <input type="submit"  class="filtre" value="Ajouter">
    </form>
    </main>
</div>

<footer>
    <p>© 2025 Music.ia</p>
</footer>
</body>
</html>
