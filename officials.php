<?php
include 'connection.php'; 
include 'testing.php';
include 'add.php'; 
include 'update.php'; 
include 'delete.php';
function updateOfficialStatus($connect, $official_id, $status) {
    // Begin transaction
    $connect->begin_transaction();

    try {
        $sql = "UPDATE barangay_official SET status = ? WHERE official_id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("si", $status, $official_id);
        $stmt->execute();

        $action_type = 'UPDATE';
        $table_name = 'barangay_official';
        $record_id = $official_id;
        $admin_id = 1;
        $old_values = null; 
        $new_values = null; 
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiisss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        // No echo here to avoid output before PDF generation
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error updating official's status: " . $e->getMessage();
    }

    $stmt->close();
}

// Check if an official ID is provided for updating status to 'inactive'
if (isset($_GET['id_official'])) {
    $official_id = intval($_GET['id_official']);
    updateOfficialStatus($connect, $official_id, 'inactive');
}

// Check if an official ID is provided for updating status to 'active'
if (isset($_GET['idOfficial'])) {
    $official_id = intval($_GET['idOfficial']);
    updateOfficialStatus($connect, $official_id, 'active');
}

// Fetch all barangay officials for display
$sql = "SELECT * FROM barangay_official";
$result = mysqli_query($connect, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Announce</title>
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
        .officials-container {
            margin-left: 235px;
            margin-top: 80px;
            height: 85vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #table-wrapper-officials {
            position: relative;
            overflow-y: auto;
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none; 
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

        #add-official-button {
            padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }


        #add-official-button:hover {
            background-color: #365486;
            transform: scale(1.1);
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
            height: 31px;
        }
        #print-official {
            padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
         
        }

        #print-official:hover {
            background-color: #365486;
            transform: scale(1.1);
        }


        .updateHotline, .archiveAnnounce, .unarchiveAnnounce, .deletebuttonAnnounce {
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            color: white;
            text-align: center;
            cursor: pointer;
        }

        .updateHotline {
            background-color: #38A538;
        }

        .archiveAnnounce {
            background-color: orangered;
        }

        .unarchiveAnnounce {
            background-color: aquamarine;
            color: black;
        }

        .deletebuttonAnnounce {
            background-color: red;
            border: none;
        }
        .updateButton{
            padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s
        }
        .updateButton:hover {
            background-color: #365486;
            transform: scale(1.1);
        }
        .archive-officials{
            padding: 10px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s
            align-content:center;
            display:flex;
        }

        .archive-officials:hover{
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

    <div class="officials-container">
       

        <div class="officialstitle">
            <h1>Officials</h1>
        </div>
        <div class="button-con">
            <button id="add-official-button" onclick="addOfficial()">Add Official</button>
            <form action="" method="post"><input type="submit" name="printofficial" id="print-official" value="Print list"></form>
        </div>
        <div id="table-wrapper-officials">
            <table>
                <thead>
                    <tr>
                        <th>Officials ID</th>
                        <th>Officials Name</th>
                        <th>Age</th>
                        <th>Position</th>
                        <th>Term Start</th>
                        <th>Term End</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th colspan="2">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT * FROM barangay_official WHERE `status` = 'active'";
                    $result = mysqli_query($connect, $sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["official_id"] . "</td>";
                        echo "<td>" . $row["last_name"] . ", " .$row["first_name"] . " " . $row["middle_name"] . " " .  "</td>";
                        echo "<td>" . $row["age"] . "</td>";
                        echo "<td>" . $row["position"] . "</td>";
                        echo "<td>" . $row["term_start"] . "</td>";
                        echo "<td>" . $row["term_end"] . "</td>";
                        echo "<td><img src='officials/" . $row["image"] . "' alt='Official Image' width='100'></td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td class=\"no-print\">
                            <button type='button' class='updateButton' onclick='openUpdateOfficial(
                                " . $row['official_id'] . ",
                                \"" . $row['last_name'] . "\",
                                \"" . $row['first_name'] . "\",
                                \"" . $row['middle_name'] . "\",
                                " . $row['age'] . ",
                                \"" . $row['position'] . "\",
                                \"" . $row['term_start'] . "\",
                                \"" . $row['term_end'] . "\",
                                \"" . $row['image'] . "\"
                            )'>Update</button>
                        </td>";
                        echo "<td class=\"no-print\"><a href=\"officials.php?id_official=" . $row['official_id'] . "\" class=\"archive-officials\" id=\"delete-officials\" name=\"archiveButton\"><img src=\"./assets/archive.svg\" height=\"35\"></a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function showDeleteOfficials(officialId) {
    document.getElementById("form-delete-official").style.display = "flex";
    var deleteOfficialUrl = "delete.php?official_id=" + officialId;
    document.getElementById("confirmDeleteOfficial").href = deleteOfficialUrl;
}

function cancelOfficial() {
    document.getElementById("form-delete-official").style.display = "none";
}
</script>
</html>

<?php
// Close the database connection only once at the end of the script
$connect->close();
?>
