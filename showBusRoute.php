<!doctype html>

<html>
<head>
<title>Show Bus Route</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <!-- <link rel="icon" href="hospital-icon.png"> -->
  <link rel="icon" href="images/bus-stop-icon.png">
<style>
table {
    border-collapse: collapse;
    width: 80%;
}

th, td {
    text-align: left;
    padding: 8px;
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
include "dbconnect.php";
include "menu.php";
date_default_timezone_set("Asia/Bangkok");
//constant value of genders
// $khas= array();
// $khas[1]="กะที่ 1"; $khas[2]="กะที่ 2"; $khas[3]="กะที่ 3";
// $status= array();
// $status[1]="ACTIVE"; $status[2]="UNACTIVE";
// function getAge($dte) { //the function used for computing age, based on the birthdate
// 		return intval(date('Y', time() - strtotime($dte))) - 1970;
// }
function shwThaiDate($dte) { //where $dte is a Date format
	return date("d-m-Y",strtotime($dte));//formulate date format for displaying
}

//count all patients from database order by name, this is used for caculate the numbers of pages
	$sql = "SELECT count(*) busno FROM busroute";
	$result = $conn->query($sql);
	$rw = $result->fetch_assoc(); 
	$numfound = $rw['busno']; //return the number of records
	
	if($_POST['showPage'] || $_POST['nextPage'] ||$_POST['firstPage'] || $_POST['lastPage'] || $_POST['prePage']){
		$p_size =  $_POST['nrec']; //กำหนดจำนวน record ที่จะแสดงผลต่อ 1 เพจ ให้เท่ากับค่าที่จำนวนต่อเพจที่รับมา
	}else{
		$p_size = 10; //กำหนดจำนวน record เริ่มต้นที่จะแสดงผลต่อ 1 เพจ
	}
	$total_page=(int)($numfound/$p_size); 
	//ทำการหารหาจำนวนหน้าทั้งหมดของข้อมูล ในที่นี้ให้หารออกมาเป็นเลขจำนวนเต็ม 
	if(($numfound % $p_size)!=0){ //ถ้าข้อมูลมีเศษให้ทำการบวกเพิ่มจำนวนหน้าอีก 1 
	   $total_page++;
	}
	if($_POST[showPage]){
	/*
	หากมีการส่งค่ามาเพื่อเลือกดูหน้าข้อมูลหน้าใดให้ทำการคำนวน โดยใช้ จำนวนข้อมูลที่ต้องการแสดงต่อ 1 เพจ คูณกับ หน้าข้อมูลที่ต้องการเลือกชม ลบด้วย 1
	*/ 
		$page=$_POST['pageno'];
		$start=$p_size*($page-1);

	}else if($_POST[nextPage]){
		$p = $_POST['pageno'];
		if ( $p < $total_page)
			$page=$p + 1;
		else $page=$p;
		$start=$p_size*($page-1);

	}else if($_POST[firstPage]){
		$page=1;
		$start=$p_size*($page-1);

	}else if($_POST[lastPage]){
		$page=$total_page;
		$start=$p_size*($page-1);
	}else if($_POST[prePage]){
		$p= $_POST['pageno'];
		if($p >= 2)
			$page = $p - 1;
		else $page = $p;
		$start = $p_size*($page-1);
	}else{
	/*
	ถ้่ายังไม่มีการส่งค่ามาเพื่อทำการเลือกดูหน้าข้อมูลใด ๆ ให้กำหนดเป็นหน้าแรกของข้อมูลเป็นค่า Default และให้ Record แรกเริ่มที่ Record ที่ 0 หรือ Record แรก
	*/ 
	   $page=1;
	   $start=0;
	}
	
//new sql for selecting all patients details
$sql = "SELECT * 
			FROM busroute 
			ORDER BY busno LIMIT $start , $p_size";
			
$result = $conn->query($sql);
echo"<center>";	
echo "<h2>All BUS ROUTE</h2>";
echo "<table>";
echo "<tr>";
echo "<th><center>ลำดับที่</center></th>";
echo "<th>BUS NO</th>";
echo "<th>ORDER</th>";
echo "<th>BUS STOP NO</th>";
echo "<th>TIME STOP</th>";
// echo "<th>DRIVER ID</th>";
// echo "<th>STATUS</th>";
// echo "<th>email</th>";
// echo "<th>regisdte</th>";
// echo "<th>Birth Date</th>";
// echo "<th>Age</th>";
// echo "<th>Blood</th>";
echo "<th colspan=2>ดำเนินการ</th>";
echo "</tr>";
if ($result->num_rows > 0) {
    //loop to show the details of each record
	$n=0;
    while($row = $result->fetch_assoc()) {
		echo "<tr>";
        echo "<td><center>".++$n."</center></td>";
        echo "<td>".$row["busno"]."</td>";
        echo "<td>".$row["orders"]."</td>";
        echo "<td>".$row["bus_stopno"]."</td>";
		// echo "<td>".$row["kha"]."</td>";
		// echo "<td>".$khas[$row["kha"]]."</td>"; //convert gender id to string
		//echo "<td>".shwThaiDate($row["dob"])."</td>"; //call a method to show date
		// echo "<td>".getAge($row["dob"])."</td>"; //call a method to compute and get age from dob
		echo "<td>".$row["timestp"]."</td>";
        // echo "<td>".$row["drvid"]."</td>";
		// echo "<td>".$row["statuss"]."</td>";
		// echo "<td>".$status[$row["statuss"]]."</td>";
        // echo "<td>".$row["email"]."</td>";
        // echo "<td>".$row["regisdte"]."</td>";
		echo "<td>";
		echo "<form action = 'editsBusRouteForm.php' method ='post'> ";
		echo "<input type='hidden' name ='busno'  value = '".$row["busno"]."'/>";
		echo "<input type='hidden' name ='orders'  value = '".$row["orders"]."'/>";	
		echo "<input type='hidden' name ='bus_stopno'  value = '".$row["bus_stopno"]."'/>";	
		echo "<input name = 'editsBusRouteForm' type='submit' class='btn btn-warning' value='edit' />";
		echo "</form>";
		echo "</td>";
		echo "<td>";
		echo "<form action = 'operations.php' method ='post'> ";
		echo "<input type='hidden' name ='busno'  value = '".$row["busno"]."'/>";
		echo "<input type='hidden' name ='orders'  value = '".$row["orders"]."'/>";
		echo "<input type='hidden' name ='bus_stopno'  value = '".$row["bus_stopno"]."'/>";
		echo "<input name = 'delbusRoute' type='submit' class='btn btn-danger' value='del' />";
		echo "</form>";
		echo "</td>";
		echo "</tr>";	
    }
	echo "<tr><th colspan='11'>Total ".$n." records </th></tr>";
} else {
    echo "0 results";
}
//show navigation bar
echo "<tr><td colspan='13'><center>";
	echo"<form action = 'showBusRoute.php' method ='post'> ";
    echo "<input type='hidden' name ='busno'  value = '$busno'/>";
    echo "<input type='hidden' name ='orders' value = '$orders'/>";		
	echo "<input type='hidden' name ='bus_stopno'  value = '$bus_stopno'/>";
	echo "<input type='hidden' name ='timestp' value = '$timestp'/>";
    // echo "<input type='hidden' name ='drvid'  value = '$drvid'/>";
    // echo "<input type='hidden' name ='statuss'  value = '$statuss'/>";
    // echo "<input type='hidden' name ='regisdte'  value = '$regisdte'/>";
	// echo "<input type='hidden' name ='dob'  value = '$dob'/>";
	// echo "<input type='hidden' name ='nat'  value = '$nat'/>";
	// echo "<input type='hidden' name ='bldgrp'  value = '$bldgrp'/>";
	 echo "แสดงหน้าที่ : <select name = pageno value =$page>";

		for($i=1;$i<=$total_page;$i++){ //สร้าง list เพื่อให้ผู้ใช้งานเลือกชมหน้าข้อมูล
			echo "<option ";
			 if($page==$i)
				     echo "selected='selected'";
			echo "value=",$i, ">",$i;
		}
	
	echo "</select>  จากทั้งหมด ".$total_page." หน้า";
	echo " จำนวนรายการต่อหน้า <input name = 'nrec' type='text' value = $p_size size = 3/>";
	echo "<input name = 'showPage' type='submit' value='show' />";
	echo "<input name = 'firstPage' type='submit' value='<<first' />";
	echo "<input name = 'prePage' type='submit' value='<previous' />";
	echo "<input name = 'nextPage' type='submit' value='next>' />";
	echo "<input name = 'lastPage' type='submit' value='last>>' />";
	echo "</form>";
echo "</td></tr>";
//end navigation bar	

// echo "<tr><td colspan='11'><a href='insertBusRoute.php'>Add New Bus Route</a></td></tr>";
echo"</center>";
$conn->close();
?>
</body>
</html>