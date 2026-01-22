<?php
include 'connection.php';
if (isset($_POST['updateRecord'])) {
    $residentId = $_POST['resident_id'];
    $lastName = $_POST['last_name'];
    $middleName = $_POST['middle_name'];
    $firstName = $_POST['first_name'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $civilStatus = $_POST['civil_status'];
    $occupation = $_POST['occupation'];
    $houseNumber = $_POST['house_number'];
    $street = $_POST['street'];
    $educationalAttainment = $_POST['education'];
    $voter = $_POST['registered_voter'];

    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];

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

        $stmt->execute();
        $action_type = 'UPDATE';
        $table_name = 'resident';
        $record_id = $residentId; // Corrected to use $residentId
        $admin_id = 1; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        echo"<script>window.location.href='residents.php';</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST['submitUpdateofficial'])) {
    $officialId = $_POST['official_id'];
    $lastNameOfficial = $_POST['official_last_name'];
    $middleNameOfficial = $_POST['official_middle_name'];
    $firstNameOfficial = $_POST['official_first_name'];
    $suffixOfficial = $_POST['official_suffix'];
    $ageOfficial = $_POST['official_age'];
    $position = $_POST['position'];
    $termStart = $_POST['term_start'];
    $termEnd = $_POST['term_end'];

    $img_name = $_FILES['official_image']['name'];
    $tmp_name = $_FILES['official_image']['tmp_name'];
    $error = $_FILES['official_image']['error'];

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
                    $img_upload_path = './officials/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $sqlUpdate = "UPDATE `barangay_official` SET 
                        `first_name`= ?,
                        `middle_name`= ?,
                        `last_name`= ?,
                        `age`= ?,
                        `position`= ?,
                        `term_start`= ?,
                        `term_end`= ?,
                        `image`= ? 
                        WHERE `official_id`= ?";
                    $stmt = $connect->prepare($sqlUpdate);
                    $stmt->bind_param("ssssssssi", $firstNameOfficial, $middleNameOfficial, $lastNameOfficial, $ageOfficial, $position, $termStart, $termEnd, $new_img_name, $officialId);
                } else {
                    throw new Exception("Invalid image format");
                }
            } else {
                throw new Exception("Error uploading image");
            }
        } else {
            $sqlUpdate = "UPDATE `barangay_official` SET 
                `first_name`= ?,
                `middle_name`= ?,
                `last_name`= ?,
                `age`= ?,
                `position`= ?,
                `term_start`= ?,
                `term_end`= ? 
                WHERE `official_id`= ?";
            $stmt = $connect->prepare($sqlUpdate);
            $stmt->bind_param("sssssssi", $firstNameOfficial, $middleNameOfficial, $lastNameOfficial, $ageOfficial, $position, $termStart, $termEnd, $officialId);
        }

        $stmt->execute();
        $action_type = 'UPDATE';
        $table_name = 'barangay_officials';
        $record_id = $officialId; // Corrected to use $officialId
        $admin_id = 1; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();
        // Commit transaction
        $connect->commit();

        echo"<script>window.location.href='officials.php';</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['updateHotline'])) {
    $hotlineId = $_POST['hotline_id'];
    $hotlineName = $_POST['department_nameUPD'];
    $hotlineNumber = $_POST['department_numberUPD'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        $sqlUpdate = "UPDATE `hotline_numbers` SET `Department_Name`= ?, `Department_Number`= ? WHERE `Hotline_id`= ?";
        $stmt = $connect->prepare($sqlUpdate);
        $stmt->bind_param("ssi", $hotlineName, $hotlineNumber, $hotlineId);
        $stmt->execute();
        $action_type = 'UPDATE';
        $table_name = 'hotline_numbers';
        $record_id = $hotlineId;
        $admin_id = 1;//$_SESSION['admin_id']; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();
        // Commit transaction
        $connect->commit();

        echo "Record updated successfully";
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error updating record: " . $e->getMessage();
    }

    $stmt->close();
    $connect->close();
}

