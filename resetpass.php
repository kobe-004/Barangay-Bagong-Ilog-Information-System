<?php
session_start();
include("connection.php");
include("function.php");
if (isset($_POST['submitResetPassword'])) {
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if ($_SESSION['admin'] == "admin") {
        $password = $_POST['newPassword'];

        $sql = "UPDATE admin SET admin_password = ? WHERE admin_id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("si", $password, $_SESSION['id']);

        if ($stmt->execute()) {
            $_SESSION['password'] = $password; 
            echo "<script>window.location.href='login.php';</script>";
        } else {
            echo "Error updating password: " . $connect->error;
        }
        $stmt->close();
        $connect->close();
    }
    else {
        $password = $_POST['newPassword'];

        $sql = "UPDATE resident SET Password = ? WHERE resident_id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("si", $password, $_SESSION['id']);

        if ($stmt->execute()) {
            $_SESSION['password'] = $password; 
            echo "<script>window.location.href='login.php';</script>";
        } else {
            echo "Error updating password: " . $connect->error;
        }
        $stmt->close();
        $connect->close();
    }

    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 45px 60px 60px;
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
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 10px;
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        #class {
            margin-top: 30px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }

        input[type="password"], input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            background-color: transparent;
            border: 2px solid white;
            border-radius: 10px;
            color: white;
        }

        .button-group {
            margin: 0;
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

        #submit {
            width: 100%;
            height: 40px;
            margin-top: 2rem;
            animation: lightUp 1.5s infinite alternate;
        }

        .showPass > div {
            float: left;
        }

        .togglePassword1Label {
            margin-top: 5px;
            color: white;
        }

        #responseMessage {
            margin-top: 15px;
            color: green;
        }

        @media only screen and (max-width: 768px) {
            .container {
                width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Your Password</h2>
        <p id="sub-head">Enter your new password.</p>
        <form id="resetPasswordForm" method="post">
            <div class="form-group">
                <label for="newPassword" id="class"><b>New Password</b></label>
                <input type="password" id="newPassword" name="newPassword" required>
                <div class="showPass">
                    <div style="display: flex;">
                        <input type="checkbox" id="togglePassword">
                        <label for="togglePassword" style="margin-bottom: 2; margin-top:6px; ">Show Password</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword" id="class" ><b>Confirm Password</b></label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <div class="showPass">
                    <div style="display: flex;">
                        <input type="checkbox" id="togglePassword1">
                        <label for="togglePassword1" style="margin-bottom: 2; margin-top:6px;">Show Password</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="button-group">
                <button type="submit" id="submit" name="submitResetPassword">Reset Password</button>
            </div>
        </form>
        <p id="responseMessage"></p>
    </div>
    <script>
        const togglePassword = (toggleCheckboxId, passwordFieldId) => {
            document.getElementById(toggleCheckboxId).addEventListener('change', function() {
                const passwordField = document.getElementById(passwordFieldId);
                passwordField.type = this.checked ? 'text' : 'password';
            });
        };

        togglePassword('togglePassword', 'newPassword');
        togglePassword('togglePassword1', 'confirmPassword');
    </script>
</body>
</html>
