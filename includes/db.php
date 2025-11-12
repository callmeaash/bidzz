<?php
$dotenv = parse_ini_file(__DIR__ . '/../.env');

$mysqli = new mysqli(
    $dotenv['DB_HOST'],
    $dotenv['DB_USER'],
    $dotenv['DB_PASSWORD'],
    $dotenv['DB_NAME']
);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");
?>
