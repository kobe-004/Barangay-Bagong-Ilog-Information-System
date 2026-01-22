<?php
session_start();

include 'connection.php'; // Ensure this file includes your database connection
require 'vendor/autoload.php'; // Include PHPMailer autoload if using Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['accept'])) {
        $email = $_POST['email_pen_doc'];
        
    // Fetch the email from the database
    $sql = "SELECT * FROM pending_documents WHERE email_user = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, start session
        $row = $result->fetch_assoc();
        $_SESSION['pending_document_id'] = $row['pending_document_id']; 
        $_SESSION['email_user'] = $email; 

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'capalaran_zaneallyson@plpasig.edu.ph'; // SMTP username
            $mail->Password = 'nowt tndp csxz klxg'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('capalaran_zaneallyson@plpasig.edu.ph', 'Bagong Ilog');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Document Pickup';
            $mail->Body    = "You can now pick up your barangay clearance at the barangay hall!";

            $mail->send();
            $msg = "Notify email sent successfully.";
        } catch (Exception $e) {
            $msg = "Failed to send verification email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email not found
        $msg = "Email not found.";
    }

    $stmt->close();
  
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['decline'])) {
        $email = $_POST['email_pen_doc'];
        
    // Fetch the email from the database
    $sql = "SELECT * FROM pending_documents WHERE email_user = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, start session
        $row = $result->fetch_assoc();
        $_SESSION['pending_document_id'] = $row['pending_document_id']; 
        $_SESSION['email_user'] = $email; 

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'capalaran_zaneallyson@plpasig.edu.ph'; // SMTP username
            $mail->Password = 'nowt tndp csxz klxg'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('capalaran_zaneallyson@plpasig.edu.ph', 'Bagong Ilog');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Document Request Decline';
            $mail->Body    = "Your requested barangay clearance has been declined. Submit another request.";

            $mail->send();
            $msg = "Notify email sent successfully.";
        } catch (Exception $e) {
            $msg = "Failed to send verification email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email not found
        $msg = "Email not found.";
    }

    $stmt->close();
  
    }
}
?>
