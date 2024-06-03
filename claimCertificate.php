<?php
session_start();
include('./server/koneksi.php');

if (!isset($_SESSION['logged_in'])) {
  header('location: login.php');
  exit;
}

if (isset($_POST['campaignId'])) {
  $campaignId = $_POST['campaignId'];
  $userId = $_SESSION['userId'];

  // Verify feedback existence
  $feedbackSql = "SELECT feedbackId FROM userFeedback WHERE userId = ? AND campaignId = ?";
  if ($feedbackStmt = $conn->prepare($feedbackSql)) {
    $feedbackStmt->bind_param('ii', $userId, $campaignId);
    $feedbackStmt->execute();
    $feedbackResult = $feedbackStmt->get_result();
    if ($feedbackResult->num_rows > 0) {
      // Generate or retrieve certificate file
      $certificateFile = generateCertificate($userId, $campaignId);
      
      // Download the certificate
      if (file_exists($certificateFile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($certificateFile) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($certificateFile));
        flush(); // Flush system output buffer
        readfile($certificateFile);
        exit;
      } else {
        $_SESSION['statusDanger'] = "Certificate generation failed.";
        header('Location: profile.php');
      }
    } else {
      $_SESSION['statusDanger'] = "No feedback found, cannot claim certificate.";
      header('Location: profile.php');
    }
    $feedbackStmt->close();
  }
}

function generateCertificate($userId, $campaignId) {
  // Ensure FPDF library is included
  require('fpdf/fpdf.php');
  $certificateFile = "./assets/certificate/certificate_$userId_$campaignId.pdf";

  // Check if file already exists, if not, generate it
  if (!file_exists($certificateFile)) {
    // Logic to create PDF certificate
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, "Certificate of Participation");
    $pdf->Ln();
    $pdf->Cell(40, 10, "User ID: $userId");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Campaign ID: $campaignId");
    $pdf->Output('F', $certificateFile);
  }
  return $certificateFile;
}
?>
