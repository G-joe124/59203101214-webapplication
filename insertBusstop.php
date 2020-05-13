<!DOCTYPE html>
<html>
<head>
<title>Insert Bus Stop</title>
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
<tr><th><h3>Insert Bus Stop Form</h3><th></tr>
<!-- <tr><td>Driver ID: </td><td><input type="text" name="drvid" value=''></td></tr> -->
<tr><td>Bus Stop Name: </td><td><input type="text" class="form-control" name="bus_stopnme"></td></tr>
<tr><td>Latitude: </td><td><input type="text" class="form-control" name="lat"></td></tr>
<!-- <tr><td>Gender:</td><td><input type="radio" name="gender" value="1" checked> Male</td></tr>
<tr><td></td><td><input type="radio" name="gender" value="2"> Female</td></tr> -->
<tr><td>Longitude: </td><td><input type="text" class="form-control" name="lng"></td></tr>
<tr><td>Detail: </td><td><input type="text" class="form-control" name="detail"></td></tr>
<!-- <tr><td>E-mail: </td><td><input type="email" name="email"></td></tr> -->
<!-- <tr><td>Pass word: </td><td><input type="text" name="pwd"></td></tr>
<tr><td>register date: </td><td><input type="text" name="rigisdte"></td></tr> -->
<tr><th colspan="2"><center><input type="submit" class='btn btn-primary' name="insbusstop" value="Insert"></center></th></tr>

</tr>
</table><br>
<!-- <input type="submit" class="btn btn-primary" name="insbusstop" value="Insert"> -->
</form>
</center>
</body>
</html>