if (isset($_POST['updateEvent'])) {
    $eventId = $_POST['event_id'];
    $eventName = $_POST['event_nameUPD'];
    $eventType = $_POST['type_of_eventUPD'];
    $eventDate = $_POST['event_dateUPD'];
    $img_name = $_FILES['event_imageUPD']['name'];
    $tmp_name = $_FILES['event_imageUPD']['tmp_name'];
    $error = $_FILES['event_imageUPD']['error'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        if ($img_name != '') {
            if ($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png", "heic", "webp");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = './events/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $sqlUpdate = "UPDATE `events` SET
                        `Event_Name` = ?,
                        `Type_of_Event` = ?,
                        `Date` = ?,
                        `image` = ?
                        WHERE `Event_ID` = ?";
                }
            }
        } else {
            $sqlUpdate = "UPDATE `events` SET
                `Event_Name` = ?,
                `Type_of_Event` = ?,
                `Date` = ?
                WHERE `Event_ID` = ?";
        }

        $stmt = $connect->prepare($sqlUpdate);
        if ($img_name != '') {
            $stmt->bind_param("ssssi", $eventName, $eventType, $eventDate, $new_img_name, $eventId);
        } else {
            $stmt->bind_param("sssi", $eventName, $eventType, $eventDate, $eventId);
        }
        $stmt->execute();
        $action_type = 'UPDATE';
        $table_name = 'events';
        $record_id = $eventId;
        $admin_id = 1;//$_SESSION['admin_id']; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        echo "<script>window.location.href='events.php?insert_msg=The data has been updated successfully!'</script>";
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error updating record: " . $e->getMessage();
    }

    $stmt->close();
}

if (isset($_POST['updateAnnouncement'])) {
    $announceId = $_POST['announce_id'];
    $announceTitle = $_POST['announcement_titleUPD'];
    $announceDescription = $_POST['descriptionUPD'];
    $announceDate = $_POST['annnouncement_dateUPD'];
    $img_name = $_FILES['announce_imageUPD']['name'];
    $tmp_name = $_FILES['announce_imageUPD']['tmp_name'];
    $error = $_FILES['announce_imageUPD']['error'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        if ($img_name != '') {
            if ($error === 0) {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png", "heic", "webp");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = './announcement/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $sqlUpdate = "UPDATE `announcement` SET
                        `announcement_title` = ?,
                        `announcement_description` = ?,
                        `date` = ?,
                        `image_announcement` = ?
                        WHERE `announcement_id` = ?";
                        $stmt = $connect->prepare($sqlUpdate);
                        $stmt->bind_param("ssssi", $announceTitle, $announceDescription, $announceDate, $new_img_name, $announceId);

                }
            }
        } else {
            $sqlUpdate = "UPDATE `announcement` SET
                `announcement_title` = ?,
                `announcement_description` = ?,
                `date` = ?
                WHERE `announcement_id` = ?";
                $stmt = $connect->prepare($sqlUpdate);
                $stmt->bind_param("sssi", $announceTitle, $announceDescription, $announceDate, $announceId);
        }

       
        $stmt->execute();

        $action_type = 'UPDATE';
        $table_name = 'announcement';
        $record_id = $announceId;
        $admin_id = 1; // $_SESSION['admin_id']; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmtAudit = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtAudit->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmtAudit->execute();

        // Commit transaction
        $connect->commit();

        echo "<script>window.location.href='announce.php?insert_msg=The data has been updated successfully!'</script>";
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error updating record: " . $e->getMessage();
    }

    $stmt->close();
    $stmtAudit->close();
    $connect->close();
}

?>
<?php
include 'connection.php';
$sql = "SELECT * FROM `bagong_ilog_streets`";
$result = $connect->query($sql);
$result = mysqli_query($connect, $sql);
?>
<?php 
$query = "SELECT gender_id, gender_name FROM gender";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modal.css">
    <title>Update Forms</title>
