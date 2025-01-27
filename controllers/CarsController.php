<?php
// controllers/CarController.php
class CarController {
    private $car;

    public function __construct($db) {
        $this->car = new Car($db);
    }

    public function index() {
        $cars = $this->car->read();
        require_once('./views/cars/index.php');
    }

    public function show($id) {
        $this->car->id = $id;
        $car = $this->car->readOne();
        require_once('./views/cars/show.php');
    }
}
?>