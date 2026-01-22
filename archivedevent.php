<?php
include 'connection.php'; 
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
    <title>Events</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f0f2f5;
        }

        .header {
            position: fixed;
            width: 100%;
            height: 65px;
            background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
            top: 0;
            left: 0;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .header .title {
            display: flex;
            align-items: center;
        }

        .header .title img {
            margin-right: 10px;
        }

        .header .heading {
            color: #EEEEEE;
        }

        .outer-a-container {
            position: relative;
        }

        .outer-a {
            text-decoration: none;
            color: white;
           
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
        }

        .dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
        }

        .dropdown .inner-a:hover {
            color:lightblue;

        }
        
        .outer-a-container:hover .dropdown {
            display: block;
        }

        .nav {
            position: fixed;
            left: 0;
            top: 65px;
            display: flex;
            flex-direction: column;
            align-items: left;
            padding-top: 30px;
            justify-content: space-between;
            height: calc(100vh - 50px);
            width: 237px;
            background-color: #0C0C0C;
            z-index: 1000;
            
        }

        .options {
            width: 92%;
            padding: 10px;
            text-align: center;
            font-size: 13px;
        }

        .options:last-child {
            margin-top: auto;
        }

        .outer-a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            text-align: left;


        }

        .outer-a:hover {
            color:lightblue;
        }
      

        .nav .dropdown {
            display: none;
            position: static;
            background: none;
            box-shadow: none;
        }

        .nav .dropdown a {
            color: white;
          
        }

        .nav .options:hover .dropdown {
            display: block;
        }

        #logout {
            margin-bottom: 50px;
        }
        .events-container {
            margin-left: 235px;
            margin-top: 80px;
            height: 85vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #table-wrapper-events {
            position: relative;
            overflow-y: auto;
            width: 90%;
            margin: 20px auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        thead th {
            position: sticky;
            top: 0;
            background-color: #0F044C;
            color: white;
            z-index: 1;
            height: 50px;
            border-bottom: 2px solid #ddd;
            text-align: left;
            padding: 10px;
            font-size: 1rem;
        }

        tbody tr {
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        tbody td {
            padding: 10px;
            text-align: left;
            font-size: 1rem;
            color: #333;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:nth-child(even) {
            background-color: #fff;
        }

        .button-con {
    display: flex;
    justify-content: left;
    position: fixed;
    width: 82%;
    z-index: 2;
    gap: 10px;
    margin-top: 60px;
    margin-left: 105px;
}
        #print-resident {
            padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
         
        }

        #print-resident:hover {
            background-color: #365486;
            transform: scale(1.1);
        }

        .archive, .deletebutton{
            padding: 10px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            align-content:center;
            display:flex;
        }

        .archive:hover, .deletebutton:hover{
            background-color: #365486;
            transform: scale(1.1);
        }

    </style>
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

    <div class="events-container">

        <div class="eventtitle">
            <h1>Archived Events</h1>
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
                        $sql = "SELECT * FROM events WHERE `status` = 'inactive'";
                        $result = mysqli_query($connect, $sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<td>" . $row["Event_ID"] . "</td>";
                            echo "<td>" . $row["Event_Name"] . "</td>";
                            echo "<td>" . $row["Type_of_Event"] . "</td>";
                            echo "<td>" . $row["Date"] . "</td>";
                            echo "<td>" . $row["image"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td class=\"no-print\"><a href=\"events.php?id_event=" . $row['Event_ID'] . "\" class=\"archive\" name=\"archiveButton\"><img src=\"./assets/arrow-up-circle-fill.svg\" height=\"30\"></a></td>";
                            echo "<td><button class=\"deletebutton\" onclick=\"showDeleteEvent(" . $row['Event_ID'] . ")\"><img src=\"./assets/trash.svg\" height=\"30\"></button></td>";
                            echo "</tr>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function showDeleteEvent(eventId) {
    document.getElementById("form-delete-event").style.display = "flex";
    var deleteEventUrl = "delete.php?ID_event=" + eventId;
    document.getElementById("confirmEventDelete").href = deleteEventUrl;
}
function cancelEvent() {
    document.getElementById("form-delete-event").style.display = "none";
}
</script>
</html>
