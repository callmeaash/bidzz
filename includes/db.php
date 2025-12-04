<?php


require_once __DIR__ . '/utils.php';
$dotenv = parse_ini_file(__DIR__ . '/../.env');

global $mysqli;
$mysqli = null;

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
}
?>
