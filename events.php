<?php
include 'connection.php'; 
include 'printevents.php';
include 'add.php'; 
include 'update.php'; 
include 'delete.php';

// Function to update the status of an event and log the action in the audit trail
function updateEventStatus($connect, $event_id, $status) {
    // Begin transaction
    $connect->begin_transaction();

    try {
        // Update event status
        $sql = "UPDATE events SET status = ? WHERE Event_ID = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("si", $status, $event_id);
        $stmt->execute();

        // Log action in the audit trail
        $action_type = 'UPDATE';
        $table_name = 'events';
        $record_id = $event_id;
        $admin_id = 1; // Assuming admin ID is stored in session
        $old_values = null; // No old values for event status update
        $new_values = json_encode(['status' => $status]); // New status
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiisss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        echo "Event status updated successfully.";
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error updating event status: " . $e->getMessage();
    }

    $stmt->close();
}

// Check if an event ID is provided for updating status to 'inactive'
if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
    updateEventStatus($connect, $event_id, 'inactive');
}

// Check if an event ID is provided for updating status to 'active'
if (isset($_GET['id_event'])) {
    $event_id = intval($_GET['id_event']);
    updateEventStatus($connect, $event_id, 'active');
}

// Fetch all active events for display
$sql = "SELECT * FROM events WHERE `status` = 'active'";
$result = mysqli_query($connect, $sql);

// Close the database connection only once at the end of the script
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/events.css">
    <title>Events</title>
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
            <a href="household.php" class="outer-a"><i class="fas fa-users" style="margin-right: 5px;"></i> Households</a>
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
        <div class="events-container">

        <div class="eventtitle">
            <h1>Events</h1>
        </div>
        <div class="button-con">
        <button id="add-official-event" onclick="addEvent()">Add Event</button>
        <form action="" method="post"><input type="submit" name="event" id="print-event" value="Print List"></form>
        </div>
        <div id="table-wrapper-events">
            <table>
                <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Type of Event</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th colspan="2">Option</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                        $sql = "SELECT * FROM events WHERE `status` = 'active'";
                        $result = mysqli_query($connect, $sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<td>" . $row["Event_ID"] . "</td>";
                            echo "<td>" . $row["Event_Name"] . "</td>";
                            echo "<td>" . $row["Type_of_Event"] . "</td>";
                            echo "<td>" . $row["Date"] . "</td>";
                            echo "<td>" . $row["image"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td class=\"no-print\"><button type='button' class='updateButton'onclick='openUpdateEvent(" . $row['Event_ID'] . ", \"" . $row['Event_Name'] . "\", \"" . $row['Type_of_Event'] . "\", \"" . $row['Date'] . "\", \"" . $row['image'] . "\")'>Update</button></td>";
                            echo "<td class=\"no-print\"><a href=\"events.php?event_id=" . $row['Event_ID'] . "\" class=\"archive\" name=\"archiveButton\"><img src=\"./assets/archive.svg\" height=\"35\"></a></td>";
                            echo "</tr>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</body>
<?php $connect->close();
?>
</html>