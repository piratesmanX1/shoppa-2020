<?php
$db = mysqli_connect("localhost","root","","shoppa");

// Check connection
    if(mysqli_connect_error())
    {
    echo "Failed to connect to MySQL:".mysqli_connect_error();
    }
?>
