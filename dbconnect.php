<?php
    /*    
     header("Access-Control-Allow-Origin: *");
     $conn = mysqli_connect("localhost","user33","877w294r","user33_healthcare") or die ("could not connect database");
    
    */
	//$servername = "localhost";
    //$servername = "127.0.0.1";
	$servername = "172.18.111.41";
    //$username = "root";
	$username = "5920310124";
    $password = "5920310124";
    //$dbname = "viabusinpsu";
	$dbname = "5920310124";
    // Create connection object
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    // echo "Connected successfully";
    mysqli_set_charset($conn, "utf8");//is to make Thai readable
?>