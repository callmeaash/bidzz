<?php

class LogoutController {

    public function handle() {
        $_SESSION = [];
        session_destroy();
        header("Location: /");
        exit;

    }
}