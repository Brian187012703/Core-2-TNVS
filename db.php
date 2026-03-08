<?php
// Simple database setup script for XAMPP (MySQL/MariaDB)
// Place the project folder in xampp/htdocs and visit this script
// in your browser (e.g. http://localhost/your-folder/db.php) to
// create the database. Adjust credentials as needed.

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$dbname = 'core2tnvs';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$dbname' created or already exists.<br>";

    // switch to the new database and create tables
    $pdo->exec("USE `$dbname`");
    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `password_hash` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "Table 'users' created (if not present).<br>";

    echo "Setup complete. Add additional table creation SQL to this script or import database.sql.";
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
