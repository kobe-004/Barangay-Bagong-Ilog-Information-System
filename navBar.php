<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk:ital,wght@0,400..700;1,400..700&family=Kanit:ital,wght@0,400;1,800&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Slab:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Barangay Information System</title>
</head>
<body>
    <div class="header">
        <div class="title">
            <img src="./assets/bgi logo.png" height="55"alt="">
            <h2 class="heading">ADMIN</h2>     
        </div>

        <div class="outer-a-container">
            <a href="" class="outer-a">
                <img src="./assets/set-up-svgrepo-com (2).svg" height="50">
            </a>
            <ul class="dropdown">
                <li><a href="officials.php" class="inner-a">Barangay Officials</a></li>
                <li><a href="hotline.php" class="inner-a">Change Hotline</a></li>
                <li><a href="events.php" class="inner-a">Change Events</a></li>
                <li><a href="announce.php" class="inner-a">Change Announcements</a></li>
            </ul>
        </div>
    </div>    
    <div class="nav">
       
        <div class="nav-con">
            <div class="options">
      
                <a href="./index.php" class="outer-a">Dashboard</a>
            </div>
    
            <div class="options users">

                <a href="" class="outer-a">Users
                <ul>
                    <li><a href="residents.php" class="inner-a">Resident List</a></li>
                    <li><a href="archivedList.php" class="inner-a">Archived Resident List</a></li>
                    <li><a href="household.php" class="inner-a">House Hold List</a></li>
                </ul>
                </a>
            </div>
    
            <div class="options
            pendings">
                
                <a href="" class="outer-a">Pending
                <ul>
                    <li><a href="./pendingAcc.php" class="inner-a">Pending Accounts</a></li>
                    <li><a href="./pendingRequest.php" class="inner-a">Pending Requests</a></li>
                </ul>
                </a>
            </div>
            <div class="options">
                <a href="audit.php" class="outer-a">Check Activities</a>
            </div>

            <div class="options">
            <a href="homepage.php" class="outer-a">Log out</a>
            </div>

        </div>

    </div>
    <div class="footer">
        <h3 class="footing">@2024 All Rights Reserved</h3>
    </div>
</body>
</html>