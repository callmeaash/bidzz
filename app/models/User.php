<?php
require_once __DIR__ . '/../../includes/db.php';

class User {
    public $id;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $avatar;
    public $country;
    public $phone;
    public $bio;
    public $is_admin;
    public $is_active;
    public $created_at;
    public $updated_at;

    public function __construct(array $row) {
        $this->id         = $row['id'] ?? null;
        $this->username   = $row['username'] ?? null;
        $this->password   = $row['password'] ?? null;
        $this->email      = $row['email'] ?? null;
        $this->avatar     = $row['avatar'] ?? null;
        $this->country    = $row['country'] ?? null;
        $this->phone      = $row['phone'] ?? null;
        $this->bio        = $row['bio'] ?? null;
        $this->is_admin   = (bool) ($row['is_admin'] ?? false);
        $this->is_active  = (bool) ($row['is_active'] ?? true);
        $this->created_at = $row['created_at'] ?? null;
        $this->updated_at = $row['updated_at'] ?? null;
    }

    private static function getDb() {
        global $mysqli;
        
        if ($mysqli === null) {
            throw new Exception("Database connection not available", 500);
        }
        
        return $mysqli;
    }

    public static function findAll() {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare("SELECT * FROM users;");
        $stmt->execute();
        $res = $stmt->get_result();
        $users = [];
        while ($row = $res->fetch_assoc()) {
            $users[] = new User($row);
        }
        return $users;
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

    public static function updateProfile(int $userId, array $data) {
        $mysqli = self::getDb();

        $sql = "UPDATE users SET avatar = ?, fullname = ?, country = ?, phone = ?, bio = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param(
            "sssssi",
            $data['avatar'],
            $data['fullName'],
            $data['country'],
            $data['phone'],
            $data['bio'],
            $userId
        );
        return $stmt->execute();
    }

        public function getTotalBids() {
        $mysqli = self::getDb();

        $stmt = $mysqli->prepare(
            "SELECT COUNT(*) AS total FROM bids WHERE user_id = ?"
        );
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return (int) $result['total'];
    }

    public function getTotalListings() {
        $mysqli = self::getDb();

        $stmt = $mysqli->prepare(
            "SELECT COUNT(*) AS total FROM items WHERE owner_id = ?"
        );
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return (int) $result['total'];
    }


    public static function toggleUserStatus($userId, $newStatus) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare(
            "UPDATE users SET is_active = ? WHERE id = ?"
        );
        $stmt->bind_param("ii", $newStatus, $userId);
        $stmt->execute();
    }

    public static function delete($userId) {
        $mysqli = self::getDb();
        $stmt = $mysqli->prepare(
            "DELETE FROM users WHERE id = ?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
}
?>