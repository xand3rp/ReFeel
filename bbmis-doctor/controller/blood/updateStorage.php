<?php
include("../connections.php");

parse_str($_POST["formdata"], $params);
$storageid = $params["chosenStorage"];
$serialNo = $params["bloodbag_underquarantine2"];

$updatebloodbag = mysqli_query($connections,"UPDATE tblbloodbag
                                           SET intBloodDispatchmentId = '1', intStorageId = '$storageid'
                                           WHERE strBloodBagSerialNo = '$serialNo' ");
echo '1';
 ?>
