<?php
// we will only start the session with session_start() IF the session isn"t started yet //
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
// including the conn.php to establish connection with database //
  include "conn.php";
?>

<?php
	//search product from home
	if(isset($_POST['contact_admin'])){
        // $email =  $_POST['email'];
        $message = $_POST['message'];
        $username = $_POST['username'];
        $today = date('Y-m-d');
        $user_id = $_SESSION['user_id'];
        $contact_status = 0;


        //INSERT NEW MESSAGE
        $stmt1 = $db -> prepare("INSERT INTO `contact`(`contact_date`, `contact_content`, `contact_status`, `user_id`) VALUES (?,?,?,?); ");
        $stmt1 ->bind_param("ssss", $today, $message, $contact_status, $user_id);

        $stmt1->execute();
        if(mysqli_affected_rows($db)>0){
            echo "Message Sent ";
        } else {
            echo "failed";
        }
        $stmt1->close();

        mysqli_close($db);
	}










?>
