<?php
	header('Content-Type: application/json');
	$objConnect = mysql_connect("localhost","root","5920310124");
	$objDB = mysql_select_db("viabusinpsu");
	mysql_query("SET NAMES UTF8");
	
	$strSQL = "SELECT * FROM bus_stop";

	$objQuery = mysql_query($strSQL);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		array_push($resultArray,$obResult);
	}
	
	mysql_close($objConnect);
	
	echo json_encode($resultArray);
?>