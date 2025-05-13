<?php
// models/Car.php
class Car {
    private $conn;
    private $table_name = "cars";

    public $id;
    public $brand;
    public $model;
    public $year;
    public $price;
    public $mileage;
    public $fuel_type;
    public $transmission;
    public $power;
    public $image;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY brand, model";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->brand = $row['brand'];
            $this->model = $row['model'];
            $this->year = $row['year'];
            $this->price = $row['price'];
            $this->mileage = $row['mileage'];
            $this->fuel_type = $row['fuel_type'];
            $this->transmission = $row['transmission'];
            $this->power = $row['power'];
            $this->image = $row['image'];
            $this->description = $row['description'];
        }

        return $row;
    }

    // models/Car.php - Ajoutez cette méthode à votre classe Car existante

    public function getFilteredCars($filters = []) {
        $conditions = [];
        $params = [];
        $query = "SELECT * FROM " . $this->table_name . " WHERE 1=1";
        
        // Filtre par marque
        if (!empty($filters['brand'])) {
            $conditions[] = "brand = ?";
            $params[] = $filters['brand'];
        }
        
        // Filtre par prix
        if (!empty($filters['price_min'])) {
            $conditions[] = "price >= ?";
            $params[] = $filters['price_min'];
        }
        if (!empty($filters['price_max'])) {
            $conditions[] = "price <= ?";
            $params[] = $filters['price_max'];
        }
        
        // Filtre par année
        if (!empty($filters['year_min'])) {
            $conditions[] = "year >= ?";
            $params[] = $filters['year_min'];
        }
        if (!empty($filters['year_max'])) {
            $conditions[] = "year <= ?";
            $params[] = $filters['year_max'];
        }
        
        // Filtre par kilométrage
        if (!empty($filters['mileage_min'])) {
            $conditions[] = "mileage >= ?";
            $params[] = $filters['mileage_min'];
        }
        if (!empty($filters['mileage_max'])) {
            $conditions[] = "mileage <= ?";
            $params[] = $filters['mileage_max'];
        }
        
        // Filtre par type de carburant
        if (!empty($filters['fuel_type'])) {
            $conditions[] = "fuel_type = ?";
            $params[] = $filters['fuel_type'];
        }
        
        // Filtre par transmission
        if (!empty($filters['transmission'])) {
            $conditions[] = "transmission = ?";
            $params[] = $filters['transmission'];
        }

        // Ajouter les conditions à la requête
        if (!empty($conditions)) {
            $query .= " AND " . implode(" AND ", $conditions);
        }
        
        // Ajout du tri
        $query .= " ORDER BY ";
        if (!empty($filters['sort'])) {
            switch($filters['sort']) {
                case 'price_asc':
                    $query .= "price ASC";
                    break;
                case 'price_desc':
                    $query .= "price DESC";
                    break;
                case 'year_desc':
                    $query .= "year DESC";
                    break;
                case 'mileage_asc':
                    $query .= "mileage ASC";
                    break;
                default:
                    $query .= "brand, model";
            }
        } else {
            $query .= "brand, model";
        }
        
        $stmt = $this->conn->prepare($query);
        foreach ($params as $i => $param) {
            $stmt->bindValue($i + 1, $param);
        }
        $stmt->execute();
        
        return $stmt;
    }

    // Méthode pour obtenir les valeurs uniques pour les filtres
    public function getFilterOptions() {
        $options = [
            'brands' => [],
            'fuel_types' => [],
            'transmissions' => [],
            'year_range' => ['min' => 0, 'max' => 0],
            'price_range' => ['min' => 0, 'max' => 0],
            'mileage_range' => ['min' => 0, 'max' => 0]
        ];
        
        // Récupérer les marques uniques
        $query = "SELECT DISTINCT brand FROM " . $this->table_name . " ORDER BY brand";
        $stmt = $this->conn->query($query);
        $options['brands'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Récupérer les types de carburant uniques
        $query = "SELECT DISTINCT fuel_type FROM " . $this->table_name . " ORDER BY fuel_type";
        $stmt = $this->conn->query($query);
        $options['fuel_types'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Récupérer les types de transmission uniques
        $query = "SELECT DISTINCT transmission FROM " . $this->table_name . " ORDER BY transmission";
        $stmt = $this->conn->query($query);
        $options['transmissions'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Récupérer les plages d'années, prix et kilométrage
        $query = "SELECT 
            MIN(year) as min_year, MAX(year) as max_year,
            MIN(price) as min_price, MAX(price) as max_price,
            MIN(mileage) as min_mileage, MAX(mileage) as max_mileage
            FROM " . $this->table_name;
        $stmt = $this->conn->query($query);
        $ranges = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $options['year_range'] = ['min' => $ranges['min_year'], 'max' => $ranges['max_year']];
        $options['price_range'] = ['min' => $ranges['min_price'], 'max' => $ranges['max_price']];
        $options['mileage_range'] = ['min' => $ranges['min_mileage'], 'max' => $ranges['max_mileage']];
        
        return $options;
    }
}