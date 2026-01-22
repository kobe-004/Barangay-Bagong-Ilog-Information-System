<?php
session_start();

include 'connection.php'; // Ensure this file includes your database connection
require 'vendor/autoload.php'; // Include PHPMailer autoload if using Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['submitAcceptResident'])) {
        $email = $_POST['email_pen'];
        
    // Fetch the email from the database
    $sql = "SELECT * FROM pending_account WHERE Email = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, start session
        $row = $result->fetch_assoc();
        $_SESSION['pending_id'] = $row['pending_id']; 
        $_SESSION['Email'] = $email; 

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
            $mail->Subject = 'Verification Successful';
            $mail->Body    = "Congratulations! You have been successfully verified. You can now log in your account!";

            $mail->send();
            $msg = "Verification email sent successfully.";
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
<?php
if (isset($_POST['submitAcceptResident'])) {
    $pending_id = intval($_POST['pending_id']);
    $last_name = $_POST['last_name_pen'];
    $middle_name = $_POST['middle_name_pen'];
    $first_name = $_POST['first_name_pen'];
    $birthday = $_POST['birthday_pen'];
    $age = $_POST['age_pen'];
    $gender = $_POST['gender_pen']; // Ensure this is set
    $civil_status = $_POST['civil_status_pen'];
    $occupation = $_POST['occupation_pen'];
    $housenumber = $_POST['house_number_pen'];
    $street = $_POST['street_pen'];
    $educational_attainment = $_POST['education_pen'];
    $registered_voter = $_POST['registered_voter_pen'];
    $email = $_POST['email_pen'];
    $password = $_POST['password_pen'];
    $existing_image = isset($_POST['existing_image_pen']) ? $_POST['existing_image_pen'] : null;

    $img_name = isset($_FILES['image_pen']['name']) ? $_FILES['image_pen']['name'] : '';
    $img_size = isset($_FILES['image_pen']['size']) ? $_FILES['image_pen']['size'] : 0;
    $tmp_name = isset($_FILES['image_pen']['tmp_name']) ? $_FILES['image_pen']['tmp_name'] : '';
    $error = isset($_FILES['image_pen']['error']) ? $_FILES['image_pen']['error'] : 0;

    try {
        $connect->begin_transaction();

        if ($img_name) {
            if ($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png", "heic", "webp");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = 'residents/' . $new_img_name;
                    if (!move_uploaded_file($tmp_name, $img_upload_path)) {
                        throw new Exception("Error uploading new image");
                    }
                } else {
                    throw new Exception("Invalid image format");
                }
            } else {
                throw new Exception("Error uploading image");
            }
        } else {
            $new_img_name = $existing_image;
            $existing_img_path = 'pendings/' . $existing_image;
            $new_img_upload_path = 'residents/' . $existing_image;

            if (!file_exists($existing_img_path)) {
                throw new Exception("Existing image file does not exist");
            }

            if (!rename($existing_img_path, $new_img_upload_path)) {
                throw new Exception("Error moving existing image");
            }
        }

        $stmt = $connect->prepare("INSERT INTO resident (last_name, middle_name, first_name, birthday, age, gender, civil_status, occupation, house_number, street, educational_attainment, registered_voter, email, password, image, status, modified_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW())");
        $stmt->bind_param("sssssssssssssss", $last_name, $middle_name, $first_name, $birthday, $age, $gender, $civil_status, $occupation, $housenumber, $street, $educational_attainment, $registered_voter, $email, $password, $new_img_name);
        $stmt->execute();
        

        $stmt = $connect->prepare("INSERT INTO household (last_name, middle_name, first_name, street, house_number, modified_at, pending_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
        $stmt->bind_param("sssssi", $last_name, $middle_name, $first_name, $street, $housenumber, $pending_id);
        $stmt->execute();

        $resident_id = $connect->insert_id;

        $stmt = $connect->prepare("UPDATE pending_account SET status = 'accepted' WHERE pending_id = ?");
        $stmt->bind_param("i", $pending_id);
        $stmt->execute();

        $action_type = 'INSERT';
        $table_name = 'resident';
        $record_id = $resident_id;
        $admin_id = 1;
        $old_values = null;
        $new_values = json_encode($_POST);
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        $action_type = 'UPDATE';
        $table_name = 'pending_account';
        $record_id = $pending_id;

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        $action_type = 'INSERT';
        $table_name = 'household';
        $record_id = $connect->insert_id;
        $admin_id = 1;
        $old_values = null;
        $new_values = json_encode($_POST);
        $action_timestamp = date('Y-m-d H:i:s');
        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        $connect->commit();
        echo "<script>window.location.href='pendingAcc.php'</script>";
        exit();
    } catch (Exception $e) {
        $connect->rollback();
        echo "Failed to add resident or update pending status: " . $e->getMessage();
    }

    $connect->close();
}
?>
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
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
    <title>Document</title>
