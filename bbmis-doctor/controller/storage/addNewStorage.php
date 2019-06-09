<?php
include("../connections.php");
include("../sanitize.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$storagename = $params["newBloodStorageName"];
$storagetype = $params["sel_storagetype"];
$storagecapacity = $params["newBloodStorageCapacity"];
$active_storage = "Active";
$sanitized_storagename = sanitize($storagename);

if($sanitized_storagename && $storagetype && $storagecapacity){

    $viewStoragename = mysqli_query($connections,"SELECT *
                              FROM tblstorage
                              WHERE strStorageName  LIKE '%$sanitized_storagename%' ");

    if(mysqli_num_rows($viewStoragename) <= 0){//if di nageexist yung storage
      mysqli_query($connections,"INSERT INTO tblstorage(intStorageTypeId, strStorageName, intStorageCapacity, stfStorageStatus) VALUES ((SELECT intStorageTypeId FROM tblstoragetype WHERE strStorageType = '$storagetype'), '$sanitized_storagename', '$storagecapacity', '$active_storage')");
      echo "1";
    }
    elseif (mysqli_num_rows($viewStoragename) > 0) {//if nageexist yung storage
      echo "2";
    }

}
else if ( isset($storagetype) == false ){
  echo "3"; // if storage type is not set
}
else if ($sanitized_storagename && $storagetype){
  echo "4"; // if storage cap not set
}
else {
  echo "5";
}
?>
