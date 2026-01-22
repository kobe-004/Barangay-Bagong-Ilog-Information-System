<?php include'connection.php'; ?>
<?php include'printResident.php'; ?>
<?php include'add.php'; ?>
<?php include'update.php'; ?>
<?php 
if (isset($_GET['id'])) {
    $resident_id = intval($_GET['id']);

    $sql = "UPDATE resident SET status = 'inactive' WHERE resident_id = $resident_id";

    if (mysqli_query($connect, $sql)) {
        echo "";
    } else {
        echo "" . mysqli_error($connect);
    }
} else {
    echo "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Resident list</title>
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
    
        table {
             border-collapse: collapse;
            width: 94%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-left: 45px;
}


.table-wrapper {
    position: relative;
    height: 65vh;
    overflow-y: auto;
    margin-top: 5%;
    margin-left: 57px;
    width: 94%;
}

thead th {
    position: sticky;
            top: 0;
            background-color: #0F044C;
            color: white;
            z-index: 1;
            height: 30px;
            border-bottom: 2px solid #ddd;
            text-align: left;
            padding: 10px;
            font-size: 1rem;
}

thead, th, td {
    border: 0px solid black;
    padding: 5px;
    text-align: left;
    font-size: 17px;
    color: black;
}

th, td {
    white-space: nowrap;
}

tbody tr:nth-child(odd) {
    background-color: #f2f2f2;
}

tbody td {
    padding: 10px;
    text-align: left;
    font-size: 12px;
}

/* #print-resident{
    position: absolute;
    right: 0;
    margin-top: 20px;
    margin-left: 50px;
} */

.tableCon {
    width: 87%;
    height: 76vh;
    position: fixed;
    right: 1%;
    top: 8%;
}


.search-con {
    display: flex;
    justify-content: space-between;
    position: fixed;
    width: 82%;
    z-index: 2;
    margin-left: 104px;
}

h1 {
    color: black;
    text-align: center;
    margin-top: 40px;
}

.add-residents-button {
            padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            white-space: nowrap; 
        }


        .add-residents-button:hover {
            background-color: #365486;
            transform: scale(1.1);
        }



.print-resident {
    padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s
}

.print-resident:hover {
    background-color: #365486;
    transform: scale(1.1);
}

#searchForm #search_value {
    height: 23px;
    font-size: 15px;
    color: black;
}

#searchForm {
width: 100%;
display: flex;
height: 30px;
}

.viewall {
    padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s
}

.viewall:hover {
    background-color: #365486;
    transform: scale(1.1);
}

.now {
    padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s
}

.now:hover{
    background-color: #365486;
    transform: scale(1.1);
}


.archive {
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

.archive:hover{
    background-color: #365486;
    transform: scale(1.1);
}


.updateButton {
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

.deletebutton{
    background-color: #FF0000;
    border: 2px solid #FF0000;
    width: 70px;
    height: 40px;
    border-radius: 10px;
    padding:5px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.deletebutton:hover{
    background-color: #FFA27F;
    border: 2px solid #FFA27F;
}

.unarchive{
    padding: 7px 24px;
    background-color: #0F044C;
    color: #EEEEEE;
    border: none;
    border-radius: 5px;
    font-size: 15px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s
}

.unarchive:hover{
    background-color: #C0D6E8;
    border: 2px solid #C0D6E8;
}

.search-div {
    width: 95%;
    display: flex;
}

#printRes{
    width: 10%;
}
#searchRes{
    width: 40%;
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


    <div class="tableCon">
    <h1>Resident List</h1> 
        <div class="search-con">
            <div class="search-div">
                <div id="searchForm">
                <form action="" method="GET" id="searchRes">
                    <input type="text" name="search_value" id="search_value" value="<?php if(isset($_GET['search_value'])){echo $_GET['search_value'];}?>">
                    <button type="submit" class="search now">Search</button>
                    <button type="button"  onclick="clearSearch()" class="viewall">View All</button>
                </form>
                <form action="" method="post" id="printRes"><input type="submit" name="printresident" id="print-resident" class="print-resident" value="Print List"></form>
                <button class="add-residents-button" id="addButton" type="button" onclick="addResident()" style="margin-left: 381px;">Add Residents</button>

                </div>
            </div>
        </div>
        <div class="table-wrapper" id="table-wrapper">
        <table>
            <thead>
            <tr>
                <th>Resident ID</th>
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
                <th>ID image</th>
                <th>Status</th>
                <th>Modified on:</th>
                <th colspan="2" class="no-print">Options</th>
            </tr>
            </thead>
            <tbody>
                    <?php 
                    $searchValue = isset($_GET['search_value']) ? $_GET['search_value'] : '';
                    if ($searchValue) {
                        $query = "SELECT * FROM `resident` WHERE `status` = 'active' AND CONCAT(`Last_name`, ' ', `Middle_name`, ' ', `First_name`) LIKE '%$searchValue%'";
                    } else {
                        $query = "SELECT `resident_id`, `Last_name`, `Middle_name`, `First_name`, `Birthday`, `Age`, `Gender`, `Civil_Status`,`Occupation`, `house_number`, `street`, `Educational_Attainment`, `Registered_Voter`,  `image`, `status`, `modified_at` FROM `resident` WHERE status = 'active';";
                    }

                    $sqlSearch = mysqli_query($connect, $query);

                    if (mysqli_num_rows($sqlSearch) > 0) {
                        foreach ($sqlSearch as $row) {
                            echo "<tr>";
                            echo "<td>" . $row["resident_id"] . "</td>";
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
                            echo "<td>" . $row["image"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>" . $row["modified_at"] . "</td>";
                            echo "<td class=\"no-print\">
                            <button type='button' class='updateButton' onclick='updateResident(
                                " . $row['resident_id'] . ",
                                \"" . $row['Last_name'] . "\",
                                \"" . $row['Middle_name'] . "\",
                                \"" . $row['First_name'] . "\",
                                \"" . $row['Birthday'] . "\",
                                " . $row['Age'] . ",
                                \"" . $row['Gender'] . "\",
                                \"" . $row['Civil_Status'] . "\",
                                \"" . $row['Occupation'] . "\",
                                \"" . $row['house_number'] . "\",
                                \"" . $row['street'] . "\",
                                \"" . $row['Educational_Attainment'] . "\",
                                \"" . $row['Registered_Voter'] . "\",
                                \"" . $row['image'] . "\"
                            )'>Update</button>
                        </td>";
                            echo "<td class=\"no-print\"><a href=\"residents.php?id=" . $row['resident_id'] . "\" class=\"archive\" name=\"archiveButton\"><img src=\"./assets/archive.svg\" height=\"28\"></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo "<td colspan='16' >No records found</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
       
    </div>

    <script>
        function clearSearch() {
            document.getElementById('search_value').value = '';
            document.getElementById('searchForm').submit();
        }
    </script>
</body>
</html>
