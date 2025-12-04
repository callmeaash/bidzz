<?php

class IndexController {
    public function handle() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            require_once __DIR__ . '/../models/Item.php';
            try{
                $items = Item::getItems();
            
            } catch (Exception $e) {
                require_once __DIR__ . '/../../includes/utils.php';
                Logger::error(basename(__FILE__), 'Database Error', $e->getMessage());
            }
            
            require_once __DIR__ . '/../views/index.php';
            return;
        }
    }
}