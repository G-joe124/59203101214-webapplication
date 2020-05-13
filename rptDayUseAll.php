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
    // $sql = "SELECT * FROM dayuse"
	echo "<center>";
    echo "<h2>REPORT DAY USE FORM</h2><br />";
    // echo "<form action='rptDayUse.php' method='post' name='search'>";
	// echo "<label for='search'>Search Date: </label>";
	// echo "<input type='date' size='50%'  name='search' placeholder='Enter Dates' />";
	// echo "<input type='submit' value='search' />";
	// echo "</form>";
    echo "<table>";
    echo "<tr>";
    echo "<th><center>ลำดับที่</center></th>";
    echo "<th>BUS NO</th>";
    echo "<th>DRIVER ID</th>";
    echo "<th>DATE</th>";
    echo "<th>AMOUNT</th>";
    echo "<th>SUM OF DATE</th>";
    echo "</tr>";
    echo "</center>";

			// echo "<font size='-1' color='#FF0000'>ผลลัพธ์ของคำว่า [ $search ] </font><br />";
			// echo "<font size='-1' color='green'>ค้นพบทั้งหมด :: [ $numfound ] </font><br/>";

	$sql = "SELECT a.*, (SELECT COUNT(b.dte) FROM dayuse b WHERE b.dte=a.dte GROUP BY b.dte) as num, (SELECT SUM(b.amount) FROM dayuse b WHERE b.dte=a.dte GROUP BY b.dte) as sumamount FROM dayuse a ORDER BY a.dte ASC";
			// echo $sql;
	//run the query $sql
    $result = $conn->query($sql);
    $numfound = $result->num_rows;
    // echo "<font size='3' color='black'>ผลลัพธ์ของคำว่า : [ $search ] </font><br />";
    $n=0;
    $aggr_arr=array();   
    while ($rw = $result->fetch_assoc()) {
        $dateKey=date("dmY",strtotime($rw['dte']));
		$busno = $rw['busno'];
		$drvid = $rw['drvid'];
		$dte = $rw['dte'];
        $amount = $rw['amount'];
        $sumamount = $rw['sumamount'];
        $num = $rw['num'];
        $row_span=0;
		// $pr = $rw['pr'];
		// $nb = $rw['nb'];	
        if(!isset($aggr_arr[$dateKey])){
            $aggr_arr[$dateKey]=array();  
            $row_span=1;
        }
        echo "<tr>";
        echo "<td><center>".++$n."</center></td>";
        echo "<td>".$busno."</td>";
		echo "<td>".$drvid."</td>";
		echo "<td>".$dte."</td>";
        echo "<td>".number_format($amount)."</td>";
        // echo "<td>".number_format($sumamount)."</td>";
        if($row_span==1){?>
            <td rowspan="<?=$num?>"><?=$sumamount?></td>              
        <?php }         
		// echo "<td>".number_format($nb)."</td>";
		// echo "<td>".number_format($pr)."</td>";
		echo "</tr>";
	} 
	echo "<tr><th colspan='11'>Total ".$n." records </th></tr>";
	echo "<tr><td colspan='11'><center><form action = 'graph.php' method ='post'>
		<input type='hidden' name ='dte'  value = '".$search."'/>
		<input name = 'editBusStop' type='submit' class='btn btn-success' value='See Graph' />
		</form></center></td></tr>";
$conn->close();
?>
</body>
</html>