</head>
<body>
<section id="update-resident" style="display:none;">
    <div class="update-resident-modal"><br><br><br><br><br><br><br><br>
        <h1 style="color:#0F044C">Update Resident Information</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" id="resident_id" name="resident_id">
            <div class="name-con">
                <div class="name-official">
                    <label for="last_nameUPD">Last Name</label><br>
                    <input type="text" name="last_name" id="last_nameUPD"><br><br>
                </div>
                <div class="name-official">
                    <label for="middle_nameUPD">Middle Name</label><br>
                    <input type="text" name="middle_name" id="middle_nameUPD"><br><br>
                </div>
                <div class="name-official">
                    <label for="first_nameUPD">First Name</label><br>
                    <input type="text" name="first_name" id="first_nameUPD"><br><br>
                </div>
            </div>
            <div class="name-con">
                <div class="name-official">
                    <label for="birthdayUPD">Birthday</label><br>
                    <input type="date" name="birthday" id="birthdayUPD"><br><br>
                </div>
                <div class="name-official">
                    <label for="ageUPD">Age</label><br>
                    <input type="number" name="age" id="ageUPD"><br><br>
                </div>
                <div class="name-official">
                    <label for="genderUPD">Gender</label><br>
                    <select id="genderUPD" name="gender"> 
                        <?php
                        $sql = "SELECT * FROM `gender`";
                        $result = mysqli_query($connect, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['gender_name'] . "'>" . $row['gender_name'] . "</option>";
                        }
                        ?>
                    </select><br><br>
                </div>
                <div class="name-official">
                    <label for="civil_statusUPD">Civil Status</label><br>
                    <input type="text" name="civil_status" id="civil_statusUPD"><br><br>
                </div>
                <div class="name-official">
                    <label for="occupationUPD">Occupation</label><br>
                    <input type="text" name="occupation" id="occupationUPD"><br><br>
                </div>
                <div class="name-official">
                    <label for="">House Number</label><br>
                    <input type="text" name="house_number" id="house_numberUPD"><br><br>
                </div>
                <div class="name-official">
                    <label for="streetUPD">Street</label><br>
                    <select id="streetUPD" name="street">
                                                <?php
                        foreach ($streets as $street) {
                            echo "<option value=\"$street\" id=\"streetUPD\">$street</option>";
                        }
                        ?>
                    </select><br><br>
                </div>
                <div class="name-official">
                    <label for="educationUPD">Educational Attainment</label><br>
                    <input type="text" name="education" id="educationUPD"><br><br>
                </div>
                <div class="name-official">
                    <label for="registered_voterUPD">Registered Voter</label><br>
                    <select name="registered_voter" id="registered_voterUPD">
                            <option value="yes" name="registered_voter">Yes</option>
                            <option value="no" name="registered_voter">No</option>
                        </select><br><br>
                </div>
            </div>
            <div class="image-con">
                <div class="form-group">
                    <label for="imageUPDATE">Enter your image</label>
                    <div class="square" style="width:300px; height: 200px; background-color:gray;">
                        <img src="" alt="" id="imageUPDATE" width="300px"> 
                    </div><br><br>
                    <input type="file" class="form-control" id="imageInput" name="image" placeholder="Enter image" onchange="previewImage(event)">
                </div>  
            </div>
            <div class="image-con-new">
                <button type="button" onclick="exitUpdateRes()" id="closeResident">Close</button>
                <button type="submit" name="updateRecord" id="submitUpdateResident">Save changes</button>
            </form>
            </div>

    </div>
</section>

<section id="update-official" style="display:none;">
    <div class="update-off">
        <form action="" method="post" id="upd-off"enctype="multipart/form-data">
            <h2>Update Official</h2>
            <input type="hidden" id="official_id" name="official_id">
            <div class="inputs-con">
                <div class="input-group">
                <label for="official_last_nameUPD">Last Name</label><br>
                <input type="text" name="official_last_name" id="official_last_nameUPD"><br><br>
                </div>
                <div class="input-group">
                <label for="official_middle_nameUPD">Middle Name</label><br>
                <input type="text" name="official_middle_name" id="official_middle_nameUPD"><br><br>
                </div>
                <div class="input-group">
                <label for="official_first_nameUPD">First Name</label><br>
                <input type="text" name="official_first_name" id="official_first_nameUPD"><br><br>
                </div>
            </div>
            <div class="input-cons">
                <div class="input-group">
                <label for="official_ageUPD">Age</label><br>
                <input type="number" name="official_age" id="official_ageUPD"><br><br>
                </div>
                <div class="input-group">
                <label for="positionUPD">Position</label><br>
            <select name="position" id="positionUPD">
                <option value="Punong Barangay">Punong Barangay</option>
                <option value="Kagawad">Kagawad</option>
            </select><br><br>
                </div>
            </div>
            <div class="input-cons">
                <div class="input-group">
                <label for="term_startUPD">Term Start</label><br>
                <input type="date" name="term_start" id="term_startUPD"><br><br>
                </div>
                <div class="input-group">
                <label for="term_endUPD">Term End</label><br>
                <input type="date" name="term_end" id="term_endUPD"><br><br>
                </div>
            </div>
            <div class="image-con upd">
                <label for="official_image_input">Enter your image</label>
                <div class="square" style="width:110px; height: 130px; background-color:gray;">
                    <img src="" alt="" id="official_image_preview" width="300px"> 
                </div>
                <input type="file" class="form-control" id="official_image_input" name="official_image" placeholder="Enter image" onchange="previewImageOfficial(event)">
                <br>
                <div class="image-con-new">
                <button type="button" onclick="exitUpdateOff()" id="closeOfficial">Close</button>
                <button type="submit" name="submitUpdateofficial" id="submitUpdateofficial">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</section>

