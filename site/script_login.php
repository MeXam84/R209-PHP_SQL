<?php
session_start();

// Connexion à la base de données
$pdo = new PDO('sqlite:SQL.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupère les données du formulaire
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Vérifie si les champs sont vides
if (empty($username) || empty($password)) {
    header('Location: login.php?error=empty');
    exit;
}

// Recherche l'utilisateur dans la base de données
$stmt = $pdo->prepare('SELECT * FROM Users WHERE Nom_users = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

// Vérifie si l'utilisateur existe et si le mot de passe est correct
if ($user && password_verify($password, $user['Password'])) {
    // Connexion réussie, démarrer la session et rediriger
    $_SESSION['username'] = $username;
    header('Location: dashboard.php');
    exit;
} else {
    // Identifiants incorrects, redirige vers login avec message d'erreur
    header('Location: login.php?error=invalid_credentials');
    exit;
}
