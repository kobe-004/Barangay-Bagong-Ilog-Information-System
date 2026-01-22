<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
 <style>
 * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }
        /* Body styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
            background-size: cover;
            width: 100%;
            height: 100%;
        }
        /* Form container styles */
        .add-modal-residents {
            width: 100%;
            /* max-width: 1010px; */
            height: auto;
            background-color: rgba(63, 69, 79, 0.5);
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.5);
            border-radius: 50px;
            padding: 40px;
            margin: 100px auto 90px;
            border: 0.25px solid white;
            position: relative;
            overflow-y: auto;
        }
        /* Header styles */
        .add-res-header {
            text-align: center;
            margin-bottom: 1rem;
        }
        .add-res-header h1 {
            color: white;
            font-size: 25px;
        }
        /* Form grid styles */
        .pangalan {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 10px;
            color: white;
        }
        /* Input styles */
        input{
            width: 90%;
            padding: 10px;
            background-color: transparent;
            color: white;
            border: 2px solid white;
            border-radius: 10px;
            transition: border-color 0.3s ease;
        }
        select {
            width: 100%;
            padding: 10px;
            background-color: transparent;
            color: white;
            border: 2px solid white;
            border-radius: 10px;
            transition: border-color 0.3s ease;
        }
        /* Button styles */
        .buttonSignup {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 50px;
            background-color: black;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.3s ease;
            animation: lightUp 1.5s infinite alternate;
        }
        .buttonSignup:hover {
            background-color: #333;
            transform: scale(1.05);
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

        /* File input styles */
        .custom-file-input {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .custom-file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        .custom-file-label {
            background-color: black;
            color: white;
            padding: 5px;
            display: inline-block;
            cursor: pointer;
            border-radius: 5px;
        }

        #togglePassword, #togglePassword1 {
            width: 10px;
            margin-left: 150px;
        }

        .showPass1 {
           width: 200px;
            margin-left: 100px; 
        }

        .showPass2 {
           width: 100px;
            margin-left: 100px; 
        }
        .square {
            width: 250px;
            height: 120px;
            background-color: transparent;
            border: 1px solid white;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .custom-file-input {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .custom-file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        .custom-file-label {
            background-color: black;
            color: white;
            padding: 5px;
            display: inline-block;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 5px;
        }

        /* Back button styles */
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
            color: gray;
        }
        .back-button svg {
            margin-right: 10px;
        }

        #fieldacc {
            padding: 10px; 
            color: white; 
            background-color: rgba(63, 69, 79, 0.5);
        }

        @media only screen and (max-width: 980px) {
            .pangalan {
                grid-template-columns: 1fr;
            }
            .buttonSignup {
                margin-top: 20px;
            }
            .add-modal-residents {
                width: 70%;
                margin-left: 30px;
            }
            #fieldacc {
                padding: 10px; 
                margin-right: 31px;
                color: white; 
                background-color: rgba(63, 69, 79, 0.5);
            }
          
        }
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
            animation: slideInNotification 0.5s ease-in-out;
        }

        @keyframes slideInNotification {
            0% {
                transform: translateX(-50%) translateY(-100%);
            }
            100% {
                transform: translateX(-50%) translateY(0);
            }
        }
        @media (min-width: 321px) and (max-width: 767px) {
            #add-resident {
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
            background-size: cover;
            width: 100%;
            height: 100%;
        }
        .add-modal-residents{
            margin-left: 45px;
            display: flex;
            width: 290px;
            flex-direction: column;
            justify-content: center;
        }
        form {
            width: 275px;
            margin-left: -35px;
            margin-right: 0px;
        }
        .showPass1{
            width: 210px;
        }
        fieldset {
            padding: 0px;
            width: 275px;
        }
        fieldset#fieldacc{
            width: 275px;
        }
        #fieldacc .pangalan{
            width: 210px;
        }
        .pangalan div {
            width: 200px;
        }
        #fieldadd{
            width: 275px;
            padding: 0px;
        }
        #fieldid{
            width: 200px;
            padding: 0px;
        }
        #fieldid img, #id, input[type="file"]{
            width: 210px;
        }
        #fieldid .square, div#id{
            width: 150px;
        }
        fieldset#fieldperson{
            width: 275px;
            padding: 0px;
        }
        #fieldperson .pangalan{
            width: 210px;
        }
        #fieldperson div{
            width: 210px;
        }
        div.showPass1{
            width: 210px;
        }
        div.showPass2{
            width: 210px;
        }
        label#labelToggle{
            width: 210px;
        }
       }

    </style>
</head>
<?php
include 'connection.php';

$sql = "SELECT street_name FROM bagong_ilog_streets ORDER BY street_name";
$result = $connect->query($sql);

$streets = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $streets[] = $row['street_name'];
    }
} else {
    echo "0 results";
}
?>
<?php 

