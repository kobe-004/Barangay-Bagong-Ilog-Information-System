<?php
session_start();
        include("connection.php");
        include("function.php");
        

        $user_data = check_login($connect);
        $imagePath = 'residents/' . $user_data['image']; 
        $gender = $user_data['Gender'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    font-size: 13px;
    line-height: 1.6;
    background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
    padding: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    overflow: hidden;
}

.container {
    max-width: 1000px;
    width: 100%;
    
    box-sizing: border-box;

  
   
}

.profile {
    background-color: rgba(63, 69, 79, 0.8);
    border-radius: 15px;
    border: 2px solid white;
}

h1 {
    text-align: center;
    margin-bottom: 0;
    font-size: 25px;
    color: white;
    margin-top: 0;
}

.details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 10px;
    padding: 20px;
}

.detail {
    margin-bottom: 10px;
    
}
.detail1 span {
    padding: 10px;
    text-align: center;
}
.label {
    font-weight: bold;
    display: block;
    font-size: 18px;
    color: white;
}

.value {
    background-color: rgba(255, 255, 255, 0.1);
    padding: 8px;
    border-radius: 5px;
    display: block;
    font-size: 13px;
    color: white;
}


.detail1 img {
    width: 250px;
    height: 120px;
    background-color: transparent;
    border: 1px solid white;
   margin-left: 372px;
}
  
.back-button {
            position: absolute;
            top: 5px;
            left: 20px;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color: transparent;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
            text-decoration: none;
        }
        .back-button:hover {
            color: black;
        }
        .back-button svg {
            margin-right: 10px;
        }
</style>
</head>
<body>
    <div class="container">
    <a href="homepageinside.php" class="back-button">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0L1.5 8.293l3.646 3.646a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146a.5.5 0 0 0 0-.708z"/>
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"/>
            </svg>
            Back
        </a>
        <div class="profile">
            <h1>User Profile</h1>
                     <hr>
            <div class="detail1">
                    <span class="label">Barangay ID:</span>
                    <div class="value1">
                        <img src="<?php echo $imagePath; ?>" alt="Barangay ID">
                    </div>
                </div><hr>
            <div class="details">
            <div class="detail">
                    <span class="label">Email:</span> <span class="value"><?php echo $user_data['Email']; ?></span>
                </div>

                <div class="detail">
                    <span class="label">Last Name:</span> <span class="value"><?php echo $user_data['Last_name']; ?></span>
                </div>
                <div class="detail">
                    <span class="label">Middle Name:</span> <span class="value"><?php echo $user_data['Middle_name']; ?></span>
                </div>
                <div class="detail">
                    <span class="label">First Name:</span> <span class="value"><?php echo $user_data['First_name']; ?></span>
                </div>
                <div class="detail">
                    <span class="label">Age:</span> <span class="value"><?php echo $user_data['Age']; ?></span>re
                </div>
                <div class="detail">
                    <span class="label">Occupation:</span> <span class="value"><?php echo $user_data['Occupation']; ?></span>
                </div>
                <div class="detail">
                    <span class="label">Birthday:</span> <span class="value"><?php echo $user_data['Birthday']; ?></span>
                </div>
                <div class="detail">
                    <span class="label">Gender:</span> <span class="value"><?php echo $gender; ?></span>
                </div>
                <div class="detail">
                    <span class="label">Civil Status:</span> <span class="value"><?php echo $user_data['Civil_Status']; ?></span>
                </div>
                <div class="detail">
                    <span class="label">Registered Voter:</span> <span class="value"><?php echo $user_data['Registered_Voter']; ?></span>
                </div>
                <div class="detail">
                    <span class="label">Address:</span> <span class="value"><?php echo $user_data['house_number'] . ' ' . $user_data['street'] . ' Barangay Bagong Ilog, Pasig City';?></span>
                </div>
                <div class="detail">
                    <span class="label">Educational Attainment:</span> <span class="value"><?php echo $user_data['Educational_Attainment']; ?></span>
                </div>
      
             
              
            </div>
        </div>
    </div>
</body>
</html>
