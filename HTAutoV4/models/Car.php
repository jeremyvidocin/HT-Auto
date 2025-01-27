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
}