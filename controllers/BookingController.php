<?php
// controllers/BookingController.php
class BookingController {
    private $db;
    private $booking;
    private $car;

    public function __construct($db) {
        $this->db = $db;
        $this->booking = new Booking($db);
        $this->car = new Car($db);
        
        // S'assurer que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    // Afficher le formulaire de réservation d'essai
    public function showTestDriveForm($car_id) {
        $this->car->id = $car_id;
        $car = $this->car->readOne();
        
        if (!$car) {
            header('Location: index.php?action=cars');
            exit;
        }
        
        require_once('./views/booking/test-drive.php');
    }

    // Traiter la soumission du formulaire de réservation
    public function processTestDriveBooking() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        $this->booking->user_id = $_SESSION['user_id'];
        $this->booking->car_id = $_POST['car_id'] ?? 0;
        $this->booking->booking_date = $_POST['booking_date'] ?? '';
        $this->booking->booking_time = $_POST['booking_time'] ?? '';
        $this->booking->notes = $_POST['notes'] ?? '';
        
        $errors = [];
        
        // Vérifier que la voiture existe
        $this->car->id = $this->booking->car_id;
        $car = $this->car->readOne();
        if (!$car) {
            $errors[] = "Cette voiture n'existe pas.";
        }
        
        // Vérifier que la date est dans le futur
        if (strtotime($this->booking->booking_date) < strtotime('today')) {
            $errors[] = "La date de réservation doit être dans le futur.";
        }
        
        // Vérifier la disponibilité
        if (!$this->booking->checkAvailability($this->booking->car_id, $this->booking->booking_date, $this->booking->booking_time)) {
            $errors[] = "Ce créneau horaire n'est plus disponible. Veuillez en choisir un autre.";
        }
        
        if (empty($errors)) {
            if ($this->booking->create()) {
                header('Location: index.php?action=my_bookings&success=1');
                exit;
            } else {
                $errors[] = "Une erreur est survenue lors de la réservation.";
            }
        }
        
        // S'il y a des erreurs, retourner au formulaire
        $_SESSION['booking_errors'] = $errors;
        header('Location: index.php?action=test_drive&car_id=' . $this->booking->car_id);
        exit;
    }

    // Afficher les réservations de l'utilisateur
    public function showUserBookings() {
        $bookings = $this->booking->readByUser($_SESSION['user_id']);
        require_once('./views/booking/my-bookings.php');
    }

    // Annuler une réservation
    public function cancelBooking($booking_id) {
        $this->booking->id = $booking_id;
        $this->booking->user_id = $_SESSION['user_id'];
        
        if ($this->booking->cancel()) {
            header('Location: index.php?action=my_bookings&cancelled=1');
        } else {
            header('Location: index.php?action=my_bookings&error=1');
        }
        exit;
    }
}
?>