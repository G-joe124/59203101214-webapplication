<!DOCTYPE html>
<html>
<head>
<title>Edit Driver</title>
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
		$drvid = $id;
	else 
		$drvid = $_POST['drvid']; //get ptid from showPatients, in case of admin/staff used

	$sql = "SELECT * FROM driver WHERE drvid = '$drvid'"; //คำสั่ง select ข้อมูลผู้ป่วยจากตาราง patients ที่มี ptid = $ptid
	$result = $conn->query($sql); //run คำสั่งคิวรีย์ โดยนำผลที่ได้มาเก็บในตัวแปร $result ซึ่งเป็นก้อนข้อมูลทั้งหมดที่ได้มาจากการรัน
	$row = $result->fetch_assoc(); //อ่านรายการข้อมูลจาก result มาเก็บในตัวแปร $row เพราะฉะนั้น $row นี้ก็จะเป็นรายการ (record) ผู้ป่วยที่มีรหัสตรงกับที่ระบุ
?>
<center>
<!-- this enctype="multipart/form-data" is necessary for uploading file -->
<form action="operations.php" method="post" enctype="multipart/form-data">
<table>
<tr><th><center><h3>Edit Driver Form</h3></center><th></tr>
<tr><td>drvid: </td><td><input type="text" name="drvid" value="<?php echo $row["drvid"] ?>" disabled></td></tr>
<tr><td>fnme: </td><td><input type="text" name="fnme" value="<?php echo $row["fnme"] ?>"></td></tr>
<tr><td>lnme: </td><td><input type="text" name="lnme" value="<?php echo $row["lnme"] ?>"></td></tr>
<!-- <tr><td>Status: </td><td><input type="text" name="status" value="<?php echo $row["status"] ?>"></td></tr> -->
<tr><td>gender:</td>
	<td><input type="radio" name="gender" value="1" <?php if ($row["gender"]==1) echo "checked" ?> > Male</td></tr>
<tr><td></td>
	<td><input type="radio" name="gender" value="2" <?php if ($row["gender"]==2) echo "checked" ?> > Female</td></tr>
<tr><td>tel: </td><td><input type="text" name="tel" value="<?php echo $row["tel"] ?>"></td></tr>
<tr><td>licenNo: </td><td><input type="text" name="licenNo" value="<?php echo $row["licenNo"] ?>"></td></tr>
<tr><td>email: </td><td><input type="email" name="email" value="<?php echo $row["email"] ?>"></td></tr>
<tr><td>regisdte: </td><td><input type="date" name="regisdte" value="<?php echo $row["regisdte"] ?>"></td></tr>

<?php 
	//this for sending parameter to operations.php for updating by Post method
	echo "<input type='hidden' name ='drvid'  value = '$drvid'/>";	
?>

<tr><th colspan="2"><center><input type="submit" class='btn btn-success' name="updateDriver" value="บันทึกการแก้ไข"></center></th></tr>
</table>
</form>
<br>
</center>
</body>
</html>
