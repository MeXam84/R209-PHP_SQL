<?php
session_start();

// Connexion à la base de données SQLite
$pdo = new PDO('sqlite:SQL.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupère les données du formulaire
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Vérification dans la base
$stmt = $pdo->prepare('SELECT * FROM Users WHERE Nom_users = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();


// Vérifie si les identifiants sont valides
if ($user && $password === $user['Password']) {
    $_SESSION['username'] = $username;
    header('Location: dashboard.php');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}
?>