<?php
header("Content-type:text/xml; charset=UTF-8");              
header("Cache-Control: no-store, no-cache, must-revalidate");             
header("Cache-Control: post-check=0, pre-check=0", false); 
include "dbconnect.php";
?>
<markers>
<?php
$q="SELECT * FROM bus WHERE statuss = 1";
$result=$conn->query($q);
    while($row = $result->fetch_assoc()) {
    ?>
        <marker id="<?=$row['busno']?>">
            <latitude><?=$row['lat_now']?></latitude>
            <longitude><?=$row['lng_now']?></longitude>
        </marker>
    <?php } ?>
</markers>