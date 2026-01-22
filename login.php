<?php
session_start();
include 'connection.php';
include 'function.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['user_email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Check if the email belongs to a user
        $user_query = "SELECT * FROM resident WHERE Email = '$email' LIMIT 1";
        $user_result = mysqli_query($connect, $user_query);

        if ($user_result && mysqli_num_rows($user_result) > 0) {
            $user_data = mysqli_fetch_assoc($user_result);

            if ($user_data['Password'] === $password) {
                $_SESSION['user_email'] = $user_data['Email'];
                echo "<script>window.location.href='homepageinside.php';</script>";
                die();
            } else {
                echo "Invalid email or password for user.";
            }
        } else {
            // Check if the email belongs to an admin
            $admin_query = "SELECT * FROM admin WHERE email = '$email' LIMIT 1";
            $admin_result = mysqli_query($connect, $admin_query);

            if ($admin_result && mysqli_num_rows($admin_result) > 0) {
                $admin_data = mysqli_fetch_assoc($admin_result);

                if ($admin_data['admin_password'] === $password) {
                    $_SESSION['admin_email'] = $admin_data['email'];
                    echo "<script>window.location.href='index.php';</script>";
                    die();
                } else {
                    echo "Invalid email or password for admin.";
                }
            } else {
                echo "Invalid email or password.";
            }
        }
    } else {
        echo "Please enter both email and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Bagong Ilog</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            box-sizing: border-box;
        }
        body { 
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            overflow: hidden;
            background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
        }
        .container-body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px 150px;
            border: 0.1px solid #BEC6D4;
            background-color: rgba(63, 69, 79, 0.2);/* 91% opacity */
            border-radius: 50px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.5);
            animation: slideIn 0.5s ease-in-out;
            margin-top: 40px;
           
        }
        .form-content h5 {
            font-size: 30px;
            text-align: center;
            margin-bottom: 20px;
            margin-top: 10px;
            color: white;
            animation: fadeIn 0.5s ease-in-out;
        }
        .form-content label {
            font-size: 15px;
            text-align: center;
            margin-bottom: 20px;
            color: white;
            animation: fadeIn 0.5s ease-in-out;
        }
        .form-content {
            width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #user_email, #password {
            width: 100%;
            padding: 8px;
            border: 2px solid white;
            border-radius: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            background-color: transparent;
            transition: border-color 0.3s ease;
            color: white;
        }
        .buttonLogin {
            width: 100%;
            padding: 8px;
            border: 0.5px solid white;
            border-radius: 50px;
            background-color: black;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.3s ease;
            animation: lightUp 1.5s infinite alternate;
            margin-bottom: 5px;
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
        .buttonLogin:hover {
            background-color: #333;
            transform: scale(1.05);
        }
        a {
            justify-content: center;
            align-items: center;
            display: flex;
            margin-top: 5px;
            cursor: pointer;
            white-space: nowrap;
            color: white;
            transition: color 0.3s ease;
            margin-bottom: 30px;
        }
        a:hover {
            color: #ddd;
        }
        .signup {
            color: red;
            text-decoration: underline;
            margin-left: 2px;
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
        @keyframes slideIn {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }
        .fadeOut {
            animation: fadeOut 0.5s ease-in-out;
        }
        @media only screen and (max-width: 768px) {
            .container-body {
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                padding: 20px;
            }
            .form {
                
                width: 430px;
                padding: 45px;
                margin-top: 70px;
            }
            .form-content h5 {
                font-size: 16px;
            }
            #user_email, #password {
                padding: 8px;
            }
            .buttonLogin {
                width: 100%;
            }
            a {
                font-size: 12px;
            }
        }
        @media only screen and (max-width: 480px) {
            .form {
                padding: 30px;
            }
            .form-content h5 {
                font-size: 14px;
            }
            #user_email, #password {
                padding: 8px;
            }
            .buttonLogin {
                padding: 8px;
                font-size: 14px;
            }
            a {
                font-size: 12px;
            }
        }
        .inline {
            display: flex;
            justify-content: center;
            align-items: center;
            
          
        }
        .inline label {
            margin-right: 120px;
            margin-left: 5px;
         
        }
        .inline input {
            margin-bottom: 20px;
        }
      
        
        #fp{
            margin-top: 10px;
            font-size: 15px;
        }
       .low{
        margin-top: 50px;
       }
       @media (min-width: 321px) and (max-width: 767px) {
        .form-content{
            width: 150px;
        }
        form{
            width: 150px;
        }
        .form{
            width: 300px;
        }
        .inline{
            width: 150px;
            margin-left: 5px;
        }
        .inline label {
            margin-right: 30px;
        }
        .inline label, #fp {
            font-size: 10px;
        }
       }
    </style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <a href="homepage.php" class="back-button">
        <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0L1.5 8.293l3.646 3.646a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146a.5.5 0 0 0 0-.708z"/>
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"/>
        </svg>
        Back
    </a>
    <div class="container-body">
        <div class="form" id="loginForm">
            <div class="form-content">
                <form action="login.php" method="post">
                    <h5>LOGIN</h5>
                    <div class="low">
                        <label for="user_email">Email</label>
                        <input type="text" id="user_email" name="user_email" required>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <div class="inline">
                            <input type="checkbox" id="togglePassword">
                            <label for="togglePassword" style="color: white;">Show Password</label>
                            <a href="forgotpassword.php" id="fp" style="color: white;">Forgot Password?</a>
                        </div><br>
                    </div>
                    <input type="submit" name="btn" class="buttonLogin" value="Log in"><br><br>
                    <a href="signup.php">Don't have an account?<span class="signup"> Sign Up</span></a>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('change', function () {
            const passwordField = document.getElementById('password');
            if (this.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    </script>
</body>
</html>
