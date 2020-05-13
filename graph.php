<?php
//connect ฐานข้อมูล
// $host = "localhost";
// $user = "root";
// $pwd = "123456";
// $db = "highcharts";
// global $link;
// $link = mysql_connect($host,$user,$pwd) or die ("Could not connect to MySQL");
// mysql_query("SET NAMES UTF8",$link);
// mysql_select_db($db,$link) or die ("Could not select $db database");

include "dbconnect.php";
include "menu.php";
$dte = $_POST['dte'];
$amount = array(); // ตัวแปรแกน x
$busno = array(); //ตัวแปรแกน y
//sql สำหรับดึงข้อมูล จาก ฐานข้อมูล
// $sql = "SELECT line.`month`, line.`value` FROM line";
// $sql = "SELECT dayuse.`dte`, dayuse.`amount` FROM dayuse";
$sql = "SELECT * FROM dayuse WHERE dte = '$dte'";
// $sql = "SELECT a.*, (SELECT COUNT(b.dte) FROM dayuse b WHERE b.dte=a.dte GROUP BY b.dte) as num, (SELECT SUM(b.amount) FROM dayuse b WHERE b.dte=a.dte GROUP BY b.dte) as sumamount FROM dayuse a ORDER BY a.dte ASC";
//จบ sql
$result = $conn->query($sql);
while($row=$result->fetch_assoc()) {
//array_push คือการนำค่าที่ได้จาก sql ใส่เข้าไปตัวแปร array
 array_push($busno,$row[busno]);
 array_push($amount,$row[amount]);
}
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Highcharts Example</title>
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
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>

<script>
 $(function () {
        $('#container').highcharts({
            chart: {
                type: 'line' //รูปแบบของ แผนภูมิ ในที่นี้ให้เป็น line,column
            },
            title: {
                text: 'จำนวนผู้ใช้บริการ' //
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['<?= implode("','", $busno); //นำตัวแปร array แกน x มาใส่ ในที่นี้คือ เดือน?>']
            },
            yAxis: {
                title: {
                    text: 'จำนวนผู้ใช้บริการ (ราย)'
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'ราย';
                }
            },
   legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -10,
                            y: 80,
                            borderWidth: 0
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                                name: '',//พ.ศ.2556
                                data: [<?= implode(',', $amount) // ข้อมูล array แกน y ?>]
                            }]
        });
    });
    $(function () {
        $('#containers').highcharts({
            chart: {
                type: 'column' //รูปแบบของ แผนภูมิ ในที่นี้ให้เป็น line,column
            },
            title: {
                text: 'จำนวนผู้ใช้บริการ' //
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['<?= implode("','", $busno); //นำตัวแปร array แกน x มาใส่ ในที่นี้คือ เดือน?>']
            },
            yAxis: {
                title: {
                    text: 'จำนวนผู้ใช้บริการ (ราย)'
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'ราย';
                }
            },
   legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -10,
                            y: 100,
                            borderWidth: 0
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                                name: '',
                                data: [<?= implode(',', $amount) // ข้อมูล array แกน y ?>]
                            }]
        });
    });
        </script>
    </head> 
    <body>
      <?php echo"<center><font size='5' color='black'>กราฟแสดงสรุปจำนวนผู้ใช้บริการประจำวันที่ : $dte  </font><br/></center>";?>
      <div id="container" style="min-width: 320px; height: 380px; margin: 0 auto"></div><br> 
      <div id="containers" style="min-width: 320px; height: 380px; margin: 0 auto"></div>     
    </body>
</html>