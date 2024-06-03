<?php 

$host = 'localhost';
$database = 'hmisphp';
$username = 'root';
$password = '';
try {
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password, $options);
    if($conn) {
    } 
}
catch (PDOException $e) {
    die($e->getMessage());
}