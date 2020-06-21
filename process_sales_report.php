<?php
// we will only start the session with session_start() IF the session isn't started yet //
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
// including the conn.php to establish connection with database //
  include "conn.php";
?>

<?php
	if(isset($_POST['update_contact'])){
    $stmt = $db->prepare("UPDATE contact SET `contact_admin_content` = ?, `contact_status` = ?, `user_admin_id` = ? WHERE `contact_id` = ?");
    $stmt->bind_param('siii', $admin_reply, $contact_status, $admin_id, $contact_id);

    $contact_id = $_POST["contact_id"];
    $admin_reply = $_POST["admin_reply"];
    $contact_status = 1;
    // admin_id from $_SESSION
    $admin_id = $_SESSION["user_id"];

    // execute sql query and close connection
    $stmt->execute();
    $stmt->close();
    mysqli_close($db);

    echo "1";

    exit();
  }
?>
