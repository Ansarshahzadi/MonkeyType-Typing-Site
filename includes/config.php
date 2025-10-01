<?php
$host = "localhost";
$dbname = "typing_db";  // <- yaha apka DB name
$username = "root";       // default XAMPP/WAMP user
$password = "";           // default XAMPP/WAMP password blank hota hai

$conn = new mysqli("localhost", "root", "", "typing_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
