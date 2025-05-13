<?php
// controllers/CarController.php
class CarController {
    private $car;

    public function __construct($db) {
        $this->car = new Car($db);
    }

    public function index() {
        // Récupérer les filtres depuis l'URL
        $filters = [
            'brand' => $_GET['brand'] ?? null,
            'price_min' => $_GET['price_min'] ?? null,
            'price_max' => $_GET['price_max'] ?? null,
            'year_min' => $_GET['year_min'] ?? null,
            'year_max' => $_GET['year_max'] ?? null,
            'mileage_min' => $_GET['mileage_min'] ?? null,
            'mileage_max' => $_GET['mileage_max'] ?? null,
            'fuel_type' => $_GET['fuel_type'] ?? null,
            'transmission' => $_GET['transmission'] ?? null,
            'sort' => $_GET['sort'] ?? null
        ];
        
        // Récupérer les options de filtrage
        $filterOptions = $this->car->getFilterOptions();
        
        // Récupérer les voitures filtrées
        $cars = $this->car->getFilteredCars($filters);
        
        require_once('./views/cars/index.php');
    }

    public function show($id) {
        $this->car->id = $id;
        $car = $this->car->readOne();
        require_once('./views/cars/show.php');
    }
}
?>