<?php
// Connexion à la base de données SQLite
try {
    $db = new PDO('sqlite:SQL.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération de l'ID du produit depuis l'URL (ex: produit.php?id=1)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérer le produit depuis la base
$requete = $db->prepare('SELECT * FROM Artiste WHERE Id_artiste = :id');
$requete->bindParam(':id', $id, PDO::PARAM_INT);
$requete->execute();
$artiste = $requete->fetch(PDO::FETCH_ASSOC);

// Si le produit n'existe pas
if (!$artiste) {
    die('Artiste non trouvé.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($produit['Nom_artiste']); ?></title>
    <link rel="stylesheet" href="main.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .artiste { background-color: white; width: 300px; margin: 50px auto; border: 1px solid #ccc; padding: 15px; border-radius: 8px; }
        img { max-width: 100%; height: auto; }
    </style>
</head>
<body>
    <div class="artiste">
        <h2><?php echo htmlspecialchars($produit['Nom_artiste']); ?></h2>
        <img src="img_art/<?php echo htmlspecialchars($produit['Id_artiste']); ?>.png" alt="<?php echo htmlspecialchars($produit['Nom_artiste']); ?>">
        <p><?php echo htmlspecialchars($produit['Description']); ?></p>
    </div>
</body>
</html>
