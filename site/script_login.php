<?php
session_start();

// Simule une "base de données"
$users = [
    'admin' => 'admin',
    'user' => 'admin'
];

// Récupère les données du formulaire
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Vérifie si les identifiants sont valides
if (isset($users[$username]) && $users[$username] === $password) {
    $_SESSION['username'] = $username;
    header('Location: dashboard.php');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}
