<!DOCTYPE html>
<html>
<head>
<title>Edit Bus Driver Schedule</title>
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
		$dte = $_POST['dte']; //get ptid from showPatients, in case of admin/staff used
		$busno = $_POST['busno'];
		$kha = $_POST['kha'];
        // $dte = $_POST['dte'];
        // $timestr = $_POST['timestr'];

	$sql = "SELECT * FROM busdrvsschedule WHERE dte = '$dte' AND busno = '$busno' AND kha ='$kha'"; //คำสั่ง select ข้อมูลผู้ป่วยจากตาราง patients ที่มี ptid = $ptid
	$result = $conn->query($sql); //run คำสั่งคิวรีย์ โดยนำผลที่ได้มาเก็บในตัวแปร $result ซึ่งเป็นก้อนข้อมูลทั้งหมดที่ได้มาจากการรัน
	$row = $result->fetch_assoc(); //อ่านรายการข้อมูลจาก result มาเก็บในตัวแปร $row เพราะฉะนั้น $row นี้ก็จะเป็นรายการ (record) ผู้ป่วยที่มีรหัสตรงกับที่ระบุ
?>
<center>
<!-- this enctype="multipart/form-data" is necessary for uploading file -->
<form action="operations.php" method="post" enctype="multipart/form-data">
<table>
<tr><th><center><h3>Edit Bus Driver Schedule Form</h3></center><th></tr>
<tr><td>Date: </td><td><input type="date" name="dte" value="<?php echo $row["dte"] ?>" disabled></td></tr>
<tr><td>Bus No: </td><td><input type="text" name="busno" value="<?php echo $row["busno"] ?>" disabled></td></tr>
<!-- <tr><td>Kha: </td><td><input type="text" name="kha" value="<?php echo $row["kha"] ?>"></td></tr> -->
<tr><td>Kha:</td><td><input type="radio" name="kha" value="1" <?php if ($row["kha"]==1) echo "checked" ?>> กะที่ 1</td></tr>
<tr><td></td><td><input type="radio" name="kha" value="2" <?php if ($row["kha"]==2) echo "checked" ?>> กะที่ 2</td></tr>
<tr><td></td><td><input type="radio" name="kha" value="3" <?php if ($row["kha"]==3) echo "checked" ?>> กะที่ 3</td></tr>
<tr><td>Khatime: </td><td><input type="time" name="khatime" value="<?php echo $row["khatime"] ?>"></td></tr>
<!-- <tr><td>Driver ID: </td><td><input type="text" name="drvid" value="<?php echo $row["drvid"] ?>"></td></tr> -->
<!-- <tr><td>Status: </td><td><input type="text" name="statuss" value="<?php echo $row["statuss"] ?>"></td></tr> -->
<tr><td>status:</td><td><input type="radio" name="statuss" value="1" <?php if ($row["statuss"]==1) echo "checked" ?>> Active</td></tr>
<tr><td></td><td><input type="radio" name="statuss" value="2" <?php if ($row["statuss"]==2) echo "checked" ?>> Unactive</td></tr>
<tr><td>driver: </td><td> 
    <?php
        include "dbconnect.php";
        $sql = "SELECT * FROM driver ORDER BY drvid";
        $result = $conn->query($sql);
        //echo "<option value='slotid'>โปรดเลือก";
        echo "<select class='form-control' name='drvid'>";
        while($row = $result->fetch_assoc()){
            echo "<option value=".$row['drvid'].">".$row['fnme']."  ".$row['lnme']."</option>";
        }
        echo"</select>";
        $conn->close(); 
    ?>
</td></tr>
<!-- <tr><td>email: </td><td><input type="email" name="email" value="<?php echo $row["email"] ?>"></td></tr>
<tr><td>regisdte: </td><td><input type="text" name="regisdte" value="<?php echo $row["regisdte"] ?>"></td></tr> -->

<?php 
	//this for sending parameter to operations.php for updating by Post method
	echo "<input type='hidden' name ='dte'  value = '$dte'/>";
	echo "<input type='hidden' name ='busno'  value = '$busno'/>";
	echo "<input type='hidden' name ='kha'  value = '$kha'/>";	
?>

<tr><th colspan="2"><center><input type="submit" class='btn btn-success' name="updatebusdrvsschedule" value="บันทึกการแก้ไข"></center></th></tr>
</table>
</form>
<br>
</center>
</body>
</html>
