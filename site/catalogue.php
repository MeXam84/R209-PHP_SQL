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
    <meta charset="UTF-8">
    <title>Catalogue</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f8f8; padding: 20px; }
        .catalogue { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .carte-produit {
            background-color: white;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            padding: 15px;
            text-decoration: none;
            color: inherit;
        }
        .carte-produit img {
            width: 100%;
            height: auto;
        }
        .nom-produit {
            font-size: 18px;
            margin: 10px 0;
        }
        .prix {
            font-size: 16px;
            color: green;
        }
    </style>
</head>
<body>

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
