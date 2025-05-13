<?php
// models/User.php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $phone;
    public $address;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (firstname, lastname, email, password, phone, address)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Hash du mot de passe
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        
        return $stmt->execute([
            $this->firstname,
            $this->lastname,
            $this->email,
            $hashed_password,
            $this->phone,
            $this->address
        ]);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET firstname = ?, lastname = ?, phone = ?, address = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->firstname,
            $this->lastname,
            $this->phone,
            $this->address,
            $this->id
        ]);
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($new_password) {
        $query = "UPDATE " . $this->table_name . "
                SET password = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        return $stmt->execute([$hashed_password, $this->id]);
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}