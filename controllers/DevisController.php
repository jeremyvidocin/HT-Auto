<?php
require_once('./models/Car.php');
require_once('./vendor/fpdf/fpdf.php');

class DevisController {
    private $db;
    private $carModel;

    public function __construct($db) {
        $this->db = $db;
        $this->carModel = new Car($db);
    }

    public function showDevisForm($car_id = null) {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Veuillez vous connecter pour générer un devis.";
            header('Location: index.php?action=login');
            exit;
        }

        // Vérifier si l'ID de la voiture est fourni
        if (!$car_id) {
            $_SESSION['error'] = "Aucune voiture sélectionnée.";
            header('Location: index.php?action=cars');
            exit;
        }

        // Récupérer les informations de la voiture
        $car = $this->carModel->getCarById($car_id);
        if (!$car) {
            $_SESSION['error'] = "Voiture non trouvée.";
            header('Location: index.php?action=cars');
            exit;
        }

        // Stocker les informations de la voiture en session pour la validation
        $_SESSION['devis_car'] = [
            'id' => $car_id,
            'price' => $car['price'],
            'model' => $car['brand'] . ' ' . $car['model']
        ];

        require_once('./views/devis/form.php');
    }

    public function generateDevis() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Session expirée. Veuillez vous reconnecter.";
            header('Location: index.php?action=login');
            exit;
        }

        // Vérifier si les informations de la voiture sont en session
        if (!isset($_SESSION['devis_car'])) {
            $_SESSION['error'] = "Session expirée. Veuillez recommencer.";
            header('Location: index.php?action=cars');
            exit;
        }

        $errors = [];

        // Validation des champs individuels avec messages spécifiques
        if (empty(trim($_POST['nom']))) {
            $errors[] = "Le nom est obligatoire";
        }
        if (empty(trim($_POST['email']))) {
            $errors[] = "L'email est obligatoire";
        }
        if (empty(trim($_POST['vehicule']))) {
            $errors[] = "Le véhicule est obligatoire";
        }
        if (empty(trim($_POST['prix']))) {
            $errors[] = "Le prix est obligatoire";
        }
        if (empty(trim($_POST['apport']))) {
            $errors[] = "L'apport est obligatoire";
        }
        if (empty(trim($_POST['duree']))) {
            $errors[] = "La durée est obligatoire";
        }
        if (empty(trim($_POST['taux']))) {
            $errors[] = "Le taux est obligatoire";
        }

        // Si des champs sont manquants, pas besoin de continuer les autres validations
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Validation du prix (doit correspondre au prix en session)
        if (floatval($_POST['prix']) !== floatval($_SESSION['devis_car']['price'])) {
            $errors[] = "Le prix du véhicule ne peut pas être modifié.";
        }

        // Validation du modèle (doit correspondre au modèle en session)
        if ($_POST['vehicule'] !== $_SESSION['devis_car']['model']) {
            $errors[] = "Le modèle du véhicule ne peut pas être modifié.";
        }

        // Validation de l'email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }

        // Validation de l'apport
        $apport = floatval($_POST['apport']);
        $prix = floatval($_POST['prix']);
        
        // Prix minimum pour l'apport (10% du prix)
        $apport_minimum = $prix * 0.1;
        
        if ($apport < $apport_minimum) {
            $errors[] = "L'apport minimum doit être de " . number_format($apport_minimum, 2, ',', ' ') . " € (10% du prix du véhicule).";
        } elseif ($apport >= $prix) {
            $errors[] = "L'apport ne peut pas être supérieur ou égal au prix du véhicule.";
        }

        // Validation de la durée
        $durees_valides = [12, 24, 36, 48, 60];
        if (!in_array(intval($_POST['duree']), $durees_valides)) {
            $errors[] = "La durée du prêt n'est pas valide.";
        }

        // Validation du taux
        $taux = floatval($_POST['taux']);
        if ($taux <= 0 || $taux > 20) {
            $errors[] = "Le taux d'intérêt doit être compris entre 0 et 20%.";
        }

        // S'il y a des erreurs, rediriger vers le formulaire
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST; // Sauvegarder les données du formulaire
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Si tout est valide, procéder à la génération du PDF
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $vehicule = htmlspecialchars($_POST['vehicule']);
        $duree = intval($_POST['duree']);

        // Calculs financiers
        $montant_a_financer = $prix - $apport;
        $taux_mensuel = ($taux / 100) / 12;
        $mensualite = ($montant_a_financer * $taux_mensuel * pow(1 + $taux_mensuel, $duree)) / (pow(1 + $taux_mensuel, $duree) - 1);
        $cout_total = $mensualite * $duree;
        $total_interets = $cout_total - $montant_a_financer;

        // Création du PDF
        $pdf = new DevisPDF();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 40);

        // Image de la voiture si disponible
        $car = $this->carModel->getCarById($_SESSION['devis_car']['id']);
        if ($car && !empty($car['image'])) {
            $image_path = './images/voitures/' . $car['image'];
            if (file_exists($image_path)) {
                // Ajout d'un cadre gris clair autour de l'image
                $pdf->SetFillColor(245, 245, 245);
                $pdf->Rect(9, 59, 92, 72, 'F');
                // Ajout de l'image avec une bordure
                $pdf->Image($image_path, 10, 60, 90);
                $pdf->Ln(80); // Espace pour l'image
            }
        }

        // Informations client
        $pdf->SectionTitle('Informations Client');
        $pdf->InfoField('Nom', $nom);
        $pdf->InfoField('Email', $email);
        $pdf->Ln(5);

        // Informations véhicule
        $pdf->SectionTitle('Details du Vehicule');
        $pdf->InfoField('Modele', $vehicule);
        $pdf->InfoField('Prix', $pdf->formatMontant($prix));
        $pdf->Ln(5);

        // Détails du financement
        $pdf->SectionTitle('Details du Financement');
        $pdf->InfoField('Apport initial', $pdf->formatMontant($apport));
        $pdf->InfoField('Montant a financer', $pdf->formatMontant($montant_a_financer));
        $pdf->InfoField('Duree du pret', $duree . ' mois');
        $pdf->InfoField('Taux d\'interet annuel', number_format($taux, 2, ',', ' ') . '%');
        $pdf->Ln(5);

        // Résumé mensuel avec tableau
        $pdf->SectionTitle('Echeancier');
        
        // En-têtes du tableau
        $pdf->SetFillColor(230, 230, 230);
        $pdf->SetFont('Helvetica', 'B', 11);
        $pdf->Cell(60, 8, 'Mensualite', 1, 0, 'C', true);
        $pdf->Cell(65, 8, 'Cout des interets', 1, 0, 'C', true);
        $pdf->Cell(65, 8, 'Cout total', 1, 1, 'C', true);
        
        // Données du tableau
        $pdf->SetFont('Helvetica', '', 11);
        $pdf->Cell(60, 8, $pdf->formatMontant($mensualite), 1, 0, 'C');
        $pdf->Cell(65, 8, $pdf->formatMontant($total_interets), 1, 0, 'C');
        $pdf->Cell(65, 8, $pdf->formatMontant($cout_total), 1, 1, 'C');

        // Notes et conditions
        $pdf->Ln(10);
        $pdf->SetFont('Helvetica', 'I', 9);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->MultiCell(0, 5, 'Note : Ce devis est fourni a titre indicatif et ne constitue pas une offre contractuelle. Les taux et conditions peuvent varier selon votre profil. Tous les montants sont exprimes en euros TTC.');

        // Nettoyage de la session
        unset($_SESSION['devis_car']);
        unset($_SESSION['form_data']);

        // Génération du PDF
        $filename = 'devis_' . date('Y-m-d_His') . '.pdf';
        $pdf->Output('D', $filename);
    }
}

