<?php 
$localhost = "localhost";
$user = "root";
$password = "";
$database = "bagong_ilog";
$connect = mysqli_connect($localhost, $user, $password, $database);

$sql = "SELECT * FROM resident";
$result = mysqli_query($connect, $sql);

if($connect){
    echo "";
}else {
    die(mysqli_error($connect));
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        // Delete resident
        $sqlDelete = "DELETE FROM `resident` WHERE `resident_id` = ?";
        $stmtDelete = $connect->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();

        // Log deletion action in audit trail
        $action_type = 'DELETE';
        $table_name = 'resident';
        $record_id = $id;
        $admin_id = 1;//$_SESSION['admin_id']; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        // Redirect to archived list
        echo"<script>window.location.href='archivedList.php';</script>";
        exit(); // Ensure that no further code execution occurs after redirection
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}

if(isset($_GET['official_id'])) {
    $id = $_GET['official_id'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        // Delete official
        $sqlDelete = "DELETE FROM `barangay_official` WHERE `official_id` = ?";
        $stmtDelete = $connect->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();

        // Log deletion action in audit trail
        $action_type = 'DELETE';
        $table_name = 'barangay_official';
        $record_id = $id;
        $admin_id = 1;//$_SESSION['admin_id']; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        // Redirect to officials page
        echo"<script>window.location.href='archivedofficials.php';</script>";
        exit(); // Ensure that no further code execution occurs after redirection
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}


if (isset($_GET['Hotline_id'])) {
    $id = $_GET['Hotline_id'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        // Delete hotline number
        $sqlDelete = "DELETE FROM `hotline_numbers` WHERE `Hotline_id` = ?";
        $stmtDelete = $connect->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();

        // Log deletion action in audit trail
        $action_type = 'DELETE';
        $table_name = 'hotline_numbers';
        $record_id = $id;
        $admin_id = 1;//$_SESSION['admin_id']; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        // Redirect to hotline page
        echo"<script>window.location.href='hotline.php';</script>";
        exit(); // Ensure that no further code execution occurs after redirection
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_GET['ID_event'])) {
    $id = $_GET['ID_event'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        // Delete event
        $sqlDelete = "DELETE FROM `events` WHERE `Event_ID` = ?";
        $stmtDelete = $connect->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();

        // Log deletion action in audit trail
        $action_type = 'DELETE';
        $table_name = 'events';
        $record_id = $id;
        $admin_id = 1;//$_SESSION['admin_id']; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        // Redirect to events page
        echo"<script>window.location.href='archivedevent.php';</script>";
        exit(); // Ensure that no further code execution occurs after redirection
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}


if (isset($_GET['announcement_id'])) {
    $id = $_GET['announcement_id'];

    // Begin transaction
    $connect->begin_transaction();

    try {
        // Delete announcement
        $sqlDelete = "DELETE FROM `announcement` WHERE `announcement_id` = ?";
        $stmtDelete = $connect->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();

        // Log deletion action in audit trail
        $action_type = 'DELETE';
        $table_name = 'events and announcement';
        $record_id = $id;
        $admin_id = 1;//$_SESSION['admin_id']; // Assuming admin ID is stored in session
        $old_values = null; // No old values for deletion
        $new_values = null; // No new values for deletion
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        // Redirect to announcements page
        echo"<script>window.location.href='archivedannounce.php';</script>";
        exit(); // Ensure that no further code execution occurs after redirection
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error: " . $e->getMessage();
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/deletemodal.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<section id="form-section-delete">
    <div class="dialog">
        <div class="icon">!</div>
        <div class="message">Are you sure?</div>
        <div class="warning">This data would be permanently, You won’t be able to retrieve it again.</div>
        <div class="buttons">
            <a id="confirmDelete" class="delete-button" href="#">Delete</a>
            <button class="cancel-button" onclick="cancel()">Cancel</button>
        </div>
    </div>
</section>

<section id="form-delete-hotline" style="display: none;">
    <div class="hotline-dialog">
        <div class="icon">!</div>
        <div class="message">Delete Hotline Number</div>
        <div class="warning">Are you sure you want to delete this? You won’t be able to retrieve it again.</div>
        <div class="buttons">
            <a id="confirmHotlineDelete" class="delete-button" href="#">Delete</a>
            <button class="cancel-button" onclick="cancelHotline()">Cancel</button>
        </div>
    </div>
</section>

<section id="form-delete-event" style="display: none;">
    <div class="event-dialog">
        <div class="icon">!</div>
        <div class="message">Delete Event</div>
        <div class="warning">Are you sure you want to delete this? You won’t be able to retrieve it again.</div>
        <div class="buttons">
            <a id="confirmEventDelete" class="delete-button" href="#">Delete</a>
            <button class="cancel-button" onclick="cancelEvent()">Cancel</button>
        </div>
    </div>
</section>

<section id="form-delete-announcement" style="display: none;">
    <div class="announcement-dialog">
        <div class="icon">!</div>
        <div class="message">Delete Announcement</div>
        <div class="warning">Are you sure you want to delete this? You won’t be able to retrieve it again.</div>
        <div class="buttons">
            <a id="confirmAnnouncementDelete" class="delete-button" href="#">Delete</a>
            <button class="cancel-button" onclick="cancelAnnouncement()">Cancel</button>
        </div>
    </div>
</section>

<section id="form-delete-official" style="display: none;">
    <div class="announcement-dialog">
        <div class="icon">!</div>
        <div class="message">Delete Official's Record</div>
        <div class="warning">Are you sure you want to delete this? You won’t be able to retrieve it again.</div>
        <div class="buttons">
            <a id="confirmDeleteOfficial" class="delete-button" href="#">Delete</a>
            <button class="cancel-button" onclick="cancelOfficial()">Cancel</button>
        </div>
    </div>
</section>






