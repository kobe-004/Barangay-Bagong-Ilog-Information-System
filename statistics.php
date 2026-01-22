<?php 
include 'connection.php';
// Fetch data from the database
$sql = "SELECT statistic, content FROM statistics";
$result = $connect->query($sql);

$statistics = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statistics[$row['statistic']] = $row['content'];
    }
} else {
    echo "0 results";
}

// Process form submission
if (isset($_POST['updateStatistics'])) {
    // Prepare SQL update statements based on form fields
    $updates = [];
    
    // Escape input to prevent SQL injection
    function escape($value) {
        global $connect;
        return $connect->real_escape_string($value);
    }

    if (isset($_POST['cityName'])) {
        $cityName = escape($_POST['cityName']);
        $updates[] = "UPDATE statistics SET content = '$cityName' WHERE statistic = 'City Name'";
    }

    if (isset($_POST['congressionalDistrict'])) {
        $congressionalDistrict = escape($_POST['congressionalDistrict']);
        $updates[] = "UPDATE statistics SET content = '$congressionalDistrict' WHERE statistic = 'Congressional District'";
    }

    if (isset($_POST['legalBasis'])) {
        $legalBasis = escape($_POST['legalBasis']);
        $updates[] = "UPDATE statistics SET content = '$legalBasis' WHERE statistic = 'Legal Basis of Creation'";
    }

    if (isset($_POST['landArea'])) {
        $landArea = escape($_POST['landArea']);
        $updates[] = "UPDATE statistics SET content = '$landArea' WHERE statistic = 'Land Area'";
    }

    if (isset($_POST['totalPopulation'])) {
        $totalPopulation = escape($_POST['totalPopulation']);
        $updates[] = "UPDATE statistics SET content = '$totalPopulation' WHERE statistic = 'Total Population'";
    }

    if (isset($_POST['numberHouseholds'])) {
        $numberHouseholds = escape($_POST['numberHouseholds']);
        $updates[] = "UPDATE statistics SET content = '$numberHouseholds' WHERE statistic = 'Number of Households'";
    }

    if (isset($_POST['numberFamilies'])) {
        $numberFamilies = escape($_POST['numberFamilies']);
        $updates[] = "UPDATE statistics SET content = '$numberFamilies' WHERE statistic = 'Number of Families'";
    }

    if (isset($_POST['registeredVoters'])) {
        $registeredVoters = escape($_POST['registeredVoters']);
        $updates[] = "UPDATE statistics SET content = '$registeredVoters' WHERE statistic = 'Total Registered Voters'";
    }

    if (isset($_POST['numberPrecincts'])) {
        $numberPrecincts = escape($_POST['numberPrecincts']);
        $updates[] = "UPDATE statistics SET content = '$numberPrecincts' WHERE statistic = 'Number of Precincts'";
    }

    // Execute all update queries
    foreach ($updates as $update) {
        if (!$connect->query($update)) {
            echo "Error updating record: " . $connect->error;
        }
    }

    // Redirect to the same page after update (optional)
    header("Location: {$_SERVER['PHP_SELF']}?insert_msg=The data has been updated successfully!");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        .container-dashboard {
            width: 85%;
            height: 76vh;
            position: fixed;
            right: 0%;
            top: 9%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        h1 {
            color: #0F044C;
            grid-column: span 2;
            font-size: 2.5rem;
            margin: 25px 0px 30px 35px;
            text-align: center;
        }

        h3 {
            font-size: 6%;
            
        }

        h4 {
            font-size: 3rem;
            margin-top: 20px;
            text-align: center;
        }
        #logout {
            margin-bottom: 50px;
        }

        .records-div {
            width: 87%;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            place-items: center;
            column-gap: 130px;
            row-gap: 30px;
            margin-left: 216px;
            margin-top: 5px;
            color: white;
        }

        .records, .records1, .records2, .records3, .records4, .records5 {
            
            background-size: cover;
            background-position: center;
            width: 160%;
            height: 33vh;
            border-radius: 30px;
            color: white;
            position: relative;
        }
      

        .records::before, .records1::before, .records2::before, .records3::before, .records4::before, .records5::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
         
            border-radius: 30px;
            color: white;
        }
.records {background-color: #0f0f0f;
        }
.records1 { background-color: rgb(26, 18, 83); }
.records2 { background-color: rgb(13, 150, 165); }
.records3 { background-color: rgb(26, 112, 121); }
.records4 { background-color: rgb(16, 11, 53); }
.records5 { background-color: rgba(15, 15, 15, 0.67); }

.records h3, .records1 h3, .records2 h3, .records3 h3, .records4 h3, .records5 h3 {
    margin: 20px 20px 30px 30px;
    padding-top: 10px;
    color: white ; /* Ensure color is white */
    font-size: 18px;
  
}

