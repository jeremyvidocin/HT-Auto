<?php
// controllers/ContactController.php
class ContactController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        // Coordonnées de la concession
        $dealership = [
            'name' => 'HT Auto la',
            'address' => '123 Avenue des Véhicules, 75000 Paris',
            'phone' => '01 23 45 67 89',
            'email' => 'contact@premium-auto.fr',
            'hours' => [
                'Lundi - Vendredi' => '9h00 - 19h00',
                'Samedi' => '10h00 - 18h00',
                'Dimanche' => 'Fermé'
            ]
        ];

        require_once('./views/pages/contact.php');
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Traitement du formulaire ici
            // Pour l'instant, on redirige simplement
            header('Location: index.php?action=contact&status=success');
            exit;
        }
    }
}
?>