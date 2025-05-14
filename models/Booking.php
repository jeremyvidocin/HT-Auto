<?php
// models/Booking.php
class Booking {
    private $conn;
    private $table_name = "bookings";

    public $id;
    public $user_id;
    public $car_id;
    public $booking_date;
    public $booking_time;
    public $status;
    public $notes;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer une nouvelle réservation
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                (user_id, car_id, booking_date, booking_time, status, notes) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $this->user_id, 
            $this->car_id, 
            $this->booking_date, 
            $this->booking_time, 
            $this->status ?? 'pending', 
            $this->notes
        ]);
    }

    // Lire les réservations d'un utilisateur
    public function readByUser($user_id) {
        $query = "SELECT b.*, c.brand, c.model, c.image 
                  FROM " . $this->table_name . " b
                  LEFT JOIN cars c ON b.car_id = c.id
                  WHERE b.user_id = ? 
                  ORDER BY b.booking_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        
        return $stmt;
    }

    // Mettre à jour une réservation
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET booking_date = ?, booking_time = ?, notes = ?
                WHERE id = ? AND user_id = ?";

        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            $this->booking_date,
            $this->booking_time, 
            $this->notes,
            $this->id,
            $this->user_id
        ]);
    }

    // Annuler une réservation
    public function cancel() {
        $query = "UPDATE " . $this->table_name . "
                SET status = 'cancelled'
                WHERE id = ? AND user_id = ?";

        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([$this->id, $this->user_id]);
    }

    // Vérifier la disponibilité
    public function checkAvailability($car_id, $date, $time) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                  WHERE car_id = ? AND booking_date = ? AND booking_time = ? 
                  AND status != 'cancelled'";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$car_id, $date, $time]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] == 0;
    }

    // Get total number of bookings
    public function getTotal() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    // Get total number of bookings by status
    public function getTotalByStatus($status) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE status = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$status]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    // Get all bookings with details (pagination)
    public function getAllWithDetails($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT b.*, 
                         u.firstname, u.lastname, u.email,
                         c.brand, c.model
                  FROM " . $this->table_name . " b
                  LEFT JOIN users u ON b.user_id = u.id
                  LEFT JOIN cars c ON b.car_id = c.id
                  ORDER BY b.created_at DESC 
                  LIMIT :limit OFFSET :offset";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Exception PDO lors de la suppression de la réservation: " . $e->getMessage());
            return false;
        } catch(Exception $e) {
            error_log("Exception lors de la suppression de la réservation: " . $e->getMessage());
            return false;
        }
    }

    public function updateStatus($id, $newStatus) {
        try {
            $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
            
            if (!in_array($newStatus, $validStatuses)) {
                return false;
            }

            $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$newStatus, $id]);
        } catch(PDOException $e) {
            error_log("Exception PDO lors de la mise à jour du statut: " . $e->getMessage());
            return false;
        } catch(Exception $e) {
            error_log("Exception lors de la mise à jour du statut: " . $e->getMessage());
            return false;
        }
    }
}
?>