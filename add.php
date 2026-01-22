<?php include'connection.php';?>
<?php 
if (isset($_POST['submitResident'])) {
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $first_name = $_POST['first_name'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $civil_status = $_POST['civil_status'];
    $occupation = $_POST['occupation'];
    $housenumber = $_POST['house_number'];
    $street = $_POST['street'];
    $educational_attainment = $_POST['education'];
    $registered_voter = $_POST['registered_voter'];
    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];
    try {
        // Start transaction
        $connect->begin_transaction();
        // Upload image
        if ($error === 0) {
            $img_ex = pathinfo($image_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png", "heic", "webp");
            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = 'residents/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
            }
        } else {
            throw new Exception("Image upload failed");
        }
        // Insert into resident table
        $stmt = $connect->prepare("INSERT INTO resident (last_name, middle_name, first_name, birthday, age, gender, civil_status, occupation, house_number, street, educational_attainment, registered_voter, image, status, modified_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW())");
        $stmt->bind_param("sssssssssssss", $last_name, $middle_name, $first_name, $birthday, $age, $gender, $civil_status, $occupation, $housenumber, $street, $educational_attainment, $registered_voter, $new_img_name);
        $stmt->execute();
        // Get the last inserted resident_id
        $resident_id = $connect->insert_id;
        // Insert into household table
        $stmt = $connect->prepare("INSERT INTO household (last_name, middle_name, first_name, street, house_number, modified_at, resident_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
        $stmt->bind_param("sssssi", $last_name, $middle_name, $first_name, $street, $housenumber, $resident_id);
        $stmt->execute();
        $action_type = 'INSERT';
        $table_name = 'resident'; // Example table name
        $record_id = $connect->insert_id; // Assuming $conn is your database connection and insert_id gives the last inserted ID
        $admin_id = 1; // Assuming 1 is the ID of the admin performing the action
        $old_values = null; // No old values for insertion
        $new_values = json_encode($_POST); // Capture new values from form data if needed
        $action_timestamp = date('Y-m-d H:i:s');
        // Prepare and execute SQL statement to insert audit trail entry
        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();
        $action_type = 'INSERT';
        $table_name = 'household'; // Example table name
        $record_id = $connect->insert_id; // Assuming $conn is your database connection and insert_id gives the last inserted ID
        $admin_id = 1; // Assuming 1 is the ID of the admin performing the action
        $old_values = null; // No old values for insertion
        $new_values = json_encode($_POST); // Capture new values from form data if needed
        $action_timestamp = date('Y-m-d H:i:s');
        // Prepare and execute SQL statement to insert audit trail entry
        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();
        // Commit transaction
        $connect->commit();
        echo "<script>window.location.href='residents.php';</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $connect->rollback();
        echo "Failed to sign up resident: " . $e->getMessage();
    }
    // Close connection
    $connect->close();
}
?>
<?php
/* insert function official */
if(isset($_POST['submitOfficial'])){
    $last_name_official = $_POST['official_last_name'];
    $middle_name_official = $_POST['official_middle_name'];
    $first_name_official = $_POST['official_first_name'];
    $age_official = $_POST['official_age'];
    $position = $_POST['position'];
    $term_start = $_POST['term_start'];
    $term_end = $_POST['term_end'];
    $image_name = $_FILES['official_image']['name'];
    $image_size = $_FILES['official_image']['size'];
    $tmp_name = $_FILES['official_image']['tmp_name'];
    $error = $_FILES['official_image']['error'];
    try {
        // Start transaction
        $connect->begin_transaction();
            // Upload image
        if ($error === 0) {
            $img_ex = pathinfo($image_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png", "heic", "webp"); 
                if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'officials/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
            } else {
                throw new Exception("Invalid image format");
            }
        } else {
            throw new Exception("Image upload failed");
        }
            // Insert into barangay_official table
        $stmt = $connect->prepare("INSERT INTO barangay_official (first_name, middle_name, last_name, age, position, term_start, term_end, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissss", $first_name_official, $middle_name_official, $last_name_official, $age_official, $position, $term_start, $term_end, $new_img_name);
        $stmt->execute();
        $action_type = 'INSERT';
        $table_name = 'officials'; // Example table name
        $record_id = $connect->insert_id; // Assuming $conn is your database connection and insert_id gives the last inserted ID
        $admin_id = 1; // Assuming 1 is the ID of the admin performing the action
        $old_values = null; // No old values for insertion
        $new_values = json_encode($_POST); // Capture new values from form data if needed
        $action_timestamp = date('Y-m-d H:i:s');
            // Prepare and execute SQL statement to insert audit trail entry
        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();
        // Commit transaction
        $connect->commit();
        echo "<script>window.location.href='officials.php';</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $connect->rollback();
            echo "Failed to register official: " . $e->getMessage();
    }
        // Close connection
    $connect->close();
    }
    ?>
<?php
/* insert function hotline */
if (isset($_POST['submitHotline'])){
    $department_name = $_POST['department_name'];
    $department_number = $_POST['department_number'];
        try {
        // Start transaction
        $connect->begin_transaction();
            // Insert into hotline_numbers table
        $stmt = $connect->prepare("INSERT INTO hotline_numbers (Department_Name, Department_Number) VALUES (?, ?)");
        $stmt->bind_param("ss", $department_name, $department_number);
        $stmt->execute();
        $action_type = 'INSERT';
        $table_name = 'hotline_numbers'; // Example table name
        $record_id = $connect->insert_id; // Assuming $conn is your database connection and insert_id gives the last inserted ID
        $admin_id = 1; // Assuming 1 is the ID of the admin performing the action
        $old_values = null; // No old values for insertion
        $new_values = json_encode($_POST); // Capture new values from form data if needed
        $action_timestamp = date('Y-m-d H:i:s');
            // Prepare and execute SQL statement to insert audit trail entry
        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();
            // Commit transaction
        $connect->commit();
        echo "<script>window.location.href='hotline.php'</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $connect->rollback();
            echo "Failed to add hotline number: " . $e->getMessage();
    }
        // Close connection
    $connect->close();
}
?>
<?php
/* insert function event */
if(isset($_POST['submitEvent'])){
    $event_name = $_POST['event_name'];
    $type = "event";
    $type_of_event = $_POST['type_of_event'];
    $event_date = $_POST['event_date'];
    $image_name = $_FILES['event_image']['name'];
    $image_size = $_FILES['event_image']['size'];
    $tmp_name = $_FILES['event_image']['tmp_name'];
    $error = $_FILES['event_image']['error'];
    try {
        // Start transaction
        $connect->begin_transaction();
            // Upload image
        if ($error === 0) {
            $img_ex = pathinfo($image_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png", "heic", "webp"); 
                if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'events/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
            } else {
                throw new Exception("Invalid image format");
            }
        } else {
            throw new Exception("Image upload failed");
        }
            // Insert into events table
        $stmt = $connect->prepare("INSERT INTO events (Event_Name, type, Type_of_Event, Date, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $event_name,  $type, $type_of_event, $event_date, $new_img_name);
        $stmt->execute();
        $action_type = 'INSERT';
        $table_name = 'events'; // Example table name
        $record_id = $connect->insert_id; // Assuming $conn is your database connection and insert_id gives the last inserted ID
        $admin_id = 1; // Assuming 1 is the ID of the admin performing the action
        $old_values = null; // No old values for insertion
        $new_values = json_encode($_POST); // Capture new values from form data if needed
        $action_timestamp = date('Y-m-d H:i:s');
            // Prepare and execute SQL statement to insert audit trail entry
        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();
            // Commit transaction
        $connect->commit();
        echo "<script>window.location.href='events.php'</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $connect->rollback();
            echo "Failed to add event: " . $e->getMessage();
    }
        // Close connection
    $connect->close();
    }
    ?>
    <?php
/* insert function event */
if(isset($_POST['submitAnnouncement'])){
    $announceTitle = $_POST['announcement_name'];
    $announceDate = $_POST['annnouncement_date'];
    $announceDescription = $_POST['description'];
    $image_name = $_FILES['announcement_image']['name'];
    $image_size = $_FILES['announcement_image']['size'];
    $tmp_name = $_FILES['announcement_image']['tmp_name'];
    $error = $_FILES['announcement_image']['error'];
    try {
        // Start transaction
        $connect->begin_transaction();
            // Upload image
        if ($error === 0) {
            $img_ex = pathinfo($image_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png", "heic", "webp"); 
                if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = 'announcement/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
            } else {
                throw new Exception("Invalid image format");
            }
        } else {
            throw new Exception("Image upload failed");
        }
            // Insert into events table
        $stmt = $connect->prepare("INSERT INTO `announcement`(`announcement_title`, `announcement_description`, `date`, `image_announcement`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $announceTitle,  $announceDescription, $announceDate, $new_img_name);
        $stmt->execute();

        $action_type = 'INSERT';
        $table_name = 'announcements'; // Example table name
        $record_id = $connect->insert_id; // Assuming $conn is your database connection and insert_id gives the last inserted ID
        $admin_id = 1; // Assuming 1 is the ID of the admin performing the action
        $old_values = null; // No old values for insertion
        $new_values = json_encode($_POST); // Capture new values from form data if needed
        $action_timestamp = date('Y-m-d H:i:s');
            // Prepare and execute SQL statement to insert audit trail entry
        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();
            // Commit transaction
        $connect->commit();
        echo "<script>window.location.href='announce.php'</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $connect->rollback();
            echo "Failed to add announcement: " . $e->getMessage();
    }
        // Close connection
    $connect->close();
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
        

        // $stmt = $connect->prepare("INSERT INTO household (last_name, middle_name, first_name, street, house_number, modified_at, pending_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
        // $stmt->bind_param("sssssi", $last_name, $middle_name, $first_name, $street, $housenumber, $pending_id);
        // $stmt->execute();

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

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
    <title>Document</title>
</head>
<body>
    <section id="add-resident">
        <div class="add-modal-residents">
            <div class="add-res-header">
                <h1>Add Resident Information</h1>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="inputs-con">
                    <div class="input-group">
                        <label for="last_name" id="last_name_label" class="labels">Last Name:</label><br>
                        <input type="text" id="last_name" name="last_name" class="inputs" value="" required><br><br>
                    </div>
                    <div class="input-group">
                        <label for="middle_name" class="labels">Middle Name:</label><br>
                        <input type="text" id="middle_name" name="middle_name" class="inputs"><br><br>
                        </div>
                        <div class="input-group">                    
                            <label for="first_name" class="labels">First Name:</label><br>
                            <input type="text" id="first_name" name="first_name" class="inputs" required><br><br>
                        </div>
                </div>
                    <div class="inputs-con">
                        <div class="input-group">
                        <label for="birthday" class="labels">Birthday:</label><br>
                        <input type="date" id="birthday" name="birthday" required><br><br>
                        </div>
                        <div class="input-group">
                        <label for="age" class="labels">Age:</label><br>
                        <input type="number" id="age" name="age" class="inputs" required readonly><br><br>
                        </div>
                        <div class="input-group">
                        
                <label for="gender" class="labels">Gender:</label><br>
                <select id="gender" name="gender"> 
                            <?php
                            $sql = "SELECT * FROM `gender`";
                            $result = mysqli_query($connect, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['gender_name'] . "' class='options' >" . $row['gender_name'] . "</option>";
                            }
                            ?>
                        </select><br><br>
                        </div>
                    </div>
                    <label for="civil_status" class="labels" >Civil Status:</label><br>
                <select id="civil_status" name="civil_status">
                    <option value="single" name="civil_status">Single</option>
                    <option value="married" name="civil_status">Married</option>
                    <option value="divorced" name="civil_status">Divorced</option>
                    <option value="widowed" name="civil_status">Widowed</option>
                </select><br><br>
                    <div class="inputs-con">
                        <div class="input-group">
                        <label for="occupation" class="labels">Occupation:</label><br>
                        <input type="text" id="occupation" name="occupation" class="inputs" required><br><br>
                        </div>
                        <div class="input-group">
                        <label for="house_number" class="labels">House Number:</label><br>
                        <input type="text" id="house_number" name="house_number" class="inputs" required><br><br>
                        </div>
                        <div class="input-group">
                        <label for="street" class="labels">Street:</label><br>
                <select id="street" name="street"  class="inputs" required>
                        <option value="" disabled selected>Select your street</option>
                        <?php
                        foreach ($streets as $street) {
                            echo "<option value=\"$street\" id=\"streetUPD\">$street</option>";
                        }
                        ?>
                    </select><br><br>
                        </div>
                    </div>
                    <div class="input-cons">
                        <div class="input-group">
                        <label for="education" class="labels">Educational Attainment:</label><br>
                        <input type="text" id="education" name="education" class="inputs" required><br><br>
                        </div>
                        <div class="input-group">
                        <label for="registered_voter" class="labels">Registered Voter:</label><br>
                <select name="registered_voter" id="registered_voter">
                    <option value="yes" name="registered_voter">Yes</option>
                    <option value="no" name="registered_voter">No</option>
                </select>  
                        </div>
                    </div>
                <div class="inputs-con">
                <div class="form-group">
                    <label for="age" class="labels">Enter your image</label>
                    <div class="square" style="width:300px; height: 200px; background-color:gray;">
                        <img src="" alt="" id="image" width="300px"> 
                    </div>
                    <input type="file" class="form-control" id="image" name="image" placeholder="Enter image" onchange="previewResImage(event)">
                    <div class="button-con">
                    <button type="button" onclick="exit()" id="closeResident">Close</button>
                    <button type="submit" name="submitResident" id="addRes">Save changes</button>
                    </div>
                </div>
                </div>


            </form>
        </div>
    </section>

    <section id="add-official">
        <div class="add-modal-official">
            <form action="" method="post" class="offi-form" enctype="multipart/form-data">
            <h1>Add Barangay Official Information</h1>
            <div class="name-con">
                <div class="name-official">
                    <label for="" class="labels">Last Name</label><br>
                    <input type="text" name="official_last_name" id="official_last_name"><br><br>
                </div>
                <div class="name-official">
                    <label for="" class="labels">Middle Name</label><br>
                    <input type="text" name="official_middle_name" id="official_middle_name"><br><br>
                </div>
                <div class="name-official">
                    <label for="" class="labels">First Name</label><br>
                    <input type="text" name="official_first_name" id="official_first_name"><br><br>
                </div>
                <div class="name-official">
                    <label for=" " class="labels">Age</label><br>
                    <input type="number" name="official_age" id="official_age"><br><br>
                </div>
            </div>
            <div class="name-con">
                <div class="name-official">
                    <label for="" class="labels">Position</label><br>
                    <select name="position" id="position"><br><br>
                        <option value="Punong Barangay" name="position">Punong Barangay</option>
                        <option value="Kagawad" name="position">Kagawad</option>
                    </select><br><br>
                </div>
                <div class="name-official">
                    <label for="" class="labels">Term Start</label><br>
                    <input type="date" name="term_start" id="term_start"><br><br>
                </div>
                <div class="name-official">
                    <label for="" class="labels">Term End</label><br>
                    <input type="date" name="term_end" id="term_end"><br><br>
                </div>
            </div>
            <div class="image-con">
                <div class="">
                    <label for="age" class="labels">Enter your image</label>
                        <div class="square" style="width:300px; height: 200px; background-color:gray;">
                            <img src="" alt="" id="official_image" width="300px"> 
                        </div>
                        <input type="file" class="form-control" id="official_image" name="official_image" placeholder="Enter image" onchange="previewOfficialImage(event)">
                </div>
            </div>
            <br>
            <div class="image-con-new">
                        <button type="button" onclick="exitOfficial()" id="closeResident">Close</button>
                        <button type="submit" name="submitOfficial" id="addOfficial">Save changes</button>
                </form>
            </div>

        </div>
    </section>

    <section id="add-hotline">
        <div class="add-hotline-modal">
        <h1>Add Hotline Number</h1>
            <form action="" method="post">
                <label for="" class="labels">Department Name</label><br>
                <input type="text" name="department_name"><br><br>
                <label for="" class="labels">Department Number</label><br>
                <input type="text" name="department_number"><br><br>
                <button onclick="closeAddHotline()" id="closeHotlineAdd">Close</button>
                <input type="submit" name="submitHotline" value="Add Hotline">
            </form>
        </div>
    </section>

    <section id="add-event">
        <div class="add-event-modal">
            <form action="" method="post" class="offi-form" enctype="multipart/form-data">
            <h1>Add Event Information</h1>
                <label for="" class="labels">Event Name</label><br>
                <input type="text" name="event_name"><br><br>
                <label for="" class="labels">Type of Event</label><br>
                <input type="text" name="type_of_event"><br><br>
                <label for="" class="labels">Date</label><br>
                <input type="date" name="event_date"><br><br>
                <div class="form-group">
                    <label for="" class="labels">Enter event image</label>
                    <div class="square" style="width:300px; height: 200px; background-color:gray;">
                        <img src="" alt="" id="event_image" width="300px"> 
                    </div>
                    <input type="file" class="form-control" id="event_image" name="event_image" placeholder="Enter image" onchange="previewEventImage(event)">
                  </div>
                <button onclick="closeAddEvent()" id="closeEventAdd">Close</button>
                <input type="submit" name="submitEvent" value="Add Event">
            </form>
        </div>
    </section>

    <section id="add-announcement">
        <div class="add-announcement-modal">
        <h1>Add Announcement Information</h1>
            <form action="" method="post" enctype="multipart/form-data">
            <label for="" class="labels">Announcement Title</label><br>
                <input type="text" name="announcement_name"><br><br>
                <label for="" class="labels">Description</label><br>
                <input type="text" name="description"><br><br>
                <label for="" class="labels">Date</label><br>
                <input type="date" name="annnouncement_date"><br><br>
                <div class="form-group">
                    <label for="" class="labels">Enter event image</label>
                    <div class="square" style="width:300px; height: 200px; background-color:gray;">
                        <img src="" alt="" id="announcement_image" width="300px"> 
                    </div><br>
                    <input type="file" class="form-control" id="announcement_image" name="announcement_image" placeholder="Enter image" onchange="previewAnnouncementtImage(event)">
                  </div><br>
                <button onclick="closeAnnouncement()" id="closeAnnouncementAdd">Close</button>
                <input type="submit" name="submitAnnouncement" value="Add Announcement">
            </form>
        </div>
    </section>
    
</body>
<script src="./javascript/add.js"></script>
</html> 