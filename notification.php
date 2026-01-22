<?php 
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($connect);
$lname = $user_data['Last_name'];
$mname = $user_data['Middle_name'];
$fname = $user_data['First_name'];

$sql = "SELECT * FROM pending_documents WHERE full_name = '{$fname} {$mname} {$lname}'";
$result = $connect->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
            padding: 55px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        
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

        h1 {
            color: white;
            text-align: center;
        }

        table {
            color: white;
            overflow-y: auto;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            border: 1px solid white;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="">
    <a href="homepageinside.php" class="back-button">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0L1.5 8.293l3.646 3.646a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146a.5.5 0 0 0 0-.708z"/>
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"/>
            </svg>
            Back
        </a>
        <h1>Documents</h1>
        <table>
            <thead>
            </thead>
            <tbody>
            <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>Your Request Document ' . htmlspecialchars($row['document_type']) . ' is ' . htmlspecialchars($row['status']) . ' submitted at ' . htmlspecialchars($row['created_at']) . '</td>'; // Display requested document
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="2">No pending documents found for your full name.</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
