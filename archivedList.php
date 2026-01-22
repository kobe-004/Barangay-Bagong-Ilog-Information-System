<?php include 'connection.php'; ?>
<?php include 'printarchived.php'; ?>
<?php include 'delete.php'; ?>
<?php 
// Check if the connection is successful
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to update the status of a resident and log the action in the audit trail
function updateResidentStatus($connect, $resident_id, $status) {
    // Begin transaction
    $connect->begin_transaction();

    try {
        // Update resident status
        $sql = "UPDATE resident SET status = ? WHERE resident_id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("si", $status, $resident_id);
        $stmt->execute();

        // Log action in the audit trail
        $action_type = 'UPDATE';
        $table_name = 'resident';
        $record_id = $resident_id;
        $admin_id = 1; // Assuming admin ID is stored in session
        $old_values = null; // No old values for resident status update
        $new_values = json_encode(['status' => $status]); // New status
        $action_timestamp = date('Y-m-d H:i:s');

        $stmt = $connect->prepare("INSERT INTO audit_trail (action_type, table_name, record_id, admin_id, old_values, new_values, action_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiisss", $action_type, $table_name, $record_id, $admin_id, $old_values, $new_values, $action_timestamp);
        $stmt->execute();

        // Commit transaction
        $connect->commit();

        echo "Resident status updated successfully.";
    } catch (Exception $e) {
        // Rollback transaction if an error occurred
        $connect->rollback();

        // Handle the error (e.g., display an error message)
        echo "Error updating resident status: " . $e->getMessage();
    }

    $stmt->close();
}

// Check if a resident ID is provided for updating status to 'active'
if (isset($_GET['ID'])) {
    $resident_id = intval($_GET['ID']);
    updateResidentStatus($connect, $resident_id, 'active');
} else {
    echo "Invalid request. No resident ID provided.";
}

// Close the database connection only once at the end of the script
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

/* #print-archived{
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
    background-color: #0F044C;
    border: 2px solid #0F044C;
    width: 70px;
    height: 40px;
    border-radius: 10px;
    padding:5px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.deletebutton:hover{
    background-color: #365486;
    transform: scale(1.1);
}

.unarchive{
    background-color: #0F044C;
    border: 2px solid #0F044C;
    width: 65px;
    height: 25px;
    border-radius: 10px;
    padding:5px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.unarchive:hover{
    background-color: #365486;
    transform: scale(1.1);
}
.search-div {
    display: flex;
    gap:5px;
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
    <h1>Archived Resident List</h1>
        <div class="search-con">
            <div class="search-div">
                <div id="searchForm">
                <form action="" method="GET" id="">
                    <input type="text" name="search_value" id="search_value" value="<?php if(isset($_GET['search_value'])){echo $_GET['search_value'];}?>">
                    <button type="submit" class="search now">Search</button>
                    <button type="button"  onclick="clearSearch()" class="viewall">View All</button>
                </form>
                </div>
                <form action="" method="post"><input type="submit" name="printarchive" id="print-archived" value="Print List"></form>
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
                    $query = "SELECT * FROM `resident` WHERE `status` = 'inactive' AND CONCAT(`Last_name`, ' ', `Middle_name`, ' ', `First_name`) LIKE '%$searchValue%'";
                } else {
                    $query = "SELECT `resident_id`, `Last_name`, `Middle_name`, `First_name`, `Birthday`, `Age`, `Gender`, `Civil_Status`, `Occupation`, `Educational_Attainment`, `Registered_Voter`, `image`, `status`, `modified_at` FROM `resident` WHERE status = 'inactive';";
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
                        echo "<td>" . $row["Educational_Attainment"] . "</td>";
                        echo "<td>" . $row["Registered_Voter"] . "</td>";
                        echo "<td>" . $row["image"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["modified_at"] . "</td>";
                        echo "<td class=\"no-print\"><a alt=\"UNARCHIVED\" class=\"unarchive\" href=\"archivedList.php?ID=" . $row['resident_id'] . "\" class=\"btn btn-primary\" name=\"unarchiveButton\"><img src=\"./assets/arrow-up-circle-fill.svg\" height=\"30\"></a></td>";
                        echo "<td class=\"no-print\"><button class=\"deletebutton\"onclick=\"showDeleteModal(" . $row['resident_id'] . ")\" name=\"deleteButton\"><img src=\"./assets/trash.svg\" height=\"30\"></button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='16'>No records found</td>";
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

        function showDeleteModal(residentId) {
        document.getElementById("form-section-delete").style.display = "flex";
        var deleteUrl = "delete.php?id=" + residentId;
        document.getElementById("confirmDelete").href = deleteUrl;
        }
        function cancel() {
        document.getElementById("form-section-delete").style.display = "none";
        }
    </script>
<?php 
$connect->close();
?>

</body>
</html>