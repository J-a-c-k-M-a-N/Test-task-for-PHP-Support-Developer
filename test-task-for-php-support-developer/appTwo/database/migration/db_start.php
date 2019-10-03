<?php
$dsn = "pgsql:host=test-pgsql;";
$db = "wallet";
$user = "test";
$password = "test";

try {
    $pdo = new PDO($dsn, $user, $password);
    echo 'Connected->';
} catch (PDOException $e) {
    die("PDO CONNECTION ERROR: " . $e->getMessage());
}

$sql = "CREATE DATABASE ".$db;
$pdo->query($sql);
$pdo = null;


$dsn = $dsn."dbname=".$db;
$pdo = new PDO($dsn, $user, $password);

$sql = "CREATE TABLE users(
		user_id SERIAL NOT NULL,
		user_data json NOT NULL)";

$pdo->query($sql);

echo "Database created!";
