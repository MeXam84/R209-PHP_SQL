<?php
// Connexion à la base SQLite
try {
    $db = new PDO('sqlite:SQL.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération des styles et artistes distincts pour les filtres
$styles = $db->query('SELECT DISTINCT Style FROM Music ORDER BY Style')->fetchAll(PDO::FETCH_COLUMN);
$artistes = $db->query('SELECT DISTINCT Nom_artiste FROM Artiste ORDER BY Nom_artiste')->fetchAll(PDO::FETCH_COLUMN);

// Construction de la requête avec filtres
$conditions = [];
$params = [];

if (!empty($_GET['style'])) {
    $conditions[] = 'Style = :style';
    $params[':style'] = $_GET['style'];
}

if (!empty($_GET['artiste'])) {
    $conditions[] = 'Artiste = :artiste';
    $params[':artiste'] = $_GET['artiste'];
}

$sql = 'SELECT * FROM Music';
if ($conditions) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <a href="main.php" style="color: #242124;"><i class="fa fa-home"></i></a> 
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

<div class="page">
    <main class="main">
        <h1 style="text-align:center;">Catalogue de produits</h1>

        <!-- FORMULAIRE DE FILTRE -->
        <form method="get" class="filtre-form">
            <label for="style">Style :</label>
            <select name="style" id="style">
                <option value="">Tous</option>
                <?php foreach ($styles as $style): ?>
                    <option value="<?php echo htmlspecialchars($style); ?>" <?php if ($_GET['style'] ?? '' == $style) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($style); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="artiste">Artiste :</label>
            <select name="artiste" id="artiste">
                <option value="">Tous</option>
                <?php foreach ($artistes as $artiste): ?>
                    <option value="<?php echo htmlspecialchars($artiste); ?>" <?php if ($_GET['artiste'] ?? '' == $artiste) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($artiste); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button class="filtre" type="submit">Filtrer</button>
        </form>
        <br>
        <!-- AFFICHAGE DES PRODUITS -->
        <div class="catalogue">
            <?php if ($produits): ?>
                <?php foreach ($produits as $produit): ?>
                    <a class="carte-produit" href="produit.php?id=<?php echo $produit['Id_music']; ?>">
                        <img src="img_music/<?php echo htmlspecialchars($produit['Id_music']); ?>.png">
                        <div class="nom-produit"><?php echo htmlspecialchars($produit['Nom_music']); ?></div>
                        <div class="prix"><?php echo htmlspecialchars($produit['Prix'], 2); ?></div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun produit trouvé avec les filtres sélectionnés.</p>
            <?php endif; ?>
        </div>
    </main>
</div>

<footer class="rect-footer">
  <p>© 2025 Music.ia. Tous droits réservés.</p>
</footer>
</body>
</html>
