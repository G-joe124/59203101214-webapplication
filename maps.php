<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
    <title>MAPS VAI BUS PSU BLUE-TS</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="icon" href="images/bus-stop-icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style type="text/css">
html { height: 100% }
body { 
    height:100%;
    margin:0;padding:0;
    font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;
    font-size:12px;
}
/* css กำหนดความกว้าง ความสูงของแผนที่ */
#map_canvas { 
    width:100%;
    height:800px;
    margin:auto;
    margin-top:10px;
}
</style>
</head>
 
<body>
<?php
include "menu.php"; 
?>
  <div id="map_canvas"></div>
  
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
<script type="text/javascript">
var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
function initialize() { // ฟังก์ชันแสดงแผนที่
    GGM=new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
    // กำหนดจุดเริ่มต้นของแผนที่
    var my_Latlng  = new GGM.LatLng(6.882325,101.236949);
    // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
    var my_DivObj=$("#map_canvas")[0]; 
    // กำหนด Option ของแผนที่
    var myOptions = {
        zoom: 17, // กำหนดขนาดการ zoom
        center: my_Latlng , // กำหนดจุดกึ่งกลาง
        mapTypeId:GGM.MapTypeId.ROADMAP, // กำหนดรูปแบบแผนที่
        mapTypeControlOptions:{ // การจัดรูปแบบส่วนควบคุมประเภทแผนที่
            position:GGM.ControlPosition.TOP, // จัดตำแหน่ง
            style:GGM.MapTypeControlStyle.DROPDOWN_MENU // จัดรูปแบบ style 
        }
    };
    map = new GGM.Map(my_DivObj,myOptions);// สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map
 
    // เรียกใช้คุณสมบัติ ระบุตำแหน่ง ของ html 5 ถ้ามี  
    if(navigator.geolocation){  
            navigator.geolocation.getCurrentPosition(function(position){  
                var myPosition_lat=position.coords.latitude; // เก็บค่าตำแหน่ง latitude  ปัจจุบัน
                var myPosition_lon=position.coords.longitude;  // เก็บค่าตำแหน่ง  longitude ปัจจุบัน
                // สรัาง LatLng ตำแหน่ง สำหรับ google map
                var pos = new GGM.LatLng(position.coords.latitude,position.coords.longitude);   
                // function(pos){
                //     map.panTo(pos); // เลื่อนแผนที่ไปตำแหน่งปัจจุบัน
                //     map.setCenter(pos);  // กำหนดจุดกลางของแผนที่เป็น ตำแหน่งปัจจุบัน                                   
                // }
            },function() {  
                // คำสั่งทำงาน ถ้า ระบบระบุตำแหน่ง geolocation ผิดพลาด หรือไม่ทำงาน  
            });  
    }else{  
         // คำสั่งทำงาน ถ้า บราวเซอร์ ไม่สนับสนุน ระบุตำแหน่ง  
    }   
 
    // ใช้ ajax ดึงค่าจาก xml มาใช้งาน
    $.ajax({  
        url:"bstplist.php", // ใช้ ajax ใน jQuery เรียกใช้ไฟล์ xml  
        dataType: "xml",  
        success:function(xml){  
            $(xml).find("marker").each(function(){ // วนลูปดึงค่าข้อมูลมาสร้าง marker  
                    var markerID=$(this).attr("id");// นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน      
                    var markerName=$(this).find("name").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน      
                    var markerLat=$(this).find("latitude").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน   
                    var markerLng=$(this).find("longitude").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน         
                    // var markerDate=$(this).find("lastdate").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน         
                    // var narkerIcons=$(this).find("icon").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน           
                    var markerLatLng=new GGM.LatLng(markerLat,markerLng);  
                    // var image1 = new GGM.MarkerImage(markerIcons,  // url ภาพ ใส่แบบเต็ม หรือแบบ path ก็ได้  
                    // new GGM.Size(50, 60),  //กำหนดความกว้าง สูงของ icons  
                    // new GGM.Point(0,0),  // จุดเริ่มต้นของรูปภาพ ใช้ 0,0  
                    // new GGM.Point(25, 60)  // จุดปลายของพิกัดเทียบกับรูป ปกติ (0,ความสูงของรูป) หรือ (ครึ่งหนึ่งความกว้างของรูป,ความสูงของรูป)  
                    // );                  
                    var my_Marker = new GGM.Marker({ // สร้างตัว marker  
                        position:markerLatLng,  // กำหนดไว้ที่เดียวกับจุดกึ่งกลาง  
                        icon: 'images/bus-stop-iconnnnn.png', // เปลี่ยนเป็น icon ตามรูปภาพที่ดึงจาก xml 
                        map: map, // กำหนดว่า marker นี้ใช้กับแผนที่ชื่อ instance ว่า map  
                        title:markerName // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ  
                    });  
                //  console.log($(this).find("id").text());  
            });  
        }     
    });  
    $.ajax({  
        url:"bslist.php", // ใช้ ajax ใน jQuery เรียกใช้ไฟล์ xml  
        dataType: "xml",  
        success:function(xml){  
            $(xml).find("marker").each(function(){ // วนลูปดึงค่าข้อมูลมาสร้าง marker  
                    var markerID=$(this).attr("id");// นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน      
                    // var markerName=$(this).find("name").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน      
                    var markerLat=$(this).find("latitude").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน   
                    var markerLng=$(this).find("longitude").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน         
                    // var markerDate=$(this).find("lastdate").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน         
                    // var narkerIcons=$(this).find("icon").text(); // นำค่าต่างๆ มาเก็บไว้ในตัวแปรไว้ใช้งาน           
                    var markerLatLng=new GGM.LatLng(markerLat,markerLng);  
                    // var image1 = new GGM.MarkerImage(markerIcons,  // url ภาพ ใส่แบบเต็ม หรือแบบ path ก็ได้  
                    // new GGM.Size(50, 60),  //กำหนดความกว้าง สูงของ icons  
                    // new GGM.Point(0,0),  // จุดเริ่มต้นของรูปภาพ ใช้ 0,0  
                    // new GGM.Point(25, 60)  // จุดปลายของพิกัดเทียบกับรูป ปกติ (0,ความสูงของรูป) หรือ (ครึ่งหนึ่งความกว้างของรูป,ความสูงของรูป)  
                    // );                  
                    var my_Marker = new GGM.Marker({ // สร้างตัว marker  
                        position:markerLatLng,  // กำหนดไว้ที่เดียวกับจุดกึ่งกลาง  
                        icon: 'images/bus-stop-iconnn.png', // เปลี่ยนเป็น icon ตามรูปภาพที่ดึงจาก xml 
                        map: map, // กำหนดว่า marker นี้ใช้กับแผนที่ชื่อ instance ว่า map  
                        title:markerID // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ  
                    });  
                //  console.log($(this).find("id").text());  
            });  
        }     
    });   
 
}
$(function(){
    // โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
    // ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
    // v=3.2&sensor=false&language=th&callback=initialize
    //  v เวอร์ชัน่ 3.2
    //  sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
    //  language ภาษา th ,en เป็นต้น
    //  callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize
    $("<script/>", {
      "type": "text/javascript",
      src: "//maps.google.com/maps/api/js?v=3.2&sensor=false&language=th&callback=initialize"
    }).appendTo("body");    
});
</script>  
</body>
</html>