<?php
include 'connection.php'; 
include 'printannounce.php';
include 'update.php'; 
include 'add.php'; 


// Function to update the status of an announcement and log the action in the audit trail
function updateAnnouncementStatus($connect, $announce_id, $status) {
    // Begin transaction
    $connect->begin_transaction();

    try {
        // Update announcement status
        $sql = "UPDATE announcement SET status = ? WHERE announcement_id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("si", $status, $announce_id);
        $stmt->execute();

        // Log action in the audit trail
        $action_type = 'UPDATE';
        $table_name = 'announcement';
        $record_id = $announce_id;
        $admin_id = 1; // Assuming admin ID is stored in session
        $old_values = null; // No old values for announcement status update
        $new_values = json_encode(['status' => $status]); // New status
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiisss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        echo "Announcement status updated successfully.";
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error updating announcement status: " . $e->getMessage();
    }

    $stmt->close();
}

// Check if an announcement ID is provided for updating status to 'inactive'
if (isset($_GET['id_ann'])) {
    $announce_id = intval($_GET['id_ann']);
    updateAnnouncementStatus($connect, $announce_id, 'inactive');
}


// Fetch all announcements for display
$sql = "SELECT * FROM announcement";
$result = mysqli_query($connect, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/announce.css">
    <title>Announcement</title>
</head>
<body>
<div class="header">
        <div class="title">
            <img src="./assets/bgi logo.png" height="55" alt="Logo">
            <h2 class="heading">ADMIN</h2>
        </div>
    </div>

    <div class="nav">
        <div class="options">
            <a href="index.php" class="outer-a"><i class="fas fa-tachometer-alt" style="margin-right: 5px;"></i> Dashboard</a>
        </div>

        <div class="options">
            <a href="residents.php" class="outer-a"><i class="fas fa-users" style="margin-right: 5px;"></i> Residents</a>
        </div>
        
        <div class="options">
            <a href="#" class="outer-a"><i class="fas fa-users" style="margin-right: 5px;"></i> Households</a>
        </div>

        <div class="options">
            <a href="#" class="outer-a"><i class="fas fa-clock" style="margin-right: 5px;"></i> Pending</a>
            <ul class="dropdown">
                <li><a href="pendingAcc.php" class="inner-a">Pending Accounts</a></li>
                <li><a href="pendingRequest.php" class="inner-a">Pending Requests</a></li>
            </ul>
        </div>

        <div class="options">
            <a href="audit.php" class="outer-a"><i class="fas fa-search" style="margin-right: 5px;"></i> Check Activities</a>
        </div>
        <div class="options">
            <a href="#" class="outer-a"><i class="fas fa-edit" style="margin-right: 5px;"></i> Update Information</a>
            <ul class="dropdown">
                <li><a href="officials.php" class="inner-a">Barangay Officials</a></li>
                <li><a href="hotline.php" class="inner-a">Hotline Number</a></li>
                <li><a href="events.php" class="inner-a">Events</a></li>
                <li><a href="announce.php" class="inner-a">Announcements</a></li>
                <li><a href="statistics.php" class="inner-a">Statistics</a></li>
            </ul>
        </div>
        <div class="options">
            <a href="#" class="outer-a"><i class="fas fa-archive" style="margin-right: 5px;"></i> Archives</a>
            <ul class="dropdown">
                <li><a href="archivedofficials.php" class="inner-a">Barangay Officials</a></li>
                <li><a href="archivedevent.php" class="inner-a"> Events</a></li>
                <li><a href="archivedannounce.php" class="inner-a"> Announcements</a></li>
                <li><a href="archivedList.php" class="inner-a">Resident List</a></li>
            </ul>
        </div>

        <div class="options">
            <a href="homepage.php" class="outer-a" id="logout"><i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Log out</a>
        </div>
    </div>

    <div class="announce-container">
        <div class="announcetitle">
            <h1>Announcements</h1>
        </div>
        <div class="button-con">
            <button id="add-announcement-button" onclick="addAnnouncement()">Add Announcement</button>
            <form action="" method="post"><input type="submit" name="ann" id="print-announce" value="Print List"></form>
        </div>

        <div id="table-wrapper-announcement">
            <table>
                <thead>
                    <tr>
                        <th>Announcement ID</th>
                        <th>Announcement Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Modified on</th>
                        <th colspan="2">Options</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM announcement WHERE `status` = 'active'";
                $result = mysqli_query($connect, $sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "</tr>";
                        echo "<td>" . $row["announcement_id"] . "</td>";
                        echo "<td>" . $row["announcement_title"] . "</td>";
                        echo "<td>" . $row["announcement_description"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["image_announcement"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["timestamp"] . "</td>";
                        echo "<td class=\"no-print\"><button type='button' class='updateHotline'onclick='openUpdateAnnouncement(" . $row['announcement_id'] . ", \"" . $row['announcement_title'] . "\", \"" . $row['announcement_description'] . "\", \"" . $row['date'] . "\",  \"" . $row['image_announcement'] . "\")'>Update</button></td>";
                        echo "<td class=\"no-print\"><a href=\"announce.php?id_ann=" . $row['announcement_id'] . "\" class=\"archive\" name=\"archiveButton\"><img src=\"./assets/archive.svg\" height=\"35\"></a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<?php $connect->close();
?>
</html>