</head>

<section id="accept-resident">
    <div id="accept-modal-residents">
        <h1>Accept Resident Information</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="inputs-con">
                <div class="input-group">
                    <label for="last_name">Last Name:</label><br>
                    <input type="hidden" id="pending_id" name="pending_id">
                    <input type="text" id="last_name_pen" name="last_name_pen" class="inputs" value="" required><br><br>
                </div>
                <div class="input-group">
                    <label for="middle_name">Middle Name:</label><br>
                    <input type="text" id="middle_name_pen" name="middle_name_pen" class="inputs" required><br><br>
                </div>
                <div class="input-group">
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name_pen" name="first_name_pen" class="inputs" required><br><br>
                </div>
            </div>
            <div class="inputs-con">
                <div class="input-group">
                    <label for="birthday">Birthday:</label><br>
                    <input type="date" id="birthday_pen" name="birthday_pen" required><br><br>
                </div>
                <div class="input-group">                    
                    <label for="age">Age:</label><br>
                    <input type="number" id="age_pen" name="age_pen" class="inputs" required><br><br>
                </div>
                <div class="input-group">
                    <label for="gender">Gender:</label><br>
                    <select id="gender_pen" name="gender_pen" required> 
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
            </div>
            <div class="inputs-con">
                <div class="input-group">
                    <label for="civil_status">Civil Status:</label><br>
                    <select id="civil_status_pen" name="civil_status_pen" required>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                        <option value="widowed">Widowed</option>
                    </select><br><br>
                </div>
                <div class="input-group">                    
                    <label for="occupation">Occupation:</label><br>
                    <input type="text" id="occupation_pen" name="occupation_pen" class="inputs" required><br><br>
                </div>
                <div class="input-group">                    
                    <label for="house_number_pen">House Number:</label><br>
                    <input type="text" id="house_number_pen" name="house_number_pen" class="inputs" required><br><br>
                </div>
            </div>
            <div class="inputs-con">
                <div class="input-group second">
                    <label for="street_pen">Street:</label><br>
                    <select id="street_pen" name="street_pen" required>
                        <option value="" disabled selected>Select your street</option>
                                <?php
                                foreach ($streets as $street) {
                                echo "<option value=\"$street\">$street</option>";
                            }
                        ?>
                    </select><br><br>
                </div>
                <div class="input-group">
                    <label for="education">Educational Attainment:</label><br>
                    <input type="text" id="education_pen" name="education_pen" class="inputs" required><br><br>
                </div>
                <div class="input-group">                    
                    <label for="registered_voter">Registered Voter:</label><br>
                    <select name="registered_voter_pen" id="registered_voter_pen" required>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>
            <input type="hidden" id="email_pen" name="email_pen">

            <input type="hidden" id="password_pen" name="password_pen">

            <div class="image-con concon">
                <label for="image">Image</label>
                <div class="square" style="width:300px; height: 200px; background-color:gray;">
                    <img src="" alt="" id="image_display" width="300px"> <!-- corrected id -->
                </div>
                <input type="hidden" class="form-control" id="image_pen" name="image_pen" placeholder="Enter image" onchange="previewPendingImage(event)">
                <input type="hidden" id="existing_image_pen" name="existing_image_pen" value="">
            </div>
            <div class="input-cons">
                <button type="button" onclick="exitAcceptResident()" id="closeResident">Close</button>
                <button type="submit" name="submitAcceptResident" id="addRes">Accept</button>
            </div>
        </form>
    </div>
</section>
<script src="./javascript/add.js"></script>