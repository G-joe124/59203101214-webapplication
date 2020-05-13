<!doctype html>

<html>
<head>
<title>Report Day Use</title>
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
<script>
function clr() {
	  document.forms["search"]["dte"].value="";
	}
</script>	
</head>
<body>

<?php
include "dbconnect.php";
include "menu.php";
date_default_timezone_set("Asia/Bangkok");
//constant value of genders
// s
// function getAge($dte) { //the function used for computing age, based on the birthdate
// 		return intval(date('Y', time() - strtotime($dte))) - 1970;
// }
function shwThaiDate($dte) { //where $dte is a Date format
	return date("d-m-Y",strtotime($dte));//formulate date format for displaying
}
// $dtee	=$_POST['dtee'];

//count all patients from database
	$sql = "SELECT dayuse.busno, dayuse.drvid , dayuse.dte, dayuse.amount as pr 
			FROM dayuse";
    // $sql = "SELECT * FROM dayuse"
	if($dte !="")
		$sql = $sql." AND dte LIKE '%$dte%' ";

		$result = $conn->query($sql);
	
		$numfound = $result->num_rows; //return the number of records

	echo "<center>";
    echo "<h2>REPORT DAY USE FORM</h2><br />";
    echo "<form action='rptDayUse.php' method='post' name='search'>";
	echo "<label for='search'>Search Date: </label>";
	echo "<input type='date' size='50%'  name='search' placeholder='Enter Dates' />";
	echo "<input type='submit' value='search' />";
	echo "</form>";
    echo "<table>";
    echo "<tr>";
    echo "<th><center>ลำดับที่</center></th>";
    echo "<th>BUS NO</th>";
    echo "<th>DRIVER ID</th>";
    echo "<th>DATE</th>";
    echo "<th>AMOUNT</th>";
    echo "</tr>";
    echo "</center>";

$search = $_POST[search];
	if(isset($search) ) {
			// echo "<font size='-1' color='#FF0000'>ผลลัพธ์ของคำว่า [ $search ] </font><br />";
			// echo "<font size='-1' color='green'>ค้นพบทั้งหมด :: [ $numfound ] </font><br/>";

	$sql = "SELECT *
			FROM dayuse
			WHERE dte LIKE '%$search%'";
			// echo $sql;
	//run the query $sql
    $result = $conn->query($sql);
    $numfound = $result->num_rows;
    // echo "<font size='3' color='black'>ผลลัพธ์ของคำว่า : [ $search ] </font><br />";
	echo "<br/><font size='3' color='green'>ค้นพบทั้งหมด : [ $numfound ] รายการ</font><br/><br/>";
	echo "<font size='5' color='black'>รายงานสรุปจำนวนผู้ใช้บริการประจำวันที่ : [ $search ] </font><br/>";
    $n=0;
    while ($rw = $result->fetch_assoc()) {
		$busno = $rw['busno'];
		$drvid = $rw['drvid'];
		$dte = $rw['dte'];
		$amount = $rw['amount'];
		// $pr = $rw['pr'];
		// $nb = $rw['nb'];	

        echo "<tr>";
        echo "<td><center>".++$n."</center></td>";
        echo "<td>".$busno."</td>";
		echo "<td>".$drvid."</td>";
		echo "<td>".$dte."</td>";
		echo "<td>".number_format($amount)."</td>";
		// echo "<td>".number_format($nb)."</td>";
		// echo "<td>".number_format($pr)."</td>";
		echo "</tr>";
	} 
	echo "<tr><th colspan='11'>Total ".$n." records </th></tr>";
	echo "<tr><td colspan='11'><center><form action = 'graph.php' method ='post'>
		<input type='hidden' name ='dte'  value = '".$search."'/>
		<input name = 'editBusStop' type='submit' class='btn btn-success' value='See Graph' />
		</form></center></td></tr>";
}else {
	echo "กรุณากรอกคำค้นของคุณ";
	}
$conn->close();
?>
</body>
</html>