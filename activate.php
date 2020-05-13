<?php

session_start(); //start session
include "dbconnect.php";//connect the database, return connection object named $conn

$ptid = $_GET["ptid"];

//field activated must be added/existed in table patients. The default value is 0, 1 means activated. 
$sql = "UPDATE patients SET activated = 1 WHERE ptid='$ptid'";

$result = mysqli_query($conn, $sql);
		
	if($result) {
            echo "<script>alert('Your acccount has been activated.');</script>";
            echo "<a href='http://172.18.111.30/user33/healthcare/'>Visit site and try</a>";
	}
	else {
				echo "<script>alert('Activation Error, try again later');</script>";
	}	
	mysqli_close($conn);

?>
