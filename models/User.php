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
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data = null) {
        if ($data) {
            // Si des données sont fournies, les utiliser
            $this->firstname = $data['firstname'];
            $this->lastname = $data['lastname'];
            $this->email = $data['email'];
            $this->password = $data['password']; // Déjà hashé dans AdminController
            $this->phone = $data['phone'];
            $this->address = $data['address'];
            $this->role = $data['role'];
        }

        $query = "INSERT INTO " . $this->table_name . "
                (firstname, lastname, email, password, phone, address, role)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Si le mot de passe n'est pas déjà hashé, le hasher
        $password = (strpos($this->password, '$2y$') === 0) ? $this->password : password_hash($this->password, PASSWORD_DEFAULT);
        
        return $stmt->execute([
            $this->firstname,
            $this->lastname,
            $this->email,
            $password,
            $this->phone,
            $this->address,
            $this->role ?? 'user'
        ]);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET firstname = ?, lastname = ?, phone = ?, address = ?, role = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->firstname,
            $this->lastname,
            $this->phone,
            $this->address,
            $this->role,
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

    // Nouvelles méthodes pour l'administration
    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function getAllUsers($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function deleteUser($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public function updateRole($id, $role) {
        if (!in_array($role, ['user', 'admin'])) {
            return false;
        }
        $query = "UPDATE " . $this->table_name . " SET role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$role, $id]);
    }

    public function createAdminSession() {
        $token = bin2hex(random_bytes(32));
        $query = "INSERT INTO admin_sessions (user_id, token, ip_address, user_agent)
                 VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $this->id,
            $token,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        ]) ? $token : false;
    }

    public function validateAdminSession($token) {
        $query = "SELECT * FROM admin_sessions 
                 WHERE token = ? AND user_id = ? 
                 AND last_activity > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$token, $this->id]);
        if ($stmt->fetch()) {
            $this->updateAdminSessionActivity($token);
            return true;
        }
        return false;
    }

    private function updateAdminSessionActivity($token) {
        $query = "UPDATE admin_sessions SET last_activity = NOW() WHERE token = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$token]);
    }

    public function emailExists($email) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}