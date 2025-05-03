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
$requete = $db->prepare('SELECT * FROM Music WHERE Id_music = :id');
$requete->bindParam(':id', $id, PDO::PARAM_INT);
$requete->execute();
$produit = $requete->fetch(PDO::FETCH_ASSOC);

// Si le produit n'existe pas
if (!$produit) {
    die('Produit non trouvé.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($produit['Nom_music']); ?></title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="produit">
        <h2><?php echo htmlspecialchars($produit['Nom_music']); ?></h2>
        <img src="img_music/<?php echo htmlspecialchars($produit['Id_music']); ?>.png" alt="<?php echo htmlspecialchars($produit['Nom_music']); ?>">
        <p><?php echo htmlspecialchars($produit['Description']); ?></p>
        <audio controls src="song/<?php echo htmlspecialchars($produit['Id_music']); ?>.mp3"></audio>
        <p class="prix"><?php echo htmlspecialchars($produit['Prix'], 2); ?></p>
        <form method="post" action="ajouter_panier.php">
            <input type="hidden" name="produit_id" value="<?php echo $produit['Id_music']; ?>">
            <button type="submit" class="bouton-panier">Ajouter au panier</button>
        </form>
    </div>
</body>
</html>
