<?php
require_once('./config/Database.php');
require_once('./models/Car.php');
require_once('./controllers/CarsController.php');
require_once('./controllers/PagesController.php');

$database = new Database();
$db = $database->getConnection();
$carController = new CarController($db);
$pageController = new PagesController($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch($action) {
    case 'show':
        $carController->show($id);
        break;
    case 'cars':
        $carController->index();
        break;
    default:
        $pageController->home();
        break;
}
?>