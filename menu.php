<!DOCTYPE html>
<html lang="en">
<head>
  <title>Via Bus in PSU Pattani System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="icon" href="hospital-icon.png"> -->
  <link rel="icon" href="images/bus-stop-icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<style>
  .jumbotron{
  background-color: white;
  padding: 20px;
  text-align: center;
}
.navbar-expand-sm{
  background-color: #001a4d;
  color:#ffffff;
  border-color:#001a4d;
}
/* .navbar-header{
  color:#ffffff;
} */
</style>
<body>
<?php 
  session_start();//start session
	$id = $_SESSION['valid_id'];	
	$fnme = $_SESSION['valid_fnme'];
	$lnme = $_SESSION['valid_lnme'];
	$utype = $_SESSION['valid_utype'];
?>
<div class="jumbotron" style="margin-bottom:0">
  <h1>VIA BUS IN PSU PATTANI</h1>
  <p>โครงการพัฒนาระบบติดตามรถโดยสารพลังงานไฟฟ้าภายในมหาวิทยาลัย</p> 
</div>
<nav class="navbar navbar-expand-sm bg-blue navbar-dark">
  <a class="navbar-brand" href="index.php"><span class='glyphicon glyphicon-home'></span> HOME</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="maps.php"><span class='glyphicon glyphicon-globe'></span> MAPS</a>
      </li>
      <!-- <li class="nav-item">
         <a class="nav-link" href="insertDriver.php"><span class='glyphicon glyphicon-plus-sign'></span> ADD</a>
      </li> -->
      <li class='nav-item dropdown'>
        <a class='nav-link ' data-toggle='dropdown' href='#'><span class='glyphicon glyphicon-plus-sign'>ADD</span></a>
          <ul class='dropdown-menu'>
            <li><a href='insertDriver.php'>Insert Driver</a></li>
            <li><a href='insertBus.php'>Insert Bus</a></li>
            <li><a href='insertBusstop.php'>Insert Bus Stop</a></li>
            <!-- <li><a href='insertBusRoute.php'>Insert Bus Route</a></li> -->
            <li><a href='insertBusdrvsschedule.php'>Insert Bus Driver Schedul</a>
          </ul>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#"><span class='glyphicon glyphicon-list-alt'></span> SHOW</a>
      </li>     -->
      <li class='nav-item dropdown'>
        <a class='nav-link ' data-toggle='dropdown' href='#'><span class='glyphicon glyphicon-list-alt'>SHOW</span></a>
          <ul class='dropdown-menu'>
            <li><a href='showBus.php'>Show Bus</a></li>
            <li><a href='showDriver.php'>Show Driver</a></li>
            <li><a href='showBusStop.php'>Show Bus stop</a></li>
            <li><a href='showBusRoute.php'>Show Bus Route</a></li>
            <li><a href='showBusdrvsschedule.php'>Show Bus Driver Schedule</a></li>
            <li><a href='showBusUse.php'>Show Bus Use</a></li>
            <li><a href='showDayUse.php'>Show Day Use</a></li>
          </ul>
      </li>

      <li class='nav-item dropdown'>
        <a class='nav-link ' data-toggle='dropdown' href='#'><span class='glyphicon glyphicon-file'>REPORT</span></a>
          <ul class='dropdown-menu'>
            <!-- <li><a href='showBusRoute.php'>Bus Route</a></li> -->
            <!-- <li><a href='showBusdrvsschedule.php'>Bus Driver Schedule</a></li> -->
            <li><a href='rptDayUse.php'>Day Use</a></li>
            <li><a href='rptBusUse.php'>Bus Use</a></li>
            
          </ul>
      </li>

      <li class='nav-item dropdown'>
        <a class='nav-link ' data-toggle='dropdown' href='#'><span class='glyphicon glyphicon-signal'>GRAPH</span></a>
          <ul class='dropdown-menu'>
            <li><a href='graphAll.php'>Graph Of All Day Use</a></li>
          </ul>
      </li>

      <!-- <li class="nav-item">
        <a class="nav-link" href="#"><span class='glyphicon glyphicon-align-left'></span> REPORT</a>
      </li>     -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="#"><span class='glyphicon glyphicon-exclamation-sign'></span> ABOUT</a>
      </li>   -->
      <!-- <li class="nav-item;dropdown;nav-item-right">
          <a class="nav-link" href="login.php"><span class='glyphicon glyphicon-log-in'></span> LOGIN</a>
      </li>   -->
      <!-- <li class='nav-item dropdown'>
        <a class='nav-link ' data-toggle='dropdown' href='#'>Patients <span class='caret'></span></a>
          <ul class='dropdown-menu'>
            <li><a href='insertPatientForm.php'>Add new ...</a></li>
            <li><a href='showPatients.php'>Show all</a></li>
            <li><a href='showFindPatients.php'>Search & Show</a></li>
            <li><a href='rptPatientSmry.php'>Report 1</a></li>
            <li><a href='rptPatientSmry2.php'>Report 2</a></li>
            <li><a href='rptPatientBySxNat.php'>Report 3</a></li>
          </ul>
      </li> -->
    </ul>
  </div>  
</nav>
  
<div class="container">

</div>

</body>
</html>