<?php
function validate_username($username) {
    return preg_match("/^[a-zA-Z][a-zA-Z0-9_\.]{2,19}$/", $username);
}

function validate_password($password) {
    return preg_match("/^(?=.*[0-9]).{8,}$/", $password);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

class Logger {
    private static $logFile = __DIR__ . '/../logs/app.log';
    public static function error($filename, $message, $errorDetail = '') {
        $logDir = dirname(self::$logFile);
        if(!is_dir($logDir)) {
            mkdir($logDir, 0755, TRUE);
        }
        
        date_default_timezone_set('Asia/Kathmandu');
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] [$filename] ERROR: {$message} | {$errorDetail}" . PHP_EOL;

        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }
}

$itemsCategory = ['Electronics', 'Collectibles', 'Fashion', 'Sports', 'Art', 'Jewelry', 'Vehicles', 'Others'];

?>