<?php
// controllers/AdminController.php

class AdminController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
        $this->checkAdminAccess();
    }

    private function checkAdminAccess() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $this->user->id = $_SESSION['user_id'];
        $userData = $this->user->readOne();
        if (!$userData || $userData['role'] !== 'admin') {
            header('Location: index.php?action=unauthorized');
            exit;
        }

        // Vérifier la session admin
        if (!isset($_SESSION['admin_token']) || 
            !$this->user->validateAdminSession($_SESSION['admin_token'])) {
            // Créer une nouvelle session admin
            $token = $this->user->createAdminSession();
            if ($token) {
                $_SESSION['admin_token'] = $token;
            } else {
                header('Location: index.php?action=login');
                exit;
            }
        }
    }

    public function dashboard() {
        $stats = $this->getStats();
        $recentBookings = $this->getRecentBookings();
        $recentUsers = $this->getRecentUsers();
        
        include('./views/admin/dashboard.php');
    }

    public function users($page = 1) {
        $limit = 10;
        $users = $this->user->getAllUsers($page, $limit);
        $totalUsers = $this->user->getTotalUsers();
        $totalPages = ceil($totalUsers / $limit);
        
        include('./views/admin/users.php');
    }

    public function cars($page = 1) {
        $car = new Car($this->db);
        
        // Gestion des opérations
        if (isset($_GET['op'])) {
            switch ($_GET['op']) {
                case 'add':
                    $this->showAddCarForm();
                    return;
                case 'edit':
                    if (isset($_GET['id'])) {
                        $this->showEditCarForm($_GET['id']);
                        return;
                    }
                    break;
            }
        }

        // Affichage de la liste des voitures
        $limit = 10;
        $cars = $car->getAll($page, $limit);
        $totalCars = $car->count();
        $totalPages = ceil($totalCars / $limit);
        
        include('./views/admin/cars.php');
    }

    public function bookings($page = 1) {
        $booking = new Booking($this->db);
        $limit = 10;
        $bookings = $booking->getAllWithDetails($page, $limit);
        $totalBookings = $booking->getTotal();
        $totalPages = ceil($totalBookings / $limit);
        
        include('./views/admin/bookings.php');
    }

    private function getStats() {
        $stats = [];
        
        // Statistiques des utilisateurs
        $stats['total_users'] = $this->user->getTotalUsers();
        
        // Statistiques des voitures
        $car = new Car($this->db);
        $stats['total_cars'] = $car->count();
        $stats['total_value'] = $this->calculateTotalValue($car);
        
        // Statistiques des réservations
        $booking = new Booking($this->db);
        $stats['total_bookings'] = $booking->getTotal();
        $stats['pending_bookings'] = $booking->getTotalByStatus('pending');
        
        return $stats;
    }

    private function calculateTotalValue($car) {
        $query = "SELECT SUM(price) as total FROM cars";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    private function getRecentBookings() {
        $booking = new Booking($this->db);
        return $booking->getAllWithDetails(1, 5);
    }

    private function getRecentUsers() {
        return $this->user->getAllUsers(1, 5);
    }

    public function updateUserRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            $newRole = $_POST['role'] ?? null;
            
            if ($userId && $newRole) {
                if ($this->user->updateRole($userId, $newRole)) {
                    echo json_encode(['success' => true]);
                    return;
                }
            }
            echo json_encode(['success' => false]);
        }
    }

    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? null;
            
            if ($userId && $userId != $_SESSION['user_id']) {
                if ($this->user->deleteUser($userId)) {
                    echo json_encode(['success' => true]);
                    return;
                }
            }
            echo json_encode(['success' => false]);
        }
    }

    public function updateBookingStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookingId = $_POST['booking_id'] ?? null;
            $newStatus = $_POST['status'] ?? null;
            
            if ($bookingId && $newStatus) {
                $booking = new Booking($this->db);
                if ($booking->updateStatus($bookingId, $newStatus)) {
                    echo json_encode(['success' => true]);
                    return;
                }
            }
            echo json_encode(['success' => false]);
        }
    }

    public function showAddCarForm() {
        include('./views/admin/add_car.php');
    }

    public function showAddUserForm() {
        include('./views/admin/add_user.php');
    }

    public function addCar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $car = new Car($this->db);
            
            // Traitement de l'image principale
            $uploadDir = 'uploads/cars/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $mainImage = $_FILES['image'];
            $mainImagePath = null;
            
            if ($mainImage['error'] === UPLOAD_ERR_OK) {
                $extension = pathinfo($mainImage['name'], PATHINFO_EXTENSION);
                $mainImagePath = $uploadDir . uniqid('car_') . '.' . $extension;
                if (!move_uploaded_file($mainImage['tmp_name'], $mainImagePath)) {
                    error_log("Erreur lors du déplacement de l'image: " . error_get_last()['message']);
                    header('Location: index.php?action=admin&page=cars&message=error_upload');
                    exit;
                }
            } else {
                error_log("Erreur lors du téléchargement de l'image: " . $mainImage['error']);
                header('Location: index.php?action=admin&page=cars&message=error_upload');
                exit;
            }

            // Préparation des données du véhicule
            $carData = [
                'brand' => $_POST['brand'],
                'model' => $_POST['model'],
                'year' => $_POST['year'],
                'price' => $_POST['price'],
                'mileage' => $_POST['mileage'],
                'fuel_type' => $_POST['fuel_type'],
                'transmission' => $_POST['transmission'],
                'power' => $_POST['power'],
                'description' => $_POST['description'],
                'image' => $mainImagePath
            ];

            // Debug des données
            error_log("Données du véhicule à insérer: " . print_r($carData, true));

            // Tentative d'insertion du véhicule
            if ($car->create($carData)) {
                header('Location: index.php?action=admin&page=cars&message=success');
                exit;
            } else {
                error_log("Échec de l'insertion du véhicule");
                header('Location: index.php?action=admin&page=cars&message=error');
                exit;
            }
        }
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification que les mots de passe correspondent
            if ($_POST['password'] !== $_POST['confirm_password']) {
                header('Location: index.php?action=admin&page=users&message=password_mismatch');
                exit;
            }

            // Vérification que l'email n'existe pas déjà
            if ($this->user->emailExists($_POST['email'])) {
                header('Location: index.php?action=admin&page=users&message=email_exists');
                exit;
            }

            // Préparation des données utilisateur
            $userData = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role' => $_POST['role'],
                'status' => $_POST['status'],
                'address' => $_POST['address']
            ];

            // Création de l'utilisateur
            if ($this->user->create($userData)) {
                header('Location: index.php?action=admin&page=users&message=success');
                exit;
            }
        }
        
        header('Location: index.php?action=admin&page=users&message=error');
        exit;
    }

    private function reArrayFiles($filePost) {
        $fileArray = [];
        $fileCount = count($filePost['name']);
        $fileKeys = array_keys($filePost);

        for ($i = 0; $i < $fileCount; $i++) {
            foreach ($fileKeys as $key) {
                $fileArray[$i][$key] = $filePost[$key][$i];
            }
        }

        return $fileArray;
    }

    public function showEditCarForm($id) {
        $car = new Car($this->db);
        $car->id = $id;
        $car = $car->readOne();
        
        if (!$car) {
            header('Location: index.php?action=admin&page=cars&message=not_found');
            exit;
        }
        
        include('./views/admin/edit_car.php');
    }

    public function updateCar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $car = new Car($this->db);
            
            // Traitement de l'image si une nouvelle est uploadée
            $mainImagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/cars/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $mainImage = $_FILES['image'];
                $extension = pathinfo($mainImage['name'], PATHINFO_EXTENSION);
                $mainImagePath = $uploadDir . uniqid('car_') . '.' . $extension;
                
                if (!move_uploaded_file($mainImage['tmp_name'], $mainImagePath)) {
                    error_log("Erreur lors du déplacement de l'image: " . error_get_last()['message']);
                    header('Location: index.php?action=admin&page=cars&message=error_upload');
                    exit;
                }
            }

            // Préparation des données du véhicule
            $carData = [
                'id' => $_POST['id'],
                'brand' => $_POST['brand'],
                'model' => $_POST['model'],
                'year' => $_POST['year'],
                'price' => $_POST['price'],
                'mileage' => $_POST['mileage'],
                'fuel_type' => $_POST['fuel_type'],
                'transmission' => $_POST['transmission'],
                'power' => $_POST['power'],
                'description' => $_POST['description']
            ];

            // Ajouter l'image seulement si une nouvelle a été uploadée
            if ($mainImagePath) {
                $carData['image'] = $mainImagePath;
                
                // Récupérer l'ancienne image pour la supprimer
                $car->id = $_POST['id'];
                $oldCar = $car->readOne();
                if ($oldCar && file_exists($oldCar['image'])) {
                    unlink($oldCar['image']);
                }
            }

            // Debug des données
            error_log("Données du véhicule à mettre à jour: " . print_r($carData, true));

            // Tentative de mise à jour du véhicule
            if ($car->update($carData)) {
                header('Location: index.php?action=admin&page=cars&message=update_success');
                exit;
            } else {
                // En cas d'échec, supprimer la nouvelle image si elle a été uploadée
                if ($mainImagePath && file_exists($mainImagePath)) {
                    unlink($mainImagePath);
                }
                header('Location: index.php?action=admin&page=cars&message=update_error');
                exit;
            }
        }
    }

    public function deleteCar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $carId = $_POST['car_id'] ?? null;
            
            if ($carId) {
                $car = new Car($this->db);
                if ($car->delete($carId)) {
                    echo json_encode(['success' => true]);
                    return;
                }
            }
            echo json_encode(['success' => false]);
        }
    }

    public function deleteBooking() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookingId = $_POST['booking_id'] ?? null;
            
            if ($bookingId) {
                $booking = new Booking($this->db);
                if ($booking->delete($bookingId)) {
                    echo json_encode(['success' => true]);
                    return;
                }
            }
            echo json_encode(['success' => false]);
        }
    }
} 