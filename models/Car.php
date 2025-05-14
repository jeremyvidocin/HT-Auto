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

    // Nouvelle méthode pour obtenir une voiture par son ID
    public function getCarById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function count() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (brand, model, year, price, mileage, fuel_type, transmission, power, description, image)
                    VALUES
                    (:brand, :model, :year, :price, :mileage, :fuel_type, :transmission, :power, :description, :image)";

            $stmt = $this->conn->prepare($query);

            // Liaison des valeurs
            $stmt->bindParam(":brand", $data['brand']);
            $stmt->bindParam(":model", $data['model']);
            $stmt->bindParam(":year", $data['year']);
            $stmt->bindParam(":price", $data['price']);
            $stmt->bindParam(":mileage", $data['mileage']);
            $stmt->bindParam(":fuel_type", $data['fuel_type']);
            $stmt->bindParam(":transmission", $data['transmission']);
            $stmt->bindParam(":power", $data['power']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":image", $data['image']);

            // Exécution de la requête
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Erreur SQL: " . implode(" ", $stmt->errorInfo()));
            }
            
            return $result;
        } catch(PDOException $e) {
            error_log("Exception PDO lors de la création du véhicule: " . $e->getMessage());
            return false;
        } catch(Exception $e) {
            error_log("Exception lors de la création du véhicule: " . $e->getMessage());
            return false;
        }
    }

    public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }

    public function addImage($carId, $imagePath) {
        $query = "INSERT INTO car_images (car_id, image_path) VALUES (:car_id, :image_path)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":car_id", $carId);
        $stmt->bindParam(":image_path", $imagePath);

        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function getImages($carId) {
        $query = "SELECT image_path FROM car_images WHERE car_id = :car_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":car_id", $carId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function update($data) {
        try {
            $query = "UPDATE " . $this->table_name . " SET 
                    brand = :brand,
                    model = :model,
                    year = :year,
                    price = :price,
                    mileage = :mileage,
                    fuel_type = :fuel_type,
                    transmission = :transmission,
                    power = :power,
                    description = :description" .
                    ($data['image'] ? ", image = :image" : "") .
                    " WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            // Liaison des valeurs
            $stmt->bindParam(":brand", $data['brand']);
            $stmt->bindParam(":model", $data['model']);
            $stmt->bindParam(":year", $data['year']);
            $stmt->bindParam(":price", $data['price']);
            $stmt->bindParam(":mileage", $data['mileage']);
            $stmt->bindParam(":fuel_type", $data['fuel_type']);
            $stmt->bindParam(":transmission", $data['transmission']);
            $stmt->bindParam(":power", $data['power']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":id", $data['id']);
            
            if ($data['image']) {
                $stmt->bindParam(":image", $data['image']);
            }

            // Exécution de la requête
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("Erreur SQL lors de la mise à jour: " . implode(" ", $stmt->errorInfo()));
            }
            
            return $result;
        } catch(PDOException $e) {
            error_log("Exception PDO lors de la mise à jour du véhicule: " . $e->getMessage());
            return false;
        } catch(Exception $e) {
            error_log("Exception lors de la mise à jour du véhicule: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            // D'abord, récupérer l'image du véhicule pour la supprimer
            $this->id = $id;
            $car = $this->readOne();
            
            // Supprimer le véhicule de la base de données
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            
            if ($stmt->execute()) {
                // Si la suppression est réussie, supprimer l'image associée
                if ($car && !empty($car['image']) && file_exists($car['image'])) {
                    unlink($car['image']);
                }
                return true;
            }
            
            return false;
        } catch(PDOException $e) {
            error_log("Exception PDO lors de la suppression du véhicule: " . $e->getMessage());
            return false;
        } catch(Exception $e) {
            error_log("Exception lors de la suppression du véhicule: " . $e->getMessage());
            return false;
        }
    }
}