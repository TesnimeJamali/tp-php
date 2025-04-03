<?php
include('db.php');
include('vendor/autoload.php'); // Load Composer's autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $fileType = isset($_GET['type']) ? $_GET['type'] : 'csv'; // default to CSV if no type is provided

    try {
        $sql = "SELECT * FROM etudiant";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        switch ($fileType) {
            case 'excel':
                // Generate Excel File
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="students.xlsx"');
                header('Cache-Control: max-age=0');

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'Name');
                $sheet->setCellValue('B1', 'Birthday');
                $sheet->setCellValue('C1', 'Image');
                $sheet->setCellValue('D1', 'Section');
                
                $row = 2;
                foreach ($students as $student) {
                    $sheet->setCellValue('A' . $row, $student['name']);
                    $sheet->setCellValue('B' . $row, $student['birthday']);
                    $sheet->setCellValue('C' . $row, $student['image']);
                    $sheet->setCellValue('D' . $row, $student['section']);
                    $row++;
                }
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                break;

            case 'csv':
                // Generate CSV File
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment;filename="students.csv"');
                $output = fopen('php://output', 'w');
                fputcsv($output, ['Name', 'Birthday', 'Image', 'Section']);
                
                foreach ($students as $student) {
                    fputcsv($output, [$student['name'], $student['birthday'], $student['image'], $student['section']]);
                }
                fclose($output);
                break;

            case 'pdf':
                // Generate PDF File
                $html = '<h2>Students List</h2><table border="1" cellpadding="5"><tr><th>Name</th><th>Birthday</th><th>Image</th><th>Section</th></tr>';
                foreach ($students as $student) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($student['name']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($student['birthday']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($student['image']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($student['section']) . '</td>';
                    $html .= '</tr>';
                }
                $html .= '</table>';

                // Initialize Dompdf
                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->render();
                
                // Output the generated PDF (force download)
                $dompdf->stream('students.pdf', array('Attachment' => 1));
                break;

            default:
                throw new Exception('Invalid file type requested.');
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>
