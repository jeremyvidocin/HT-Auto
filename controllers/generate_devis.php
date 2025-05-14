<?php
require('../vendor/fpdf/fpdf.php');

class DevisPDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Devis de Financement Automobile', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Récupération des données du formulaire
$nom = htmlspecialchars($_POST['nom']);
$email = htmlspecialchars($_POST['email']);
$vehicule = htmlspecialchars($_POST['vehicule']);
$prix = floatval($_POST['prix']);
$apport = floatval($_POST['apport']);
$duree = intval($_POST['duree']);
$taux = floatval($_POST['taux']);

// Calcul du financement
$montant_a_financer = $prix - $apport;
$taux_mensuel = ($taux / 100) / 12;
$mensualite = ($montant_a_financer * $taux_mensuel * pow(1 + $taux_mensuel, $duree)) / (pow(1 + $taux_mensuel, $duree) - 1);
$cout_total = $mensualite * $duree;
$total_interets = $cout_total - $montant_a_financer;

// Création du PDF
$pdf = new DevisPDF();
$pdf->AddPage();

// Informations client
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Informations Client', 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, 'Nom: ' . $nom, 0, 1);
$pdf->Cell(0, 7, 'Email: ' . $email, 0, 1);
$pdf->Ln(5);

// Informations véhicule
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Détails du Véhicule', 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, 'Modèle: ' . $vehicule, 0, 1);
$pdf->Cell(0, 7, 'Prix: ' . number_format($prix, 2, ',', ' ') . ' €', 0, 1);
$pdf->Ln(5);

// Détails du financement
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Détails du Financement', 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, 'Apport initial: ' . number_format($apport, 2, ',', ' ') . ' €', 0, 1);
$pdf->Cell(0, 7, 'Montant à financer: ' . number_format($montant_a_financer, 2, ',', ' ') . ' €', 0, 1);
$pdf->Cell(0, 7, 'Durée du prêt: ' . $duree . ' mois', 0, 1);
$pdf->Cell(0, 7, 'Taux d\'intérêt annuel: ' . number_format($taux, 2, ',', ' ') . '%', 0, 1);
$pdf->Ln(5);

// Résumé mensuel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Échéancier', 0, 1);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, 'Mensualité: ' . number_format($mensualite, 2, ',', ' ') . ' €', 0, 1);
$pdf->Cell(0, 7, 'Coût total des intérêts: ' . number_format($total_interets, 2, ',', ' ') . ' €', 0, 1);
$pdf->Cell(0, 7, 'Coût total du crédit: ' . number_format($cout_total, 2, ',', ' ') . ' €', 0, 1);

// Notes et conditions
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 9);
$pdf->MultiCell(0, 5, 'Note: Ce devis est fourni à titre indicatif et ne constitue pas une offre contractuelle. Les taux et conditions peuvent varier selon votre profil. Tous les montants sont exprimés en euros TTC.');

// Génération du PDF
$filename = 'devis_' . date('Y-m-d_His') . '.pdf';
$pdf->Output('D', $filename);
?> 