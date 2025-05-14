<?php
session_start();
require_once('./config/Database.php');
require_once('./models/Car.php');
require_once('./models/User.php');
require_once('./controllers/CarsController.php');
require_once('./controllers/PagesController.php');
require_once('./controllers/ContactController.php');
require_once('./controllers/AuthController.php');
require_once('./models/Booking.php');
require_once('./controllers/BookingController.php');
require_once('./controllers/DevisController.php');
require_once('./controllers/AdminController.php');

$database = new Database();
$db = $database->getConnection();
$carController = new CarController($db);
$pageController = new PagesController($db);
$contactController = new ContactController($db);
$devisController = new DevisController($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch($action) {
    // Routes d'administration
    case 'admin':
        $adminController = new AdminController($db);
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $operation = isset($_GET['operation']) ? $_GET['operation'] : null;

        // Gérer les opérations d'administration
        if ($operation) {
            switch($operation) {
                case 'addUser':
                    $adminController->addUser();
                    break;
                case 'addCar':
                    $adminController->addCar();
                    break;
                case 'updateCar':
                    $adminController->updateCar();
                    break;
                case 'deleteCar':
                    $adminController->deleteCar();
                    break;
                case 'deleteBooking':
                    $adminController->deleteBooking();
                    break;
                case 'updateUserRole':
                    $adminController->updateUserRole();
                    break;
                case 'deleteUser':
                    $adminController->deleteUser();
                    break;
                case 'updateBookingStatus':
                    $adminController->updateBookingStatus();
                    break;
            }
            return;
        }
        
        switch($page) {
            case 'users':
                if (isset($_GET['op']) && $_GET['op'] === 'add') {
                    $adminController->showAddUserForm();
                } else {
                    $adminController->users(isset($_GET['p']) ? $_GET['p'] : 1);
                }
                break;
            case 'cars':
                if (isset($_GET['op']) && $_GET['op'] === 'add') {
                    $adminController->showAddCarForm();
                } else {
                    $adminController->cars(isset($_GET['p']) ? $_GET['p'] : 1);
                }
                break;
            case 'bookings':
                $adminController->bookings(isset($_GET['p']) ? $_GET['p'] : 1);
                break;
            default:
                $adminController->dashboard();
                break;
        }
        break;

    case 'show':
        $carController->show($id);
        break;
    case 'cars':
        $carController->index();
        break;
    case 'contact':
        if (isset($_GET['submit'])) {
            $contactController->submit();
        } else {
            $contactController->index();
        }
        break;
    case 'login':
        $authController = new AuthController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->showLogin();
        }
        break;
    
    case 'register':
        $authController = new AuthController($db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            $authController->showRegister();
        }
        break;
    
    case 'profile':
        $authController = new AuthController($db);
        $authController->showProfile();
        break;
    
    case 'logout':
        $authController = new AuthController($db);
        $authController->logout();
        break;
    
    case 'profile_update':
        $authController = new AuthController($db);
        $authController->updateProfile();
        break;
        
    case 'password_update':
        $authController = new AuthController($db);
        $authController->updatePassword();
        break;
    
    // Routes de réservation
    case 'test_drive':
        $bookingController = new BookingController($db);
        $bookingController->showTestDriveForm($_GET['car_id']);
        break;
    
    case 'process_test_drive':
        $bookingController = new BookingController($db);
        $bookingController->processTestDriveBooking();
        break;
    
    case 'my_bookings':
        $bookingController = new BookingController($db);
        $bookingController->showUserBookings();
        break;
    
    case 'cancel_booking':
        $bookingController = new BookingController($db);
        $bookingController->cancelBooking($_GET['id']);
        break;

    // Nouvelles routes pour les devis
    case 'devis':
        $devisController->showDevisForm(isset($_GET['car_id']) ? $_GET['car_id'] : null);
        break;
    
    case 'generate_devis':
        $devisController->generateDevis();
        break;
    
    default:
        $pageController->home();
        break;
}
?>