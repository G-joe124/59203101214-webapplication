<!DOCTYPE html>
<html>
<head>
<title>Edit Day Use</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
	table {
		border-collapse: collapse;
		border: 10px;
	}
	th, td {
		text-align: left;
		padding: 8px;
		height: 40px;
		border: 10px;
	}
	tr:nth-child(even){background-color: #E6E6FA}
	th {
    	background-color: #5F9EA0;
		color: white;
	}
</style>
</head>
<body>
<?php
	//check permission before doing updating
	//require_once("checkpermission.php"); //Chek login
	//add menu on the top of this insert form
	include "menu.php";
	//เชื่อมต่อฐานข้อมูลและ select ข้อมูลผู้ป่วยจากตาราง patients ตาม ptid ที่ส่งมาจากฟอร์ม
	include "dbconnect.php"; //connect the database, this returns a connection ชื่อ $conn
	$id = $_GET["id"]; //get id from login user, in case of editing data themselves
	if($id != "")
		$busno = $id;
	else 
		$busno = $_POST['busno']; //get ptid from showPatients, in case of admin/staff used
        $drvid = $_POST['drvid'];
        $dte = $_POST['dte'];
        // $timestr = $_POST['timestr'];

	$sql = "SELECT * FROM dayuse WHERE busno = '$busno' AND drvid = '$drvid' AND dte = '$dte'"; //คำสั่ง select ข้อมูลผู้ป่วยจากตาราง patients ที่มี ptid = $ptid
	$result = $conn->query($sql); //run คำสั่งคิวรีย์ โดยนำผลที่ได้มาเก็บในตัวแปร $result ซึ่งเป็นก้อนข้อมูลทั้งหมดที่ได้มาจากการรัน
	$row = $result->fetch_assoc(); //อ่านรายการข้อมูลจาก result มาเก็บในตัวแปร $row เพราะฉะนั้น $row นี้ก็จะเป็นรายการ (record) ผู้ป่วยที่มีรหัสตรงกับที่ระบุ
?>
<center>
<!-- this enctype="multipart/form-data" is necessary for uploading file -->
<form action="operations.php" method="post" enctype="multipart/form-data">
<table>
<tr><th><center><h3>Edit Day Use Form</h3></center><th></tr>
<tr><td>busno: </td><td><input type="text" name="busno" value="<?php echo $row["busno"] ?>" disabled></td></tr>
<tr><td>drvid: </td><td><input type="text" name="drvid" value="<?php echo $row["drvid"] ?>" disabled></td></tr>
<tr><td>Date: </td><td><input type="date" name="dte" value="<?php echo $row["dte"] ?>" disabled></td></tr>
<tr><td>amount: </td><td><input type="text" name="amount" value="<?php echo $row["amount"] ?>"></td></tr>
<!-- <tr><td>timestp: </td><td><input type="text" name="timestp" value="<?php echo $row["timestp"] ?>"></td></tr> -->
<!-- <tr><td>note: </td><td><input type="text" name="note" value="<?php echo $row["note"] ?>"></td></tr> -->
<!-- <tr><td>email: </td><td><input type="email" name="email" value="<?php echo $row["email"] ?>"></td></tr>
<tr><td>regisdte: </td><td><input type="text" name="regisdte" value="<?php echo $row["regisdte"] ?>"></td></tr> -->

<?php 
	//this for sending parameter to operations.php for updating by Post method
    echo "<input type='hidden' name ='busno'  value = '$busno'/>";	
    echo "<input type='hidden' name ='drvid'  value = '$drvid'/>";
    echo "<input type='hidden' name ='dte'  value = '$dte'/>";
?>

<tr><th colspan="2"><center><input type="submit" class='btn btn-success' name="updateDayuse" value="บันทึกการแก้ไข"></center></th></tr>
</table>
</form>
<br>
</center>
</body>
</html>
