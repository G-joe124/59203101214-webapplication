<!DOCTYPE html>
<html>
<head>
<title>Insert Bus Driver Schedule</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="icon" href="images/bus-stop-icon.png">
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
    tr:nth-child(even){background-color: #E6E6FA}
    th {
        background-color: #5F9EA0;
        color: white;
    }
</style>
</head>

<body>
<?php
    // require_once("checkpermission.php");
    //add menu on the top of this insert form
    include "menu.php";

    //the aim of this part is to generate HNO automatically, 
    //using year and number of person registered in that year
    date_default_timezone_set('Asia/Bangkok'); //ตั้งค่าโซนเวลา
    //include "dbconnect.php";
    // $sql = "SELECT count(*) as np FROM patients WHERE ptid LIKE '%".date("Y")."%'";
    // $result = $conn->query($sql);
    // $row = $result->fetch_assoc();
    // $n = $row['np']; 
    // $hno = "HN".date("Y").($n+1);
    // $conn->close();
?>
<center>
<!-- this enctype="multipart/form-data" is necessary for uploading file -->
<form action="operations.php" method="post" enctype="multipart/form-data">
<table>
<tr><th><h3>Insert Bus Driver Schedule Form</h3><th></tr>
<!-- <tr><td>Driver ID: </td><td><input type="text" name="drvid" value=''></td></tr> -->
<tr><td>Date: </td><td><input type="date" class="form-control" name="dte"></td></tr>
<!-- <tr><td>Bus No: </td><td><input type="text" class="form-control" name="busno"></td></tr> -->
<tr><td>Bus No: </td><td> 
    <?php
        include "dbconnect.php";
        $sql = "SELECT * FROM bus ORDER BY busno";
        $result = $conn->query($sql);
        //echo "<option value='slotid'>โปรดเลือก";
        echo "<select class='form-control' name='busno'>";
        while($row = $result->fetch_assoc()){
            echo "<option value=".$row['busno'].">".$row['busno']."</option>";
        }
        echo"</select>";
        $conn->close(); 
    ?>
</td></tr>
<tr><td>Kha:</td><td><input type="radio" name="kha" value="1" checked> กะที่ 1</td></tr>
<tr><td></td><td><input type="radio" name="kha" value="2"> กะที่ 2</td></tr>
<tr><td></td><td><input type="radio" name="kha" value="3"> กะที่ 3</td></tr>
<tr><td>khatime: </td><td><input class="form-control" type="time" name="khatime"></td></tr>
<!-- <tr><td>drvid: </td><td><input class="form-control" type="text" name="drvid"></td></tr> -->
<tr><td>status:</td><td><input type="radio" name="statuss" value="1" checked> Active</td></tr>
<tr><td></td><td><input type="radio" name="statuss" value="2"> Unactive</td></tr>
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

<!-- <tr><td>E-mail: </td><td><input type="email" name="email"></td></tr> -->
<!-- <tr><td>Pass word: </td><td><input type="text" name="pwd"></td></tr>
<tr><td>register date: </td><td><input type="text" name="rigisdte"></td></tr> -->
<tr><th colspan="2"><center><input type="submit" class='btn btn-primary' name="insbusdrvsschedule" value="Insert"></center></th></tr>
</tr>
</table><br>
<!-- <input type="submit" class="btn btn-primary" name="insbusdrvsschedule" value="Insert"> -->
</form>
</center><br>
</body>
</html>