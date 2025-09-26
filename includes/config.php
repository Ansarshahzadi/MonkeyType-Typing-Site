<?php
$host = "localhost";
$dbname = "typing_db";  // <- yaha apka DB name
$username = "root";       // default XAMPP/WAMP user
$password = "";           // default XAMPP/WAMP password blank hota hai

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
