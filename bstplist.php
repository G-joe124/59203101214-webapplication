<?php
header("Content-type:text/xml; charset=UTF-8");              
header("Cache-Control: no-store, no-cache, must-revalidate");             
header("Cache-Control: post-check=0, pre-check=0", false); 
include "dbconnect.php";
?>
<markers>
<?php
$q="SELECT * FROM bus_stop";
$result=$conn->query($q);
    while($row = $result->fetch_assoc()) {
    ?>
        <marker id="<?=$row['bus_stop']?>">
            <name><?=$row['bus_stopnme']?></name>
            <latitude><?=$row['lat']?></latitude>
            <longitude><?=$row['lng']?></longitude>
        </marker>
    <?php } ?>
</markers>