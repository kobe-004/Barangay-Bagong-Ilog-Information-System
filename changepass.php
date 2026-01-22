<?php
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($connect);
$residentId = $user_data['resident_id'];
if (isset($_POST['submitchangepass'])) {
  $currentPassword = $_POST["currentPassword"];
  $newPassword = $_POST["newPassword"];
  $confirmPassword = $_POST["confirmPassword"];

  // Server-side validation
  if ($currentPassword === $user_data['Password']) {
      if ($newPassword === $confirmPassword) {
          // Begin transaction
          $connect->begin_transaction();

          try {
              // Prepare the SQL statement (to prevent SQL injection)
              $sql = "UPDATE resident SET `Password` = ? WHERE resident_id = ?";
              $stmt = $connect->prepare($sql);
              
              // Bind parameters
              $stmt->bind_param("si", $newPassword, $residentId);
              
              // Execute the statement
              if ($stmt->execute()) {
                  // Commit the transaction
                  $connect->commit();
                  echo "<script>window.location.href='homepageinside.php';</script>";
                  exit();
              } else {
                  throw new Exception("Error updating password: " . $stmt->error);
              }
          } catch (Exception $e) {
              // Rollback the transaction if an error occurred
              $connect->rollback();
              echo "Error: " . $e->getMessage();
          }
      } else {
          echo "New password and confirm password do not match.";
      }
  } else {
      echo "Incorrect current password. Please try again.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/changepass.css">
  <title>Change Password</title>
  <style>

    body {
      background-image: url(./assets/gradient-bg.png);
      background-attachment: fixed;
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      width: 100%;
      overflow:hidden;
    }
  </style>
</head>
<body>
<div class="password-form-container" id="passwordForm">
<a href="homepageinside.php" class="back-button">
            <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708 0L1.5 8.293l3.646 3.646a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146a.5.5 0 0 0 0-.708z"/>
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"/>
            </svg>
            Back
        </a>
    <form action="changepass.php" method="post">
    <input type="hidden" name="resident_id" value="<?php echo $user_data['resident_id']; ?>" readonly>
      <h2>Change Your Password <?php echo $user_data['resident_id']; ?></h2>
      <div class="form-group">
        <label for="currentPassword"><b>Current Password</b></label>
        <input type="password" id="currentPassword" name="currentPassword" required>
        <div class="showPass">
            <div style="display: flex;">
                <input type="checkbox" id="togglePassword">
                <label for="togglePassword" style="margin-bottom: 0; margin-top:3px;">Show Password</label>
            </div>
        </div>
      </div>
      <div class="form-group">
        <label for="newPassword"><b>New Password</b></label>
        <input type="password" id="newPassword" name="newPassword" required>
        <div class="showPass">
            <div style="display: flex;">
                <input type="checkbox" id="togglePassword1">
                <label for="togglePassword1" style="margin-bottom: 0; margin-top: 1px;">Show Password</label>
            </div>
        </div>
      </div>
      <div class="form-group">
        <label for="confirmPassword"><b>Confirm New Password</b></label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <div class="showPass">
            <div style="display: flex;">
                <input type="checkbox" id="togglePassword2">
                <label for="togglePassword2" style="margin-bottom: 0; margin-top: 1px;">Show Password</label>
            </div>
        </div>
      </div>
      <div class="form-group">
        <input class="button" type="submit" name="submitchangepass" value="Change Password">
      </div>
    </form>
  </div>


  <script>
    const togglePassword = (toggleCheckboxId, passwordFieldId) => {
      document.getElementById(toggleCheckboxId).addEventListener('change', function() {
        const passwordField = document.getElementById(passwordFieldId);
        passwordField.type = this.checked ? 'text' : 'password';
      });
    };

    togglePassword('togglePassword', 'currentPassword');
    togglePassword('togglePassword1', 'newPassword');
    togglePassword('togglePassword2', 'confirmPassword');
  </script>
</body>
</html>
