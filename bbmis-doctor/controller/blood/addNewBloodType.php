<?php
include("../connections.php");
include("../sanitize.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$btname = $params["newBloodTypeName"];
$btrhesus = $params["newBloodRhesusName"];
$sanitized_bloodtypename = sanitize($btname);
// $sanitized_rhesus = sanitize($btrhesus);
if($sanitized_bloodtypename){

    $viewbtname = mysqli_query($connections,"SELECT *
                              FROM tblbloodtype
                              WHERE stfBloodType  LIKE '%$sanitized_bloodtypename%'
                              AND stfBloodTypeRhesus LIKE '%$btrhesus%' ");

    if(mysqli_num_rows($viewbtname) <= 0){//if di nageexist yung blood component

      mysqli_query($connections,"INSERT INTO tblbloodtype(stfBloodType,stfBloodTypeRhesus) VALUES ('$sanitized_bloodtypename','$btrhesus')");
      echo "1";
    }
    elseif (mysqli_num_rows($viewbtname) > 0) {//if ] nageexist yung blood component
      echo "2";
    }

}
else {
  echo "3";
}
?>
