<?php
require_once __DIR__ . '/../../includes/db.php';

class User {
    public $id;
    public $username;
    public $password;
    public $email;
    public $avatar;
    public $is_admin;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->email = $row['email'];
        $this->avatar = $row['avatar'];
        $this->is_admin = $row['is_admin'];
    }

    private static function getDb() {
        global $mysqli;
        
        if ($mysqli === null) {
            throw new Exception("Database connection not available", 500);
        }
        
        return $mysqli;
    }

    public static function findByEmail($email) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new User($res) : null;
    }

    public static function findByUsername($username) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new User($res) : null;
    }

    public static function findById($id) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? new User($res) : null;
    }

    public static function create($username, $email, $password) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();
        return $mysqli->insert_id;
    }
}

?>