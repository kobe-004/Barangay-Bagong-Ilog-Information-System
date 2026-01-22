<?php include'connection.php';?>
<?php include'update.php'; ?>
<?php include'add.php'; ?>
<?php include'delete.php'; ?>
<?php 
$sql = "SELECT * FROM hotline_numbers";
$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/hotline.css">
    <title>Document</title>

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
    <div class="hotline-container">
     
        <div class="hotlinetitle">
            <h1>Hotline Number</h1>
        </div>
        <div class="button-con">
        <button id="add-hotline-button" onclick="addHotline()">Add Number</button>
        </div>
        <div id="table-wrapper-hotline">
            <table>
                <thead>
                    <tr>
                        <th>Hotline ID</th>
                        <th>Department Name</th>
                        <th>Department Number</th>
                        <th colspan="2">Options</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "</tr>";
                            echo "<td>" . $row["Hotline_id"] . "</td>";
                            echo "<td>" . $row["Department_Name"] . "</td>";
                            echo "<td>" . $row["Department_Number"] . "</td>";
                            echo "<td class=\"no-print\"><button type='button' class='updateHotline'onclick='openUpdateHotline(" . $row['Hotline_id'] . ", \"" . $row['Department_Name'] . "\", \"" . $row['Department_Number'] . "\")'>Update</button></td>";
                            echo "<td class=\"no-print\"><button class=\"deletebuttonevent\" onclick=\"showDeleteHotline(" . $row['Hotline_id'] . ")\"><img src=\"./assets/trash.svg\" height=\"30\"></button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div> 
        </div>

</body>
<script>
function showDeleteHotline(hotlineId) {
    document.getElementById("form-delete-hotline").style.display = "flex";
    var deleteHotlineUrl = "delete.php?Hotline_id=" + hotlineId;
    document.getElementById("confirmHotlineDelete").href = deleteHotlineUrl;
}

function cancelHotline() {
    document.getElementById("form-delete-hotline").style.display = "none";
}


</script>
</html>