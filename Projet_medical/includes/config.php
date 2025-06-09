<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Utilisateur MySQL
define('DB_PASS', '');      // Mot de passe MySQL (vide par défaut dans XAMPP)
define('DB_NAME', 'projet_crypto');

// Connexion à la base de données
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté (pour les pages protégées)

?>