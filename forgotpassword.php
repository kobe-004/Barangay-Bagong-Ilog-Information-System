<?php
session_start();

include 'connection.php'; // Make sure this file includes your database connection
require 'vendor/autoload.php'; // Include PHPMailer autoload if using Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = ''; // Initialize message variable
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Fetch the email from the database (you can modify this as per your database structure)
    $sql = "SELECT * FROM resident WHERE Email = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {    
        // User exists, start session
        $_SESSION['admin'] = "resident";  
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['resident_id']; 
        $_SESSION['email'] = $email; 


        $stmt->close(); 
        $connect->close(); 

        // Generate and send OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + 300;

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            // Server settings
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
            $mail->Subject = 'Forgot Password';
            $mail->Body    = "Your OTP code is $otp";

            $mail->send();
            header("Location: otp.php");
            exit();
        } catch (Exception $e) {
            echo "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        
        $sqlAdmin = "SELECT * FROM admin WHERE email = ?";
        $stmt = $connect->prepare($sqlAdmin);
        $stmt->bind_param("s", $email);

        $stmt->execute();
        $resultAdmin = $stmt->get_result();

        if ($resultAdmin->num_rows > 0) { 
            $_SESSION['admin'] = "admin";  
            // Admin exists, start session
            $row = $resultAdmin->fetch_assoc();
            $_SESSION['id'] = $row['admin_id']; 
            $_SESSION['email'] = $email; 

            
            $stmt->close(); 
            $connect->close(); 

            // Generate and send OTP
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiry'] = time() + 300;

            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);
            try {
                // Server settings
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
                $mail->Subject = 'Forgot Password';
                $mail->Body    = "Your OTP code is $otp";

                $mail->send();
                header("Location: otp.php");
                exit();
            } catch (Exception $e) {
                echo "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        else {
            // Email not found
            $msg = "Email not found.";
        }
       
    }

    $stmt->close();
    $connect->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
           
body {
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background: #fff;
    padding: 60px;
    border-radius: 50px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: rgba(63, 69, 79, 0.5);
    border: 1px solid white;
    width: 400px;
    text-align: center;
}
#sub-head {
    font-size: 13px;
    color: white;
}

h2 {
    margin-top: 0;
    color: white;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}


label {
    display: block;
    margin-bottom: 5px;
    color: white;
}

input[type="email"] {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    background-color: transparent;
    border: 2px solid white;
    border-radius: 10px;
    color: white;
}

.button-group {
    display: flex;
    justify-content: space-between;
}

button {
    background-color: black;
    color: white;
    padding: 12px 15px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
   
    margin-top: 10px;
    
}

button:hover {
    background-color: #0056b3;
}

button#backButton:hover {
    background-color: #5a6268;
}
@keyframes lightUp {
            0% {
                background-color: black;
                box-shadow: 0 0 5px 1px rgba(255, 255, 255, 0.5);
            }
            100% {
                background-color: BLACK;
                box-shadow: 0 0 5px 4px rgba(255, 255, 255, 0.9);
            }
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color: transparent;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
            text-decoration: none;
        }
        .back-button:hover {
            color: black;
        }
        .back-button svg {
            margin-right: 10px;
        }
#submit{
    width: 100%;
    height: 40px;
    margin-top: 15px;
    animation: lightUp 1.5s infinite alternate;
}
#responseMessage {
    margin-top: 15px;
    color: green;
}
@media only screen and (max-width: 768px) {
   .container {
    width: 300px;
   }
}
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Your Password?</h2>
        <p id="sub-head">Enter your email address and we'll send you a link to reset your password.</p>
        <form id="forgotPasswordForm" method="POST" action="">
            <div class="form-group">
                <label for="email"><b>Email</b></label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="button-group">
                <a href="login.php" class="back-button">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0L1.5 8.293l3.646 3.646a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146a.5.5 0 0 0 0-.708z"/>
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"/>
                    </svg>
                    Back
                </a>
                <button type="submit" id="submit">Send OTP</button>
            </div>
        </form>
        <?php if ($msg): ?>
            <p id="responseMessage"><?php echo $msg; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
