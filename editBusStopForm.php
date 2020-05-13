<!DOCTYPE html>
<html>
<head>
<title>Edit Bus Stop</title>
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
		$bus_stopno = $id;
	else 
		$bus_stopno = $_POST['bus_stopno']; //get ptid from showPatients, in case of admin/staff used

	$sql = "SELECT * FROM bus_stop WHERE bus_stopno = '$bus_stopno'"; //คำสั่ง select ข้อมูลผู้ป่วยจากตาราง patients ที่มี ptid = $ptid
	$result = $conn->query($sql); //run คำสั่งคิวรีย์ โดยนำผลที่ได้มาเก็บในตัวแปร $result ซึ่งเป็นก้อนข้อมูลทั้งหมดที่ได้มาจากการรัน
	$row = $result->fetch_assoc(); //อ่านรายการข้อมูลจาก result มาเก็บในตัวแปร $row เพราะฉะนั้น $row นี้ก็จะเป็นรายการ (record) ผู้ป่วยที่มีรหัสตรงกับที่ระบุ
?>
<center>
<!-- this enctype="multipart/form-data" is necessary for uploading file -->
<form action="operations.php" method="post" enctype="multipart/form-data">
<table>
<tr><th><center><h3>Edit Bus Stop Form</h3></center><th></tr>
<tr><td>bus_stopno: </td><td><input type="text" name="bus_stopno" value="<?php echo $row["bus_stopno"] ?>" disabled></td></tr>
<tr><td>bus_stopnme: </td><td><input type="text" name="bus_stopnme" value="<?php echo $row["bus_stopnme"] ?>"></td></tr>
<tr><td>lat: </td><td><input type="text" name="lat" value="<?php echo $row["lat"] ?>"></td></tr>
<tr><td>lng: </td><td><input type="text" name="lng" value="<?php echo $row["lng"] ?>"></td></tr>
<tr><td>detail: </td><td><input type="text" name="detail" value="<?php echo $row["detail"] ?>"></td></tr>

<?php 
	//this for sending parameter to operations.php for updating by Post method
	echo "<input type='hidden' name ='bus_stopno'  value = '$bus_stopno'/>";	
?>

<tr><th colspan="2"><center><input type="submit" class='btn btn-success' name="updateBusStop" value="บันทึกการแก้ไข"></center></th></tr>
</table>
</form>
<br>
</center>
</body>
</html>
