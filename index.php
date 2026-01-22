<?php include'connection.php';?>
<?php 
$totalResidents = "SELECT * FROM `resident`";
$display = mysqli_query($connect, $totalResidents);
$totalRes = mysqli_num_rows($display);

$totalMale = "SELECT * FROM `resident` WHERE `Gender`= 'male'";
$display = mysqli_query($connect, $totalMale);
$totalM = mysqli_num_rows($display);

$totalFmale = "SELECT * FROM `resident` WHERE `Gender`= 'female'";
$display = mysqli_query($connect, $totalFmale);
$totalF = mysqli_num_rows($display);

$totalRegistered = "SELECT * FROM `resident` WHERE `Registered_Voter`= 'yes'";
$display = mysqli_query($connect, $totalRegistered);
$totalR = mysqli_num_rows($display);

$totalNregistered = "SELECT * FROM `resident` WHERE `Registered_Voter`= 'no'";
$display = mysqli_query($connect, $totalNregistered);
$totalN = mysqli_num_rows($display);

$totalPending = "SELECT * FROM `pending_documents` WHERE `status`= 'Pending'";
$display = mysqli_query($connect, $totalPending);
$totalN = mysqli_num_rows($display);

$totalPending1 = "SELECT * FROM `pending_account` WHERE `status`= 'Pending'";
$display = mysqli_query($connect, $totalPending1);
$totalm = mysqli_num_rows($display);

$totalPendingFinal = $totalm + $totalN;

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

    <div class="container-dashboard">
    <h1>DASHBOARD</h1>
        <div class="records-div">
            <div class="records">
                <h3><i class="fas fa-users"></i> Total Users</h3></h3>
                <hr class="hr">
                <h4><?php echo $totalRes; ?></h4>
            </div>
            <div class="records1">
                <h3><i class="fas fa-male"></i> Male</h3>
                <hr class="hr">
                <h4><?php echo $totalM; ?></h4>
            </div>
            <div class="records2"> 
                <h3><i class="fas fa-female"></i> Female</h3>
                <hr class="hr">
                <h4><?php echo $totalF; ?></h4>
            </div>
            <div class="records3">
                <h3><i class="fas fa-times-circle"></i> Non Registered Voters</h3>
                <hr class="hr">
                <h4><?php echo $totalN; ?></h4>
            </div>
            <div class="records4">
                <h3><i class="fas fa-vote-yea"></i> Registered Voters</h3>
                <hr class="hr">
                <h4><?php echo $totalR; ?></h4>
            </div>
            <div class="records5">
                <h3><i class="fas fa-receipt"></i> Requests</h3>
                <hr class="hr">
                <h4><?php echo $totalPendingFinal; ?></h4>
            </div>
            
        </div> 
    </div>

</body>
