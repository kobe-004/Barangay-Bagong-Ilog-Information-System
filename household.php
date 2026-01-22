<?php 
include 'connection.php'; 

// Retrieve the street and search value from GET parameters
$street = isset($_GET['street']) ? mysqli_real_escape_string($connect, $_GET['street']) : '';
$searchValue = isset($_GET['search_value']) ? mysqli_real_escape_string($connect, $_GET['search_value']) : '';

// SQL query for the head of the family
if ($street && $searchValue) {
    $sql = "SELECT * FROM `household` 
            WHERE `Street` = '$street' 
            AND `Head_of_family` = 'yes' 
            AND CONCAT(`Last_name`, ' ', `Middle_name`, ' ', `First_name`, ' ',`House_number`) LIKE '%$searchValue%'";
} elseif ($street) {
    $sql = "SELECT * FROM `household` 
            WHERE `Street` = '$street' 
            AND `Head_of_family` = 'yes'";
} elseif ($searchValue) {
    $sql = "SELECT * FROM `household` 
            WHERE `Head_of_family` = 'yes' 
            AND CONCAT(`Last_name`, ' ', `Middle_name`, ' ', `First_name`, ' ',`House_number`) LIKE '%$searchValue%'";
} else {
    $sql = "SELECT * FROM `household` 
            WHERE `Head_of_family` = 'yes'";
}

$result = mysqli_query($connect, $sql);

// SQL query for the streets
$sqlStreets = "SELECT street_name FROM bagong_ilog_streets ORDER BY street_name";
$resultStreets = $connect->query($sqlStreets);

$streets = [];

if ($resultStreets->num_rows > 0) {
    while($row = $resultStreets->fetch_assoc()) {
        $streets[] = $row['street_name'];
    }
} else {
    echo "0 results";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/household.css">
    <title>HouseHold</title>
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


#print-archived {
    padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s
}

#print-archived:hover {
    background-color: #365486;
    transform: scale(1.1);
}

#searchForm #search_value {
    height: 23px;
    font-size: 15px;
    color: black;
}
#searchForm{
    width: 100%;
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
    background-color: #FF204E;
    border: 2px solid #FF204E;
    width: 70px;
    height: 23px;
    border-radius: 10px;
    padding:5px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.archive:hover{
    background-color: #A34343;
    border: 2px solid #A34343;
}


.updateButton {
    background-color: #3559E0;
    border: 2px solid #3559E0;
    width: 100px;
    height: 35px;
    text-align: center;
    border-radius: 10px;
    font-size: 15px;
}

.updateButton:hover {
    background-color: #596FB7;
    border: 2px solid #596FB7;
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
    background-color: #4793AF;
    border: 2px solid #4793AF;
    width: 65px;
    height: 25px;
    border-radius: 10px;
    padding:5px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.unarchive:hover{
    background-color: #C0D6E8;
    border: 2px solid #C0D6E8;
}
.search-div {
    display: flex;
    gap:5px;
    height: 20px;
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
    <div class="household-con">
        <h1>Household</h1>
        <div id="street-con">
            <ul>
                <?php 
                foreach ($streets as $streetName) {
                    echo "<li><a href='household.php?street=$streetName'>$streetName</a></li>";
                }
                ?>
            </ul>
        </div>
        <div class="search-div">
                    <form action="" method="GET" id="searchForm">
                        <input type="hidden" name="street" value="<?php echo $street; ?>">
                        <input type="text" name="search_value" id="search_value" class="hhsearch_value" value="<?php echo $searchValue; ?>">
                        <button type="submit" class="search now" id="hhsearch">Search</button>
                        <button type="button" onclick="clearSearch()" class="search clear" id="hhcsearch">Clear Search</button>
                    </form>
                </div><br>
        <div id="household-div-table">
        <h3 class="titles">Head of the Family</h3><br>
                <div class="table-wrapper head">
                    <table class="head-table">
                        <thead>
                            <tr>
                                <th>Household ID</th>
                                <th>Last name</th>
                                <th>Middle name</th>
                                <th>First name</th>
                                <th>House number</th>
                                <th>Street</th>
                                <th>Head of family</th>
                                <th>House structure</th>
                                <th>Water supply</th>
                                <th>Residential status</th>
                                <th>Electricity</th>
                                <th>Modified at:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row["Household_ID"] . "</td>";
                                    echo "<td>" . $row["Last_name"] . "</td>";
                                    echo "<td>" . $row["Middle_name"] . "</td>";
                                    echo "<td>" . $row["First_name"] . "</td>";
                                    echo "<td>" . $row["House_number"] . "</td>";
                                    echo "<td>" . $row["Street"] . "</td>";
                                    echo "<td>" . $row["Head_of_family"] . "</td>";
                                    echo "<td>" . $row["House_structure"] . "</td>";
                                    echo "<td>" . $row["Water_supply"] . "</td>";
                                    echo "<td>" . $row["Residential_status"] . "</td>";
                                    echo "<td>" . $row["Electricity"] . "</td>";
                                    echo "<td>" . $row["modified_at"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan='12'>No records found</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <h3 class="title">Members</h3>
                <div class="table-wrapper member">
                    <table class="member-table">
                        <thead>
                            <tr>
                                <th>Household ID</th>
                                <th>Last name</th>
                                <th>Middle name</th>
                                <th>First name</th>
                                <th>Head of the Family</th>
                                <th colspan="3">Name of the head</th>
                                <th>Relation to the head</th>
                                <th>Modified at:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // SQL query for household members
                            if ($street && $searchValue) {
                                $queryMembers = "SELECT * FROM `household` 
                                                 WHERE `Street` = '$street' 
                                                 AND `Head_of_family` = 'no' 
                                                 AND CONCAT(`Head_last_name`, ' ', `Head_middle_name`, ' ', `Head_first_name`, ' ',`House_number`) LIKE '%$searchValue%'";
                            } elseif ($street) {
                                $queryMembers = "SELECT * FROM `household` 
                                                 WHERE `Street` = '$street' 
                                                 AND `Head_of_family` = 'no'";
                            } elseif ($searchValue) {
                                $queryMembers = "SELECT * FROM `household` 
                                                 WHERE `Head_of_family` = 'no' 
                                                 AND CONCAT(`Head_last_name`, ' ', `Head_middle_name`, ' ', `Head_first_name`, ' ',`House_number`) LIKE '%$searchValue%'";
                            } else {
                                $queryMembers = "SELECT * FROM `household` 
                                                 WHERE `Head_of_family` = 'no'";
                            }

                            $sqlSearchMembers = mysqli_query($connect, $queryMembers);

                            if (mysqli_num_rows($sqlSearchMembers) > 0) {
                                foreach ($sqlSearchMembers as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row["Household_ID"] . "</td>";
                                    echo "<td>" . $row["Last_name"] . "</td>";
                                    echo "<td>" . $row["Middle_name"] . "</td>";
                                    echo "<td>" . $row["First_name"] . "</td>";
                                    echo "<td>" . $row["Head_of_family"] . "</td>";
                                    echo "<td>" . $row["Head_last_name"] . "</td>";
                                    echo "<td>" . $row["Head_middle_name"] . "</td>";
                                    echo "<td>" . $row["Head_first_name"] . "</td>";
                                    echo "<td>" . $row["Relation_to_head"] . "</td>";
                                    echo "<td>" . $row["modified_at"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan='10'>No records found</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function clearSearch() {
        // Clear the search value
        document.getElementById('search_value').value = '';
        // Clear the street parameter
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.delete('street');
        urlParams.delete('search_value');
        window.location.search = urlParams.toString();
    }
</script>
</html>