$query = "SELECT gender_id, gender_name FROM gender";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connect));
}
$error_message = "";
if (isset($_POST['submitPendingRecord'])){
    $lastName = $_POST['last_name_pending'];
    $middleName = $_POST['middle_name_pending'];
    $firstName = $_POST['first_name_pending'];
    $birthday = $_POST['birthday_pending'];
    $age = $_POST['age_pending'];
    $gender = $_POST['gender_pending'];
    $civilStatus = $_POST['civil_status_pending'];
    $occupation = $_POST['occupation_pending'];
    $houseNumber = $_POST['house_number_pending'];
    $street = $_POST['street_pending'];
    $educationalAttainment = $_POST['education_pending'];
    $voter = $_POST['registered_voter_pending'];
    $email = $_POST['email_pending'];
    $password = $_POST['password_pending'];
    $confiPassword = $_POST['confipass'];
    $img_name = $_FILES['image_pending']['name'];
    $img_size = $_FILES['image_pending']['size'];
    $tmp_name = $_FILES['image_pending']['tmp_name'];
    $error = $_FILES['image_pending']['error'];
    
            $query = "SELECT Email FROM pending_account WHERE Email = '$email'";
            $result = $connect->query($query);
            
            if ($result && $result->num_rows > 0) {
                $error_message = "Email already signed up!";
                echo "<script>window.location.href='signupuser.php?form_submitted=true';</script>";
            } else {
                if ($error === 0) {
            
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
            
                    $allowed_exs = array("jpg", "jpeg", "png", "HEIC", "webp"); 
            
                        if (in_array($img_ex_lc, $allowed_exs)) {
                            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                            $img_upload_path = 'pendings/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
            
                    if($lastName == "" || empty($lastName)) {
                    echo "<script>window.location.href='signupuser.php?message= you need to fill up first'</script>";
                    }else{
                        if($password==$confiPassword){
                            $sqlInsert = "INSERT INTO `pending_account`(pending_id, `Last_name`, `Middle_name`, `First_name`, `Birthday`, `Age`, `Gender`, `Civil_Status`, `Occupation`, `house_number`, `street`, `Educational_Attainment`, `Registered_Voter`, `image`, `Email`, `Password`) VALUES (NULL,'$lastName','$middleName','$firstName','$birthday','$age','$gender','$civilStatus','$occupation', '$houseNumber', '$street','$educationalAttainment','$voter','$new_img_name','$email','$password')";
                            $result = mysqli_query($connect, $sqlInsert);
                            if(!$result){ 
                                die("Query Failed");
                            }
                            else{
                                echo "<script>window.location.href='homepage.php?form_submitted=true';</script>";
                            }
                            echo'Successfully signed up!';
                        }else{
                            $error_message = "Password does not match!";
                        }
            
                    }
                }   
                }
            }
}

