<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/utils.php';
$dotenv = parse_ini_file(__DIR__ . '/../.env');

try{
    $mysqli = new mysqli(
    $dotenv['DB_HOST'],
    $dotenv['DB_USER'],
    $dotenv['DB_PASSWORD'],
    $dotenv['DB_NAME']
    );


    if ($mysqli->connect_error) {
        throw new Exception("Database connection failed: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");

} catch (Exception $e) {
    Logger::error(basename(__FILE__), "Database connection error", $e->getMessage());
    $mysqli = null;
}
?>
