<?php

session_start();

$correct_otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : null;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];

    if ($otp == $correct_otp) {
        header("Location: resetpass.php");
        exit();
    } else {
        $error_message = "Incorrect OTP. Please enter the correct OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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
            background-color: rgba(63, 69, 79, 0.3);
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
            margin-bottom: 10px;
            text-align: left;
       
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: white;
           
        }

        input[type="text"] {
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

        #submit {
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
        <h2>Verify Your OTP</h2>
        <p id="sub-head">Enter the OTP sent to your email address to reset your password.</p>
        <form method="POST" id="otpForm">
            <div class="form-group">
                <label for="otp" id="otp"><b>OTP</b></label>
                <input type="text" id="otp" name="otp" required>
            </div>
            <div class="button-group">
         
                <button type="submit" id="submit" href="resetpass.php">Verify OTP</button>
            </div>
        </form>
        <p id="responseMessage"></p>
    </div>
</body>
</html>
