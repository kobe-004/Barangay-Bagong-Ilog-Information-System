<?php
function check_login ($connect){
    if (isset ($_SESSION['user_email'])){
        $email = $_SESSION['user_email'];
        $query = "SELECT * FROM resident WHERE Email = '$email' limit 1";
        $result = mysqli_query($connect,$query);
        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    } else {
        header("location: login.php");
        die;
    }
}
?>