?>
<body>
<section id="add-resident">
        <a href="homepage.php" class="back-button">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0L1.5 8.293l3.646 3.646a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146a.5.5 0 0 0 0-.708z"/>
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"/>
            </svg>
            Back
        </a>
        <div class="add-modal-residents">
            <div class="add-res-header">
                <h1>CREATE ACCOUNT</h1>
            </div>
            <div class="section-hint1" id="account-info-hint" ></div>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="pangalan">
                </div>
                <fieldset id="fieldperson" style="padding: 30px; color: white; background-color: rgba(63, 69, 79, 0.5); margin-bottom:0;">
                <legend>Personal Information</legend>
                <div class="pangalan">
                    <div class="name" style="margin-top: -15px; margin-bottom: 20px;">
                        <label for="last_name" id="name2">Name</label>
                        <input type="text" id="last_name_pending" name="last_name_pending" class="inputs" value="" required ><br>
                        <label for="last_name" ">Last Name</label><br>
                    </div>
                    <div class="name1">
                         <input type="text" id="middle_name_pending" name="middle_name_pending" class="inputs"><br>
                        <label for="middle_name">Middle Name</label><br>
                    </div>
                    <div class="name1" style="margin-top:20px;">
                        <input type="text" id="first_name_pending" name="first_name_pending" class="inputs" required><br>
                        <label for="first_name">First Name</label><br>
                    </div>
                    <div>
                        <label for="birthday_pending">Birthday</label><br>
                        <input type="date" id="birthday_pending" name="birthday_pending" required><br><br>
                    </div>
                    <div>
                        <label for="age_pending">Age</label><br>
                        <input type="number" id="age_pending" name="age_pending" class="inputs" required readonly><br><br>
                    </div>
                     <div>
                        <label for="occupation">Occupation</label><br>
                        <input type="text" id="occupation_pending" name="occupation_pending" class="inputs" required><br><br>
                    </div>
                    <div class="educ">
                        <label for="education">Educational Attainment</label><br>
                        <input type="text" id="education_pending" name="education_pending" class="inputs" required><br><br>
                    </div>

                    <div class="cntnr">
                        <label for="civil_status">Civil Status</label><br>
                        <select id="civil_status_pending" name="civil_status_pending">
                            <option value="single" name="civil_status_pending">Single</option>
                            <option value="married" name="civil_status_pending">Married</option>
                            <option value="widowed" name="civil_status_pending">Widowed</option>
                        </select><br><br>
                    </div>
                    <div class="cntnr1" ">
                        <label for="registered_voter">Registered Voter</label><br>
                        <select name="registered_voter_pending" id="registered_voter_pending">
                            <option value="yes" name="registered_voter_pending">Yes</option>
                            <option value="no" name="registered_voter_pending">No</option>
                        </select>
                    </div>
                    <div>
                        <label for="gender">Gender</label><br>
                        <select id="gender_pending" name="gender_pending"> 
                            <?php
                            $sql = "SELECT * FROM `gender`";
                            $result = mysqli_query($connect, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['gender_name'] . "'>" . $row['gender_name'] . "</option>";
                            }
                            ?>
                        </select>
                        <br><br>
                    </div>
                    </fieldset>
                    <fieldset id="fieldadd" style="padding: 30px; color: white; background-color: rgba(63, 69, 79, 0.5);">
                    <legend>Address Information</legend>
                    <div class="pangalan"></div>
                    <div>
                        <label for="house_number">House Number</label><br>
                        <input type="text" id="house_number_pending" name="house_number_pending" required style="width:95%;"><br><br>
                    </div>
                    <div>
                    <label for="street">Street:</label><br>
                    <select id="street_pending" name="street_pending" required>
                        <option value="" disabled selected>Select your street</option>
                        <?php
                        foreach ($streets as $street) {
                            echo "<option value=\"$street\">$street</option>";
                        }
                        ?>
                    </select>
                </div>
                </fieldset>
                    
                <fieldset id="fieldacc">
                <legend>Account Information</legend>
                <div class="pangalan">
                    <div>
                        <label for="email">Email</label><br>
                        <input type="text" id="email_pending" name="email_pending"><br><br>
                    </div>
                    <div>
                        <label for="password">Password</label><br>
                        <input type="password" id="password_pending" name="password_pending"><br>
                        <div>
                            <div class="showPass1">
                                <input type="checkbox" id="togglePassword" style="margin-left:-100px;">
                                <label id="labelToggle" for="togglePassword" style="color: white;">Show Password</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="confipass">Confirm Password</label><br>
                        <input type="password" id="confipass" name="confipass"><br>
                        <div>
                            <div class="showPass2">
                                <input type="checkbox" id="togglePassword1" style="margin-left:-100px">
                                <label id="labelToggle" for="togglePassword1" style="color: white;">Show Password</label>
                            </div>
                        </div>
                    </div>
                    </fieldset>
            <fieldset class="fieldid" style="padding: 30px; color: white; background-color: rgba(63, 69, 79, 0.5);">
                <legend>Identification Card</legend>
                    
                    <div class="id">
                        <label for="image">Submit your valid ID</label>
                        <div class="square">
                            <img src="" alt="" id="imagePreview" width="250px" height="120px">
                        </div>
                        <div class="custom-file-input">
                            <input type="file" id="image_pending" name="image_pending" onchange="previewResImage(event)">
                            <label class="custom-file-label" for="image">Choose File</label>
                        </div>
                    </div>
                    </fieldset>
                    <div class="bttn">
                        <input type="submit" name="submitPendingRecord" class="buttonSignup" value="Create Account" onclick="fadeOutForm()">
                        <a href="login.php">Don't have an account?<span class="signup"> Log In</span></a>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <div class="notification" id="notification">
    Email has already been submitted! Wait for email confirmation to be verified.
</div>

    <script>
        function previewResImage(event) {
            const output = document.getElementById('imagePreview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src); // free memory
            }
        }

        function toggleOtherOption() {
            const otherRadio = document.getElementById('other');
            const otherGenderSelect = document.getElementById('other_gender');
            otherGenderSelect.style.display = otherRadio.checked ? 'block' : 'none';
        }

        document.getElementById('togglePassword').addEventListener('change', function() {
            const password = document.getElementById('password_pending');
            password.type = this.checked ? 'text' : 'password';
        });

        document.getElementById('togglePassword1').addEventListener('change', function() {
            const confirmPassword = document.getElementById('confipass');
            confirmPassword.type = this.checked ? 'text' : 'password';
        });

        function fadeOutForm() {
            const form = document.querySelector('form');
            form.style.transition = 'opacity 1s';
            form.style.opacity = 0;
        }
        document.getElementById('birthday_pending').addEventListener('change', function() {
            const birthday = this.value;
            if (!birthday) {
                return;
            }

            const age = calculateAge(new Date(birthday));
            document.getElementById('age_pending').value = age;
            });

            function calculateAge(birthday) {
                const today = new Date();
                let age = today.getFullYear() - birthday.getFullYear();
                const monthDifference = today.getMonth() - birthday.getMonth();

                // Adjust age if birthday hasn't occurred yet this year
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthday.getDate())) {
                    age--;
                }

                return age;
            }
            function showNotification() {
                var notification = document.getElementById('notification');
                notification.style.display = 'block';

                setTimeout(function() {
                    notification.style.display = 'none';
                }, 5000); // 5000 milliseconds = 5 seconds (adjust as needed)
            }

                window.onload = function() {
                    if (getUrlParameter('form_submitted') === 'true') {
                        showNotification();
                    }
                }
                function getUrlParameter(name) {
                name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            }

    </script>
    <?php
    $connect->close();
    ?>
</body>
</html>