.records:hover {background-color: #0f0f0f; transform: scale(1.1);}
.records1:hover { background-color: rgb(26, 18, 83); transform: scale(1.1);}
.records2:hover { background-color: rgb(13, 150, 165); transform: scale(1.1); }
.records3:hover { background-color: rgb(26, 112, 121); transform: scale(1.1); }
.records4:hover { background-color: rgb(16, 11, 53); transform: scale(1.1);}
.records5:hover { background-color: rgba(15, 15, 15, 0.67); transform: scale(1.1); }
        .info-container {
            width: 81%;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 70px;
            position: fixed;
            right: 1%;
        }
        .info-section {
            width: calc(33.33% - 20px); /* Three columns with margin */
            margin: 10px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #EEEEEE; /* 91% opacity */
            border-radius: 20px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.5);
        }
        .info-section h3 {
            font-size: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .info-section i {
            margin-right: 10px;
            font-size: 24px;
        }
        .info-section form {
            display: flex;
            flex-direction: column;
        }
        .info-section label {
            font-size: 12px;
            margin-bottom: 5px;
            margin-left: 10px;
        }
        .info-section input {
            width: calc(100% - 40px);
            padding: 8px;
            margin-bottom: 10px;
            border: 2px solid #0F044C;
            border-radius: 10px;
            background-color: transparent;
            color: black;
            transition: border-color 0.3s ease;
            margin-left: 10px;
        }
        .info-section input[type="submit"] {
            padding: 7px 24px;
            background-color: #0F044C;
            color: #EEEEEE;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            width: 92%;
        }
        .info-section input[type="submit"]:hover {
            background-color: #365486;
            transform: scale(1.1);
        }
        .info-section form {
            display: flex;
            justify-content: center;
        }
        .info-container h1 {
            width: 80%;
        }
        .inner-info{
            display: flex;
            width: 90%;
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
            <a href="index.php" class="outer-a"><i class="fas fa-tachometer-alt" style="margin-right: 5px;"></i>Dashboard</a>
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
    
    <div class="info-container">
        <h1>Statistics</h1>
        <div class="inner-info">
        <div class="info-section">
            <h3><i class="fas fa-info-circle"></i> City Information</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="cityName">City Name</label>
                <input type="text" id="cityName" name="cityName" value="<?php echo isset($statistics['City Name']) ? htmlspecialchars($statistics['City Name']) : ''; ?>">
                <label for="congressionalDistrict">Congressional District</label>
                <input type="text" id="congressionalDistrict" name="congressionalDistrict" value="<?php echo isset($statistics['Congressional District']) ? htmlspecialchars($statistics['Congressional District']) : ''; ?>">
                <label for="legalBasis">Legal Basis of Creation</label>
                <input type="text" id="legalBasis" name="legalBasis" value="<?php echo isset($statistics['Legal Basis of Creation']) ? htmlspecialchars($statistics['Legal Basis of Creation']) : ''; ?>">
                <label for="landArea">Land Area</label>
                <input type="text" id="landArea" name="landArea" value="<?php echo isset($statistics['Land Area']) ? htmlspecialchars($statistics['Land Area']) : ''; ?>">
                <input type="submit" name="updateStatistics" value="Save Changes">
            </form>
        </div>
        
        <div class="info-section">
            <h3><i class="fas fa-users"></i> Demographics</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="totalPopulation">Total Population</label>
                <input type="text" id="totalPopulation" name="totalPopulation" value="<?php echo isset($statistics['Total Population']) ? htmlspecialchars($statistics['Total Population']) : ''; ?>">
                <label for="numberHouseholds">Number of Households</label>
                <input type="text" id="numberHouseholds" name="numberHouseholds" value="<?php echo isset($statistics['Number of Households']) ? htmlspecialchars($statistics['Number of Households']) : ''; ?>">
                <label for="numberFamilies">Number of Families</label>
                <input type="text" id="numberFamilies" name="numberFamilies" value="<?php echo isset($statistics['Number of Families']) ? htmlspecialchars($statistics['Number of Families']) : ''; ?>">
                <input type="submit" name="updateStatistics" value="Save Changes">
            </form>
        </div>
        
        <div class="info-section">
            <h3><i class="fas fa-vote-yea"></i> Registered Voters</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="registeredVoters">Total Registered Voters</label>
                <input type="text" id="registeredVoters" name="registeredVoters" value="<?php echo isset($statistics['Total Registered Voters']) ? htmlspecialchars($statistics['Total Registered Voters']) : ''; ?>">
                <label for="numberPrecincts">Number of Precincts</label>
                <input type="text" id="numberPrecincts" name="numberPrecincts" value="<?php echo isset($statistics['Number of Precincts']) ? htmlspecialchars($statistics['Number of Precincts']) : ''; ?>">
                <input type="submit" name="updateStatistics" value="Save Changes">
            </form>
        </div>
        </div>
    </div>
</body>
</html>
