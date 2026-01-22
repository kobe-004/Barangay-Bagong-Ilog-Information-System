<?php
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($connect);

if (isset($_POST['submitBarangayclearance'])) {
    $email_user = $_POST['email_user'];
    $fullname_user = $_POST['full_name_user'];
    $purpose = $_POST['purpose_for_application'];
    $address_user = $_POST['address'];
    $type = "Barangay Clearance";
    try {
        // Start transaction
        $connect->begin_transaction();
        
        // Insert into pending_documents table
        $stmt = $connect->prepare("INSERT INTO pending_documents (full_name, document_type, address, reason_for_application, email_user) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullname_user, $type, $address_user, $purpose, $email_user);
        $stmt->execute();
        
        // Commit transaction
        $connect->commit();
        
        echo "<script>window.location.href='homepageinside.php?form_submitted=true';</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $connect->rollback();
        echo "Failed to add: " . $e->getMessage();
    }
}
if (isset($_POST['submitBusinessclearance'])) {
    $email_user = $_POST['email_user'];
    $fullname_user = $_POST['owner_name_user'];
    $business_address = $_POST['business_address'];
    $business_name = $_POST['business_name_user'];
    $type = "Business Clearance";
    try {
        // Start transaction
        $connect->begin_transaction();
        
        // Insert into pending_documents table
        $stmt = $connect->prepare("INSERT INTO pending_documents (full_name, document_type, business_location, business_name, email_user) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullname_user, $type, $business_address, $business_name, $email_user);
        $stmt->execute();
        
        // Commit transaction
        $connect->commit();
        
        echo "<script>window.location.href='homepageinside.php?form_submitted=true';</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $connect->rollback();
        echo "Failed to add: " . $e->getMessage();
    }
}
if (isset($_POST['submitIndigency'])) {
    $email_user = $_POST['email_user'];
    $fullname_user = $_POST['fullName'];
    $name_user = $_POST['name_user'];
    $purpose = $_POST['purpose_for_application'];
    $address_user = $_POST['address_user'];
    $type = "Barangay Indigency";

    try {
        // Start transaction
        $connect->begin_transaction();
        
        // Insert into pending_documents table
        $stmt = $connect->prepare("INSERT INTO pending_documents (full_name, document_type, reason_for_application, address, email_user, requester_name) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullname_user, $type, $purpose, $address_user, $email_user, $name_user);
        $stmt->execute();
        
        // Commit transaction
        $connect->commit();
        
        echo "<script>window.location.href='homepageinside.php?form_submitted=true';</script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $connect->rollback();
        echo "Failed to add: " . $e->getMessage();
    }
}

// Close connection
$connect->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay BGI</title>
    <link rel="stylesheet" href="./css/homepageinside.css">
    <style>/* General Reset */
* {
    margin: 0;
    padding: 0;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}

body {
    background-image: url(./assets/gradient-bg.png);
    background-position: center;
    background-size: cover;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 0;
    box-sizing: border-box;
}
.button {
    width: 180px;
    background-color: black;
    color: white;
    padding: 12px 15px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    animation: lightUp 1.5s infinite alternate;
}

.button:hover {
    background-color: red;
}


.button#backButton:hover {
    background-color: #5a6268;
}
/* Add media query for screens with a maximum width of 702px */
@media only screen and (max-width: 707px) {
    body {
      
        height: auto; /* Reset height to auto */
        overflow-y: auto; /* Enable vertical scrolling */
    }

    /* Hide the scrollbar but keep it functional */
    body::-webkit-scrollbar {
        width: 0; /* Hide scrollbar width */
        height: 0; /* Hide scrollbar height */
    }

    .logo-container {
        margin-left: 8px; /* Adjust margin for logo container */
    }

    .navbar h1 {
        font-size: 16px; /* Decrease font size for navbar heading */
    }

    nav ul li {
        margin-left: 10px; /* Adjust margin for navbar items */
    }
    .add-barangay-clearance-modal {
        margin-right: 30px;
    }
    .add-business-clearance-modal {
        margin-right: 30px;
    }
    .form {
        margin-top: 49px;
    }
    .container {
        width: 80%;   
        margin-top: 80px;
        margin-bottom: 50px;
    }

    h1 {
        font-size: 40px; /* Decrease font size for headings */
    }

    p {
        font-size: 18px; /* Decrease font size for paragraphs */
    }

    .button-container {
        flex-direction: column; /* Change button layout to column for smaller screens */
        gap: 10px; /* Adjust gap between buttons */
    }

    .cards-container {
        flex-wrap: wrap; /* Allow cards to wrap on smaller screens */
        margin-top: 10px; /* Adjust margin for cards container */
    }

    .card {
        width: calc(50% - 20px); /* Make cards take 50% width with spacing between */
        margin: 10px; 
    }

    .card img {
        width: 80px; 
    }

    #barangay-clearance,
    #add-business-clearance,
    #indigencyForm {
        top: 0; 
    }

    .add-barangay-clearance-modal,
    .add-business-clearance-modal,
    .form {
        width: 90%; 
        margin-left: 5%; 
    }

    #card-title {
    color: white;
    font-size: 15px;
    margin-top: 25px;
    margin-bottom: 0;
}

.dropdown {
    position: relative;
    display: inline-block;
    margin-right: 10px;
    width: 100px;
}

#barangay-clearance {
        top: 0;
    }

    .add-barangay-clearance-modal {
        width: 70%;
        margin-left: 5%;
    }

    .add-barangay-clearance-modal label {
        font-size: 12px; /* Decrease font size for labels */
    }

    .add-barangay-clearance-modal input[type="text"] {
        width: calc(100% - 20px);
        padding: 6px; /* Decrease padding for text inputs */
        font-size: 12px; /* Decrease font size for text inputs */
    }

    .add-barangay-clearance-modal button[type="submit"],
    .add-barangay-clearance-modal button[type="button"] {
        width: calc(50% - 5px);
        padding: 6px; /* Decrease padding for buttons */
        font-size: 12px; /* Decrease font size for buttons */
        margin-top: 20px; /* Adjust margin for buttons */
    }

    /* Business Clearance Form */
    #add-business-clearance {
        top: 0;
    }

    .add-business-clearance-modal {
        width: 70%;
        margin-left: 5%;
    }

    .add-business-clearance-modal label {
        font-size: 12px; /* Decrease font size for labels */
    }

    .add-business-clearance-modal input[type="text"] {
        width: calc(100% - 20px);
        padding: 6px; /* Decrease padding for text inputs */
        font-size: 12px; /* Decrease font size for text inputs */
    }

    .add-business-clearance-modal button[type="submit"],
    .add-business-clearance-modal button[type="button"] {
        width: calc(50% - 5px);
        padding: 6px; /* Decrease padding for buttons */
        font-size: 12px; /* Decrease font size for buttons */
        margin-top: 20px; /* Adjust margin for buttons */
    }

    /* Indigency Form */
    #indigencyForm {
        top: 0;
    }

    .form {
        width: 70%;
        margin-left: 5%;
    }

    .form label {
        font-size: 12px; /* Decrease font size for labels */
    }

    .form input[type="text"] {
        width: calc(100% - 20px);
        padding: 6px; /* Decrease padding for text inputs */
        font-size: 12px; /* Decrease font size for text inputs */
    }

    .form button[type="submit"],
    .form button[type="button"] {
        width: calc(50% - 5px);
        padding: 6px; /* Decrease padding for buttons */
        font-size: 12px; /* Decrease font size for buttons */
        margin-top: 20px; /* Adjust margin for buttons */
    }
}


