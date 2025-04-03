<?php
session_start();
include('db.php');
include('isAuthenticated.php');
require 'vendor/autoload.php';  // Load Composer dependencies (for PhpSpreadsheet and DomPDF)

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SESSION['role'] == 'user') {
    header('Location: login.php');
    exit();
}

$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
}

$filterDesignation = '';
if (isset($_GET['filter_designation'])) {
    $filterDesignation = trim($_GET['filter_designation']);
}

try {
    $sql = "SELECT * FROM section";
    $conditions = [];
    $params = [];

    if (!empty($searchTerm)) {
        $conditions[] = "designation LIKE :searchTerm";
        $params[':searchTerm'] = '%' . $searchTerm . '%';
    }

    if (!empty($filterDesignation)) {
        $conditions[] = "designation = :filterDesignation";
        $params[':filterDesignation'] = $filterDesignation;
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Handle export requests
if (isset($_GET['export'])) {
    $exportType = $_GET['export'];

    if ($exportType == 'csv') {
        // CSV Export
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="sections.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Designation', 'Description']);
        foreach ($sections as $section) {
            fputcsv($output, $section);
        }
        fclose($output);
        exit();
    }

    if ($exportType == 'xlsx') {
        // Excel Export (XLSX)
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Designation');
        $sheet->setCellValue('C1', 'Description');

        $row = 2;
        foreach ($sections as $section) {
            $sheet->setCellValue('A' . $row, $section['id']);
            $sheet->setCellValue('B' . $row, $section['designation']);
            $sheet->setCellValue('C' . $row, $section['description']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sections.xlsx"');
        $writer->save('php://output');
        exit();
    }

    if ($exportType == 'pdf') {
        // PDF Export
        $pdf = new Dompdf();
        $html = '<h1>Liste des Sections</h1><table border="1"><thead><tr><th>ID</th><th>Designation</th><th>Description</th></tr></thead><tbody>';
        foreach ($sections as $section) {
            $html .= "<tr><td>{$section['id']}</td><td>{$section['designation']}</td><td>{$section['description']}</td></tr>";
        }
        $html .= '</tbody></table>';
        
        $pdf->loadHtml($html);
        $pdf->render();
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="sections.pdf"');
        echo $pdf->output();
        exit();
    }
}
?>
