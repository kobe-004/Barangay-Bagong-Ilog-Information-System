<?php include'connection.php';?>
<?php include'verification.php'; ?>
<?php 
$sql = "SELECT * FROM `pending_account`";
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
        .pending-container {
            margin-left: 220px;
            margin-top: 80px;
            height: 85vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #table-wrapper-pending {
            position: relative;
            overflow-y: auto;
            width: 90%;
            margin: 10px auto;
            height: 65vh;
            margin-left: 65px;
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

        #pending-print-button {
            padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
           margin-right: 81.7%;
        }


        #pending-print-button:hover {
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
        .viewButton {
            padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s
        }
        .viewButton:hover {
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
                <li><a href="event.php" class="inner-a">Events</a></li>
                <li><a href="announce.php" class="inner-a">Announcements</a></li>
            </ul>
        </div>
        <div class="options">
            <a href="#" class="outer-a"><i class="fas fa-archive" style="margin-right: 5px;"></i> Archives</a>
            <ul class="dropdown">
                <li><a href="archivedofficials.php" class="inner-a">Barangay Officials</a></li>
                <li><a href="archivedhotline.php" class="inner-a"> Hotline Number</a></li>
                <li><a href="archivedevent.php" class="inner-a"> Events</a></li>
                <li><a href="archivedannounce.php" class="inner-a"> Announcements</a></li>
                <li><a href="archivedlist.html" class="inner-a">Resident List</a></li>
            </ul>
        </div>

        <div class="options">
            <a href="homepage.php" class="outer-a" id="logout"><i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Log out</a>
        </div>
    </div>


    <div class="pending-container">
        <div class="pendingtitle">
            <h1>Pending Accounts</h1>
        </div>
        <div id="table-wrapper-pending">
            <table>
                <thead>
                    <tr>
                        <th>Pending ID</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>First Name</th>
                        <th>Birthday</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Civil Status</th>
                        <th>Occupation</th>
                        <th>House Number</th>
                        <th>Street</th>
                        <th>Educational Attainment</th>
                        <th>Registered Voter</th>
                        <th style="display:none;">Email</th>
                        <th style="display:none;">Password</th>
                        <th>ID image</th>
                        <th>Status</th>
                        <th colspan="2" class="no-print" >Options</th>
                    </tr>
                </thead>
            <tbody>
                <?php 
                    $sql = "SELECT * FROM pending_account WHERE `status` = 'pending'";
                    $result = mysqli_query($connect, $sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["pending_id"] . "</td>";
                        echo "<td>" . $row["Last_name"] . "</td>";
                        echo "<td>" . $row["Middle_name"] . "</td>";
                        echo "<td>" . $row["First_name"] . "</td>";
                        echo "<td>" . $row["Birthday"] . "</td>";
                        echo "<td>" . $row["Age"] . "</td>";
                        echo "<td>" . $row["Gender"] . "</td>";
                        echo "<td>" . $row["Civil_Status"] . "</td>";
                        echo "<td>" . $row["Occupation"] . "</td>";
                        echo "<td>" . $row["house_number"] . "</td>";
                        echo "<td>" . $row["street"] . "</td>";
                        echo "<td>" . $row["Educational_Attainment"] . "</td>";
                        echo "<td>" . $row["Registered_Voter"] . "</td>";
                        echo "<td style=\"display:none;\">" . $row["Email"] . "</td>";
                        echo "<td style=\"display:none;\">" . $row["Password"] . "</td>";
                        echo "<td>" . $row["image"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td class=\"no-print\"><button type='button' class='viewButton'onclick='acceptResident(" . $row['pending_id'] . ", \"" . $row['Last_name'] . "\", \"" . $row['Middle_name'] . "\", \"" . $row['First_name'] . "\", \"" . $row['Birthday'] . "\", " . $row['Age'] . ", \"" . $row['Gender'] . "\", \"" . $row['Civil_Status'] . "\", \"" . $row['Occupation'] . "\", \"" . $row['house_number'] . "\", \"" . $row['street'] . "\", \"" . $row['Educational_Attainment'] . "\", \"" . $row['Registered_Voter'] . "\", \"" . $row['Email'] . "\", \"" . $row['Password'] . "\", \"" . $row['image'] . "\")'>View</button></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</body>
<script>
        function print(elementId) {
        var printData = document.getElementById(elementId).innerHTML;
        var newWin = window.open('', '_blank');
        newWin.document.write('<html><head><title></title><link rel="stylesheet" type="text/css" href="style.css"><style>@media print { @page { size: legal landscape; } h1 { text-align: center; } .no-print { display: none; } }</style></head><body><h1>Archived Resident Info</h1>' + printData + '</body></html>');
        newWin.document.close();
        newWin.print();
        }
    </script>
</html>
<?php
// Close connection
$connect->close();
?>