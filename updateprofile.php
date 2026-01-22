<?php
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($connect);
$imagePath = 'residents/' . $user_data['image'];
$gender = $user_data['Gender'];
$residentId = $user_data['resident_id'];

if (isset($_POST['submit_user'])) {
    $residentId = $_POST['resident_id'];
    $lastName = $_POST['last_name_user'];
    $middleName = $_POST['middle_name_user'];
    $firstName = $_POST['first_name_user'];
    $birthday = $_POST['birthday_user'];
    $age = $_POST['age_user'];
    $gender = $_POST['gender_user'];
    $civilStatus = $_POST['civil_status_user'];
    $occupation = $_POST['occupation_user'];
    $houseNumber = $_POST['house_number_user'];
    $street = $_POST['street_user'];
    $educationalAttainment = $_POST['education_user'];
    $voter = $_POST['registered_voter_user'];
    $img_name = $_FILES['user_imageUPD']['name'];
    $tmp_name = $_FILES['user_imageUPD']['tmp_name'];
    $error = $_FILES['user_imageUPD']['error'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        if ($img_name != '') {
            if ($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png", "heic");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = './residents/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $sqlUpdate = "UPDATE `resident` SET 
                        `Last_name`= ?,
                        `Middle_name`= ?,
                        `First_name`= ?,
                        `Birthday`= ?,
                        `Age`= ?,
                        `Gender`= ?,
                        `Civil_Status`= ?,
                        `Occupation`= ?,
                        `house_number`= ?,
                        `street`= ?,
                        `Educational_Attainment`= ?,
                        `Registered_Voter`= ?,
                        `image` = ? 
                        WHERE `resident_id`= ?";
                    $stmt = $connect->prepare($sqlUpdate);
                    $stmt->bind_param("ssssissssssssi", $lastName, $middleName, $firstName, $birthday, $age, $gender, $civilStatus, $occupation, $houseNumber, $street, $educationalAttainment, $voter, $new_img_name, $residentId);
                } else {
                    throw new Exception("Invalid image format");
                }
            } else {
                throw new Exception("Error uploading image");
            }
        } else {
            $sqlUpdate = "UPDATE `resident` SET 
                `Last_name`= ?,
                `Middle_name`= ?,
                `First_name`= ?,
                `Birthday`= ?,
                `Age`= ?,
                `Gender`= ?,
                `Civil_Status`= ?,
                `Occupation`= ?,
                `house_number`= ?,
                `street`= ?,
                `Educational_Attainment`= ?,
                `Registered_Voter`= ? 
                WHERE `resident_id`= ?";
            $stmt = $connect->prepare($sqlUpdate);
            $stmt->bind_param("ssssisssssssi", $lastName, $middleName, $firstName, $birthday, $age, $gender, $civilStatus, $occupation, $houseNumber, $street, $educationalAttainment, $voter, $residentId);
        }

        if ($stmt->execute()) {
            // Commit transaction
            $connect->commit();
            echo "<script>window.location.href='homepageinside.php';</script>";
            exit();
        } else {
            throw new Exception("Failed to execute query: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php
include 'connection.php';

$sql = "SELECT street_name FROM bagong_ilog_streets ORDER BY street_name";
$result = $connect->query($sql);

$streets = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $streets[] = $row['street_name'];
    }
} else {
    echo "0 results";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="./css/updateprofile.css">
</head>
<body>
    <div class="container">
        <a href="homepageinside.php" class="back-button">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0L1.5 8.293l3.646 3.646a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146a.5.5 0 0 0 0-.708z"/>
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"/>
            </svg>
            Back
        </a>
        <div class="profile">
            <h1>User Profile</h1>
            <hr>
            <form action="updateprofile.php" method="POST" enctype="multipart/form-data">
                <div class="detail1">
                    <span class="label">Barangay ID:</span>
                    <div class="value1">
                        <img src="<?php echo $imagePath; ?>" id="user_imageUPD" name="user_imageUPD" alt="Barangay ID">
                        <input type="file" name="user_imageUPD" onchange="previewUserUpdateImage(event)">
                    </div>
                </div>
                <hr>
                <div class="details">
                    <div class="detail">
                        <input type="hidden" name="resident_id" value="<?php echo $user_data['resident_id']; ?>" readonly>
                        <span class="label">Last Name:</span>
                        <div class="value"><input type="text" name="last_name_user" value="<?php echo $user_data['Last_name']; ?>"></div>
                    </div>
                    <div class="detail">
                        <span class="label">Middle Name:</span>
                        <div class="value"><input type="text" name="middle_name_user" value="<?php echo $user_data['Middle_name']; ?>"></div>
                    </div>
                    <div class="detail">
                        <span class="label">First Name:</span>
                        <div class="value"><input type="text" name="first_name_user" value="<?php echo $user_data['First_name']; ?>"></div>
                    </div>
                    <div class="detail">
                        <span class="label">Age:</span>
                        <div class="value"><input type="number" name="age_user" value="<?php echo $user_data['Age']; ?>"></div>
                    </div>
                    <div class="detail">
                        <span class="label">Occupation:</span>
                        <div class="value"><input type="text" name="occupation_user" value="<?php echo $user_data['Occupation']; ?>"></div>
                    </div>
                    <div class="detail">
                        <span class="label">Birthday:</span>
                        <div class="value"><input type="date" name="birthday_user" value="<?php echo $user_data['Birthday']; ?>"></div>
                    </div>
                    <div class="detail">
                        <span class="label">Gender:</span>
                        <div class="value">
                            <select name="gender_user">
                                <?php
                                $sql = "SELECT * FROM `gender`";
                                $result = mysqli_query($connect, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = ($row['gender_name'] == $gender) ? 'selected' : '';
                                    echo "<option value='" . $row['gender_name'] . "' $selected>" . $row['gender_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="detail">
                        <span class="label">Civil Status:</span>
                        <div class="value">
                            <select name="civil_status_user">
                                <option value="Single" <?php echo ($user_data['Civil_Status'] == 'Single') ? 'selected' : ''; ?>>Single</option>
                                <option value="Married" <?php echo ($user_data['Civil_Status'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                                <option value="Divorced" <?php echo ($user_data['Civil_Status'] == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
                                <option value="Widowed" <?php echo ($user_data['Civil_Status'] == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="detail">
                        <span class="label">Registered Voter:</span>
                        <div class="value">
                            <select name="registered_voter_user">
                                <option value="Yes" <?php echo ($user_data['Registered_Voter'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?php echo ($user_data['Registered_Voter'] == 'No') ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="detail">
                        <span class="label">Address:</span>
                        <div class="value address-con">
                            <input type="text" id="house-num" name="house_number_user" value="<?php echo $user_data['house_number']; ?>">
                            <select id="street" name="street_user" required>
                                <?php
                                foreach ($streets as $street) {
                                    $selected = ($street == $user_data['street']) ? 'selected' : '';
                                    echo "<option value=\"$street\" $selected>$street</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="detail">
                        <span class="label">Educational Attainment:</span>
                        <div class="value"><input type="text" name="education_user" value="<?php echo $user_data['Educational_Attainment']; ?>"></div>
                    </div>
                </div>
                <input type="submit" name="submit_user" class="update-button" value="Update Profile">
            </form>
        </div>
    </div>
</body>
<script>
    function previewUserUpdateImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('user_imageUPD');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
</html>
