<?php
require('fpdf/fpdf.php'); // Include the FPDF library
include 'Includes/dbcon.php';
include 'Includes/session.php';

// Check if the ID is set
if (isset($_SESSION['userId'])) {
    $studentId = $_SESSION['userId'];

    // Fetch attendance records for the specific student
    $sql = "SELECT * FROM attendance WHERE LID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    
    // Title
    $pdf->Cell(0, 10, 'Attendance Sheet', 0, 1, 'C');
    $pdf->Ln(10); // New line

    // Table header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Date', 1);
    $pdf->Cell(40, 10, 'Status', 1);
    $pdf->Ln();

    // Table data
    $pdf->SetFont('Arial', '', 12);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['attendance_date'], 1);
        $pdf->Cell(40, 10, $row['status'], 1);
        $pdf->Ln();
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Output the PDF
    $pdf->Output('D', 'attendance_sheet_' . $studentId . '.pdf'); // Download the PDF
} else {
    echo "No student ID provided.";
}
?>
