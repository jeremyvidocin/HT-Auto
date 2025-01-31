<?php
// controllers/PagesController.php
class PagesController {
    private $db;
    private $car;

    public function __construct($db) {
        $this->db = $db;
        $this->car = new Car($db);
    }

    public function home() {
        // Récupérer les voitures à mettre en vedette
        $featuredQuery = "SELECT * FROM cars ORDER BY RAND() LIMIT 3";
        $featuredStmt = $this->db->prepare($featuredQuery);
        $featuredStmt->execute();
        $featuredCars = $featuredStmt->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer les statistiques
        $statsQuery = "SELECT 
            COUNT(*) as total_cars, 
            MIN(year) as oldest_car, 
            MAX(price) as max_price,
            AVG(price) as avg_price
        FROM cars";
        $statsStmt = $this->db->prepare($statsQuery);
        $statsStmt->execute();
        $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);

        require_once('./views/pages/home.php');
    }
}
?>