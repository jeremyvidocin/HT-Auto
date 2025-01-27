<?php
// index.php (Point d'entrée)
require_once('./config/Database.php');
require_once('./models/Car.php');
require_once('./controllers/CarsController.php');

$database = new Database();
$db = $database->getConnection();
$controller = new CarController($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch($action) {
    case 'show':
        $controller->show($id);
        break;
    default:
        $controller->index();
        break;
}
?>