</style>
</head>
<body style="background">
    <div class="navbar">
        <div class="logo-container">
            <img src="./assets/bgi logo.png" class="logo" alt="Logo">
            <h1>BARANGAY BAGONG ILOG</h1>
        </div>
        <nav>
            <ul>
                <li class="dropdown">
                    <a href="#"><img src="./assets/settings.png" alt="Settings"></a>
                    <div class="dropdown-content">
                        <a href="updateprofile.php">Update Profile</a>
                        <a href="notification.php">Notification</a>
                        <a href="changepass.php">Change Password</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

        <div class="container">
            <h1>Welcome,</h1>
            <p><?php echo $user_data['First_name']; ?>!</p>
            <button type="button" class="button" onclick="location.href='userprofile.php'">View Profile</button><br> 
            <button type="button" class="button" onclick="location.href='householdprof.php'">Household Profile</button>
            <p id="card-title"><b>ONLINE REQUEST FORMS</b></p>
            <div class="cards-container">
            <div class="card" onclick="openBarangayClearance()">
                <img src="./assets/clearance.png" alt="Barangay Clearance">
                <h5>Barangay Clearance</h5>
            </div>
                <div class="card" onclick="openBusinessClearance()">
                    <img src="./assets/business.png" alt="Business Clearance">
                    <h5>Business Clearance</h5>
                </div>
                <div class="card" onclick="openIndigencyForm()">
                    <img src="./assets/finalcertificate.png" alt="Certificate of Indigency">
                    <h5>Certificate of Indigency</h5>
                </div>
            </div>
        </div>
        <section id="barangay-clearance">
            <div class="add-barangay-clearance-modal">
                <h5>Barangay Clearance</h5>
                <form action="homepageinside.php" method="POST" class="form-content">
                    <label for="full_name">Complete Name:</label><br>
                    <input type="hidden" name="email_user" value="<?php echo $user_data['Email']; ?>">
                    <input type="text" name="full_name_user" id="full_name" value="<?php echo $user_data['First_name'] . ' ' . $user_data['Middle_name'] . ' ' . $user_data['Last_name']; ?>" readonly><br>
                    <label for="purpose_for_application">Purpose for Application:</label><br>
                    <input type="text" name="purpose_for_application" id="purpose_for_application" required><br>
                    <label for="address">Address:</label><br>
                    <input type="text" name="address" id="address" value="<?php echo $user_data['house_number'] . ' ' . $user_data['street'];?> " readonly><br>
                    <input type="submit" name="submitBarangayclearance" class="button">
                    <button type="button" onclick="closeBarangayClearance()">Close</button>

                </form>
            </div>
        </section>
    <!-- Business Clearance Popup Form -->
    <section id="add-business-clearance">
        <div class="add-business-clearance-modal">
            <h5>Business Clearance Form</h5>
            <form action="" method="post" class="form-content">
                <input type="hidden" name="email_user" value="<?php echo $user_data['Email']; ?>">
                <label for="business-name">Business Name:</label><br>
                <input type="text" id="business-name" name="business_name_user" required><br>
                <label for="business-type">Business Address:</label><br>
                <input type="text" id="business-type" name="business_address" required><br>
                <label for="owner-name">Owner Name:</label><br>
                <input type="text" id="owner-name" name="owner_name_user" value="<?php echo $user_data['First_name'] . ' ' . $user_data['Middle_name'] . ' ' . $user_data['Last_name']; ?>" readonly><br>
                <input class="button" type="submit" name="submitBusinessclearance"><br><br>
                <button class="button" type="submit"  onclick="closeBusinessClearance()">Close</button>
            </form>
        </div>
    </section>

    <!-- Indigency Popup Form -->
    <section id="indigencyForm" style="display: none;">
        <div class="form">
            <div class="form-content">
                <h5>Certificate of Indigency</h5>
                <form action="homepageinside.php" method="POST">
                    <input type="hidden" name="email_user" value="<?php echo $user_data['Email']; ?>">
                    <label for="full_name">Complete Name:</label><br>
                    <input type="text" name="fullName" id="full_name" value="<?php echo $user_data['First_name'] . ' ' . $user_data['Middle_name'] . ' ' . $user_data['Last_name']; ?>"><br>
                    <label for="requirement">Request of (Full name):</label><br>
                    <input type="text" name="name_user" id="requirement" required><br>
                    <label for="purpose_for_application">Purpose for Application:</label><br>
                    <input type="text" name="purpose_for_application" id="purpose_for_application" required><br>
                    <label for="address">Address:</label><br>
                    <input type="text" name="address_user" id="address" value="<?php echo $user_data['house_number'] . ' ' . $user_data['street'];?>" readonly><br>
                    <input type="submit" class="button" name="submitIndigency"><br><br>
                    <button type="button" onclick="closeIndigencyForm()">Close</button>
                </form>
            </div>
        </div>
    </section>
    <div class="notification" id="notification">
        Form submitted successfully! Waiting for email confirmation for pickup
    </div>
    <script>
    function openBusinessClearance() {
        document.getElementById("add-business-clearance").style.display = "flex";
        document.querySelector('.modal-overlay').classList.add('active');
        document.body.classList.add('disable-pointer');
    }

    function closeBusinessClearance() {
        document.getElementById("add-business-clearance").style.display = "none";
        document.querySelector('.modal-overlay').classList.remove('active');
        document.body.classList.remove('disable-pointer');
    }

    function openIndigencyForm() {
        document.getElementById("indigencyForm").style.display = "flex";
        document.querySelector('.modal-overlay').classList.add('active');
        document.body.classList.add('disable-pointer');
    }
    
    function closeIndigencyForm() {
        document.getElementById("indigencyForm").style.display = "none";
        document.querySelector('.modal-overlay').classList.remove('active');
        document.body.classList.remove('disable-pointer');
    }

    function openBarangayClearance() {
        document.getElementById("barangay-clearance").style.display = "flex";
        document.querySelector('.modal-overlay').classList.add('active');
        document.body.classList.add('disable-pointer');
    }

    function closeBarangayClearance() {
        document.getElementById("barangay-clearance").style.display = "none";
        document.querySelector('.modal-overlay').classList.remove('active');
        document.body.classList.remove('disable-pointer');
    }
    // Function to show notification
function showNotification() {
    var notification = document.getElementById('notification');
    notification.style.display = 'block';

    // Hide notification after 5 seconds
    setTimeout(function() {
        notification.style.display = 'none';
    }, 5000); // 5000 milliseconds = 5 seconds (adjust as needed)
}

// Function to check URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Show notification if form was submitted
window.onload = function() {
    if (getUrlParameter('form_submitted') === 'true') {
        showNotification();
    }
}


</script>

</body>
</html>
