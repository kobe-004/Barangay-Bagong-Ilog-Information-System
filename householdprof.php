<?php
session_start();
include("connection.php");
include("function.php");

try {
    // Ensure user is logged in and retrieve user data
    $user_data = check_login($connect);
    $lname = $user_data['Last_name'];
    $mname = $user_data['Middle_name'];
    $fname = $user_data['First_name'];

    // Check if household profile has already been added
    $sql_check_profile = "SELECT * FROM household WHERE Last_name = '{$lname}' AND Middle_name = '{$mname}' AND First_name = '{$fname}'";
    $result_check_profile = $connect->query($sql_check_profile);

    if ($result_check_profile->num_rows > 0) {
        // Household profile already exists, display a message or redirect
    }

    if (isset($_POST['submit_household'])) {
        // Process form submission
        $lastName = $_POST['lastName'];
        $middleName = $_POST['middleName'];
        $firstName = $_POST['firstName'];
        $street = $_POST['street'];
        $houseNumber = $_POST['house_num'];
        $headOfFamily = $_POST['headOfFamily'];
        $headFirstName = $_POST['familyHeadFirstName'];
        $headMiddleName = $_POST['familyHeadMiddleName'];
        $headLastName = $_POST['familyHeadLastName'];
        $relationship = $_POST['relationship'];
        $houseStructure = isset($_POST['houseStructure']) ? implode(',', $_POST['houseStructure']) : "";
        $waterSupply = isset($_POST['waterSupply']) ? implode(',', $_POST['waterSupply']) : "";
        $electricity = isset($_POST['electricity']) ? implode(',', $_POST['electricity']) : "";
        $residentialStatus = isset($_POST['residentialStatus']) ? implode(',', $_POST['residentialStatus']) : "";

        // Prepare and execute the SQL statement to insert household data
        $sql_insert = "INSERT INTO household (Last_name, Middle_name, First_name, Street, House_number, Head_of_family, Head_first_name, Head_middle_name, Head_last_name, Relation_to_head, House_structure, Water_supply, Residential_status, Electricity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($sql_insert);
        if (!$stmt) {
            throw new Exception("Failed to prepare SQL statement: " . $connect->error);
        }
        
        // Bind parameters and execute the statement
        $stmt->bind_param("ssssssssssssss", $lastName, $middleName, $firstName, $street, $houseNumber, $headOfFamily, $headFirstName, $headMiddleName, $headLastName, $relationship, $houseStructure, $waterSupply, $residentialStatus, $electricity);
        $stmt->execute();

        // Check for errors
        if ($stmt->error) {
            throw new Exception("Failed to execute query: " . $stmt->error);
        }

        // Redirect after successful execution
        echo "<script>window.location.href='homepageinside.php';</script>";
        exit();
    }
} catch (Exception $e) {
    // Handle any exceptions
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Signup Form</title>
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
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body {
            scrollbar-width: none; 
        }
        body::-webkit-scrollbar {
            display: none;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px 150px;
            border: 0.1px solid #BEC6D4;
            background-color: rgba(63, 69, 79, 0.5);
            border-radius: 50px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.5);
            animation: slideIn 0.5s ease-in-out;
            width: 60%;
            max-height: 80vh;
            overflow-y: scroll;
            scrollbar-width: none;
        }
        .form-container::-webkit-scrollbar {
            display: none;
        }

        .form-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            color: white;
            animation: fadeIn 0.5s ease-in-out;
            position: sticky;
            top: 0; 
            background-color: transparent;
            padding: 10px 0; 
            width: 100%; 
            z-index: 1; 
        }
        .form-header p {
            font-size: 30px;
            font-weight: 1000;
            color: white;
            background-color: transparent;
            text-align: center;
            margin: 0 auto;
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .form-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            overflow-y: scroll;
            max-height: calc(80vh - 70px);
            scrollbar-width: none;
        }
        .form-content::-webkit-scrollbar {
            display: none;
        }

        .form-content label {
            font-size: 15px;
            color: white;
            margin-bottom: 5px;
            display: block;
        }

        .form-content input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 2px solid white;
            border-radius: 10px;
            background-color: transparent;
            color: white;
            margin-bottom: 10px;
            transition: border-color 0.3s ease;
        }

        .name-inputs {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            width: 100%;
        }

        .form-content select {
            width: 100%;
            padding: 8px;
            border: 2px solid white;
            border-radius: 10px;
            background-color: transparent;
            color: gray;
            margin-bottom: 10px;
            color: gray; 
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 10px;
            width: 100%;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
        }
        .button-container {
    width: 100%;
    text-align: center;
    margin-top: 20px; 
}

.button-container .button {
    background-color: #000000;
    padding: 8px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: white;
    width: 70%;
    transition: background-color 0.3s ease;
    margin-bottom: 50px;
    border: 0.3px solid white;
    animation: lightUp 1.5s infinite alternate;

}
 