// Classe PDF personnalisée
class DevisPDF extends FPDF {
    private $dealerInfo = [
        'name' => 'HT Auto',
        'address' => '123 Avenue des Vehicules, 75000 Paris',
        'phone' => '01 23 45 67 89',
        'email' => 'contact@htauto.fr',
        'siret' => 'SIRET : 123 456 789 00012'
    ];

    function __construct() {
        parent::__construct();
    }

    // Fonction utilitaire pour formater les montants avec le symbole euro
    function formatMontant($montant) {
        return number_format($montant, 2, ',', ' ') . ' ' . chr(128);
    }

    function Header() {
        // Définition des couleurs personnalisées
        $this->SetFillColor(40, 40, 40);
        $this->SetTextColor(255, 255, 255);
        
        // En-tête avec dégradé
        $this->Rect(0, 0, 210, 40, 'F');
        
        // Logo
        if (file_exists('./images/logo.png')) {
            $this->Image('./images/logo.png', 10, 10, 30);
        }

        // Informations de la concession (en haut à droite)
        $this->SetFont('Helvetica', '', 8);
        $this->SetTextColor(200, 200, 200);
        $this->SetXY(120, 10);
        $this->Cell(80, 4, $this->dealerInfo['name'], 0, 2, 'R');
        $this->Cell(80, 4, $this->dealerInfo['address'], 0, 2, 'R');
        $this->Cell(80, 4, 'Tel : ' . $this->dealerInfo['phone'], 0, 2, 'R');
        $this->Cell(80, 4, $this->dealerInfo['email'], 0, 2, 'R');
        
        // Titre du devis (centré)
        $this->SetXY(10, 15);
        $this->SetFont('Helvetica', 'B', 24);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(190, 10, 'Devis de Financement Automobile', 0, 1, 'C');
        
        // Date de génération
        $this->SetFont('Helvetica', '', 12);
        $this->Cell(190, 10, 'Genere le ' . date('d/m/Y'), 0, 1, 'C');
        
        // Reset des couleurs
        $this->SetTextColor(0, 0, 0);
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-30);
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        
        // Informations légales
        $this->Cell(0, 5, $this->dealerInfo['siret'], 0, 1, 'C');
        $this->Cell(0, 5, $this->dealerInfo['name'] . ' - ' . $this->dealerInfo['address'], 0, 1, 'C');
        $this->Cell(0, 5, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function SectionTitle($title) {
        $this->SetFillColor(240, 240, 240);
        $this->SetFont('Helvetica', 'B', 14);
        $this->Cell(0, 10, $title, 0, 1, 'L', true);
        $this->Ln(5);
    }

    function InfoField($label, $value) {
        $this->SetFont('Helvetica', 'B', 11);
        $this->Cell(60, 8, $label . ':', 0);
        $this->SetFont('Helvetica', '', 11);
        $this->Cell(0, 8, $value, 0);
        $this->Ln();
    }
}
?> 