<section id="update-hotline">
        <div class="update-hotline-modal">
        <h1>Update Hotline Number</h1>
        <form action="" method="post">
            <input type="hidden" id="hotline_id" name="hotline_id">
            <label for="">Department Name</label><br>
            <input type="text" name="department_nameUPD" id="department_nameUPD"><br><br>
            <label for="">Department Number</label><br>
            <input type="text" name="department_numberUPD" id="department_numberUPD"><br><br>
            <button type="button" onclick="closeUpdateHotline()" id="closeHotlineAdd">Close</button>
            <input type="submit" name="updateHotline" value="update Hotline">
        </form>
        </div>
    </section>

    <section id="update-event">
        <div class="update-event-modal">
            <h1>Update Event Information</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" id="event_id" name="event_id">
                <label for="">Event Name</label><br>
                <input type="text" name="event_nameUPD" id="event_nameUPD"><br><br>
                <label for="">Type of Event</label><br>
                <input type="text" name="type_of_eventUPD" id="type_of_eventUPD"><br><br>
                <label for="">Date</label><br>
                <input type="date" name="event_dateUPD" id="event_dateUPD"><br><br>
                <div class="form-group">
                    <label for="">Enter event image</label>
                    <div class="square" style="width:300px; height: 200px; background-color:gray;">
                        <img src="" alt="" id="event_imageUPD" name="event_imageUPD" width="300px"> 
                    </div>
                    <input type="file" class="form-control" id="event_imageUPD" name="event_imageUPD" placeholder="Enter image" onchange="previewEventUpdateImage(event)">
                  </div>
                <br>
                <button onclick="closeUpdateEvent()" id="closeEventUpdate">Close</button>
                <input type="submit" name="updateEvent" value="Update Event" id="updateEvent">
            </form>
        </div>
    </section>

    <section id="update-announcement">
        <div class="update-announcement-modal">
        <h1>Update Announcement Information</h1>
            <form action="" method="post"  enctype="multipart/form-data">
                <input type="hidden" id="announce_id" name="announce_id">
                <label for="">Announcement Title</label><br>
                <input type="text" name="announcement_titleUPD" id="announcement_titleUPD"><br><br>
                <label for="">Description</label><br>
                <input type="text" name="descriptionUPD" id="descriptionUPD"><br><br>
                <label for="">Date</label><br>
                <input type="date" name="annnouncement_dateUPD" id="annnouncement_dateUPD"><br><br>
                <div class="group">
                    <label for="">Enter event image</label>
                    <div class="square" style="width:300px; height: 200px; background-color:gray;">
                        <img src="" alt="" id="announce_imageUPD_preview" width="300px"> 
                    </div><br><br>
                    <input type="file" class="form-control" id="announce_imageUPD" name="announce_imageUPD" placeholder="Enter image" onchange="previewAnnounceUpdateImage(event)">
                  </div>
                <br>
                <button onclick="closeAnnouncementUPD()" id="closeAnnouncementUPD">Close</button>
                <input type="submit" name="updateAnnouncement" value="Update Announcement">
            </form>
        </div>
    </section>
<script src="./javascript/update.js"></script>
</body>
</html>

