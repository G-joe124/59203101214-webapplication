<?php

require_once("checkpermission.php");
include "menu.php";
$id = $_SESSION['valid_id'];	
$utype = $_SESSION['valid_utype'];

if($_POST["chbtn"]) {
	include "dbconnect.php";	
	$opwd = trim($_POST['opwd']); //old password
	$npwd = trim($_POST['npwd']); //new password
	$cfpwd = trim($_POST["cfpwd"]); //confirm password
	
	$enopwd = hash('sha256',$opwd); //encripted old password

	if($utype=="1")//in case of staff
		$sql = "SELECT stfid, passwd
				FROM staffs 
				WHERE stfid = '$id' AND (passwd = '$opwd' OR passwd = '$enopwd')";
	else if($utype=="2")//in case of staff
		$sql = "SELECT docid, passwd
				FROM doctors 
				WHERE docid = '$id' AND (passwd = '$opwd' OR passwd = '$enopwd')";
	else if ($utype=="3")//in case of patient
		$sql = "SELECT ptid, passwd
				FROM patients 
				WHERE ptid = '$id' AND (passwd = '$opwd' OR passwd = '$enopwd')";
				
	//$result = $conn->query($sql);
	$result = mysqli_query($conn, $sql);
	
	if(mysqli_num_rows($result) != 1) {
		//echo "invalid old password";
		echo "<script>alert('invalid old password');</script>";
	}else if($npswd != $cfpswd){
		//echo "new passwords are not matched";
		echo "<script>alert('new passwords are not matched');</script>";
	}else {
		$npwd = hash('sha256',$npwd); //encripted new password
		if($utype=="1")//
			$sql = "UPDATE staffs
					SET passwd = '$npwd' 
					WHERE stfid = '$id'";
		else if($utype=="2")//
				$sql = "UPDATE doctors
					SET passwd = '$npwd' 
					WHERE docid = '$id'";
		else if($utype=="3")//
			$sql = "UPDATE patients
					SET passwd = '$npwd' 
					WHERE ptid = '$id'";
		if(mysqli_query($conn, $sql)){
			//echo "Password was changed successful";
			echo "<script>alert('Password was changed successful'); window.location.href='index.php';</script>";
			//header("location: menu.php");			
		}
	}
	mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    table {
        border-collapse: collapse;
        border: 1px;
    }
    th, td {
        text-align: left;
        padding: 10px;
        height: 40px;
    }
    tr:nth-child(even){background-color: #f2f2f2}
    th {
        background-color: #d1d1e0;
        color: black;
    }
</style>
</head>
<body>
<center>
<h1>Change Password Form</h1>
	<form action="changePwdForm.php" method="post">
			<table>
				<tr><td><label><b>Old Password:</b></label></td><td><input type="password" name="opwd" placeholder="พาสเวิร์ดเก่า" required></td></tr>
    			<tr><td><label><b>New Password:</b></label></td><td><input type="password" name="npwd" placeholder="พาสเวิร์ดใหม่" required></td></tr>
    			<tr><td><label><b>Confirm New Password:</b></label></td><td><input type="password" name="cfpwd" placeholder="ยืนยันพาสเวิร์ดใหม่" required></td></tr>	
    			<tr><td colspan="2"><input type="submit" name="chbtn" value="Change"></td></tr>
			</table>
			<br />
	</form>
</center>
</body>
</html>
