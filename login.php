<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<?php

session_start();
include "dbconnect.php";
include "menu.php";

if($_POST["loginbtn"]) {
	$usrnme = $_POST['email']; //using email as usrname
	$pwd = $_POST['pwd'];
	$utype = $_POST["utype"];
	
	//hash password, encript the password ($pwd) using hash function with sha256 encription
	$enpwd = hash('sha256',$pwd); 

if($utype=="1")//in case of staff
		$sql = "SELECT stfid as id, passwd, fnme as fnme, lnme as lnme 
				FROM staffs 
				WHERE email = '$usrnme' AND (passwd = '$enpwd' OR passwd = '$pwd')";
	else if($utype=="2")//in case of staff
		$sql = "SELECT docid as id, passwd, fnme as fnme, lnme as lnme 
				FROM doctors 
				WHERE email = '$usrnme' AND (passwd = '$enpwd' OR passwd = '$pwd')";
	else if ($utype=="3")//in case of patient
		$sql = "SELECT ptid as id, passwd, ptnme as fnme, ptsnme as lnme 
				FROM patients 
				WHERE email = '$usrnme' AND (passwd = '$enpwd' OR passwd = '$pwd')";
				
	$result = mysqli_query($conn, $sql);
		
	if(!$result) {
			//echo "เกิดข้อผิดพลาด กรุณาลองใหม่";
			echo "<script>alert('เกิดข้อผิดพลาด กรุณาลองใหม่');</script>";
	}
	else {
			if(mysqli_num_rows($result) == 1) {   
				$row = mysqli_fetch_array($result);
				//set all session values, could be more if necessary (can use object instead of array)
				$_SESSION['valid_id'] = $row["id"]; 
				$_SESSION['valid_fnme'] = $row["fnme"]; 
				$_SESSION['valid_lnme'] = $row["lnme"]; 
				$_SESSION['valid_utype'] = $utype; 
				header("location: menu.php"); //set location to page menu.php
			}
			else {
				//echo "ท่านกำหนด Login หรือ Password ไม่ถูกต้อง";
				echo "<script>alert('ท่านกำหนด Login หรือ Password ไม่ถูกต้อง');</script>";
			}
	}	
	mysqli_close($conn);
}

?>

<body>
<div class="container">
  <h2>Login Form</h2>
  <form action="login.php" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required> <!-- "required" means this field is required-->
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
    </div>
	<label for="tp">User Type:</label>
	<div class="form-group form-check" id="tp">
      <label class="form-check-label">
				<input type="radio" name="utype" value="1" checked>Staff
				<input type="radio" name="utype" value="2">Doctor
				<input type="radio" name="utype" value="3">Patient
      </label>
    </div>
    <input type="submit" class="btn btn-primary" name="loginbtn" value="Submit">
  </form>
</div>
<br>
</body>
</html>