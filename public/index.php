<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/models.php';

$search = $_GET['search'] ?? null;
$items = Item::getActiveItems($search);
echo json_encode($items);
?>