.back-button {
            position: absolute;
            top: 5px;
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
@keyframes lightUp {
    0% {
        background-color: black;
        box-shadow: 0 0 5px 1px rgba(255, 255, 255, 0.5);
    }
    100% {
        background-color: black;
        box-shadow: 0 0 5px 4px rgba(255, 255, 255, 0.9);
    }
}

        .button-container .button:hover {
            background-color: white;
    color: white;
        }

        @keyframes slideIn {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @media only screen and (max-width: 768px) {
            .form-container {
                padding: 20px;
                width: 80%;
            }
            .form-header p {
                font-size: 20px;
            }
            .form-content input[type="text"], .form-content select {
                padding: 8px;
                font-size: 14px;
            }
            .button-container button {
                padding: 8px;
                font-size: 14px;
            }
        }

    </style>
    <script>
        function toggleHeadOfFamilyQuestions() {
            const headOfFamilySelect = document.getElementById('headOfFamily');
            const noQues = document.getElementById('noQues');
            const yesQues = document.getElementById('yesQues');

            if (headOfFamilySelect.value === 'Yes') {
                yesQues.style.display = 'block';
                noQues.style.display = 'none';
            } else if (headOfFamilySelect.value === 'No') {
                yesQues.style.display = 'none';
                noQues.style.display = 'block';
            } else {
                yesQues.style.display = 'none';
                noQues.style.display = 'none';
            }
        }
    </script>
</head>
<body>
       <a href="homepageinside.php" class="back-button">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0L1.5 8.293l3.646 3.646a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146a.5.5 0 0 0 0-.708z"/>
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"/>
            </svg>
            Back
        </a>
    <div class="form-container">
 
        <div class="form-header">
            <p>HOUSEHOLD PROFILE UPDATE</p>
        </div>
        <?php 
        $lname = $user_data['Last_name'];
        $mname = $user_data['Middle_name'];
        $fname = $user_data['First_name'];
    
        // Check if household profile has already been added
        $sql_check_profile = "SELECT * FROM household WHERE Last_name = '{$lname}' AND First_name = '{$fname}' AND Middle_name = '{$mname}' where Head_of_family = 'yes' of 'no'";
        $result_check_profile = $connect->query($sql_check_profile);
    
        if ($result_check_profile->num_rows > 0) {
            // Household profile already exists, display a message or redirect
            echo "<div class='form-content'><p>You have already added your household profile.</p></div>";
            
        }elseif($result_check_profile->num_rows == 0) {
            echo "
                <div class='form-content'>
                    <form method='post' action=''>
                        <label for='full_name'>Enter your name:</label>
                        <div class='name-inputs'>
                            <input type='hidden' name='resident_id' value='$user_data[resident_id]' readonly>
                            <input type='hidden' name='house_num' value='$user_data[house_number]' readonly>
                            <input type='hidden' name='street' value='$user_data[street];' readonly>
                            <input type='text' id='last_name' name='lastName' value='$user_data[Last_name]' required readonly>
                            <input type='text' id='first_name' name='firstName' value='$user_data[First_name]' required readonly>
                            <input type='text' id='middle_name' name='middleName' value='$user_data[Middle_name]' required readonly>
                        </div>
                        <label for='headOfFamily'>Are you the head of the family?</label>
                        <select id='headOfFamily' name='headOfFamily' onchange ='toggleHeadOfFamilyQuestions()'>
                            <option value='' disabled selected hidden>Select an option</option>
                            <option value='Yes'>Yes</option>
                            <option value='No'>No</option>
                        </select>
                        <div id='noQues' style='display: none;'>
                            <label for='familyHead'>Who is the head of your family?</label>
                            <label for='familyHeadName' id='entername'>Enter his/her name:</label>
                            <div class='name-inputs'>
                                <input type='text' id='familyHeadFirstName' name='familyHeadFirstName' placeholder='First Name'>
                                <input type='text' id='familyHeadFirstName' name='familyHeadMiddleName' placeholder='Middle Name'>
                                <input type='text' id='familyHeadLastName' name='familyHeadLastName' placeholder='Last Name'>
                            </div>
                            <label for='relationship'>What is your relation with this person?</label>
                            <input type='text' id='relationship' name='relationship' placeholder='Relationship'>
                        </div>
                        <div id='yesQues' style='display: none;'>
                            <label for='houseStructure' id='struct'>House Structure: <span id='instruct' style='color: red;'>(Choose at least one)</span></label>
                            <div class='checkbox-group'>
                                <label><input type='checkbox' id='woodStone' name='houseStructure[]' value='Wood/Stone'>Wood/Stone</label>
                                <label><input type='checkbox' id='cemented' name='houseStructure[]' value='Cemented'>Cemented</label>
                                <label><input type='checkbox' id='withCR' name='houseStructure[]' value='With CR'>With CR</label>
                            </div>
                            <label for='waterSupply' id='water'>Water supply:</label>
                            <div class='checkbox-group'>
                                <label><input type='checkbox' id='ownMeter' name='waterSupply[]' value='Own Meter'>Own Meter</label>
                                <label><input type='checkbox' id='publicWaterSupply' name='waterSupply[]' value='Public Water Supply'>Public Water Supply</label>
                            </div>
                            <label for='residentialStatus' id='status'>Residential Status:</label>
                            <div class='checkbox-group'>
                                <label><input type='checkbox' id='owned' name='residentialStatus[]' value='Owned'>Owned</label>
                                <label><input type='checkbox' id='rented' name='residentialStatus[]' value='Rented'>Rented</label>
                                <label><input type='checkbox' id='caretaker' name='residentialStatus[]' value='Caretaker'>Caretaker</label>
                            </div>
                            <label for='residentialStatus' id='status'>Electricity:</label>
                            <div class='checkbox-group'>
                                <label for=''><input type='checkbox' id='ownMeter' name='electricity[]' value='Own Meter'>Own Meter</label>
                                <label for=''><input type='checkbox' id='subMeter' name='electricity[]' value='Sub Meter'>Sub Meter</label>
                            </div>
                        </div>
                        <div class='button-container'>
                            <input class='button' type='submit' name='submit_household' value='Submit'>
                        </div>
                    </form>
                </div>

            ";
        }
        ?>
    </div>
</body>
</html>
