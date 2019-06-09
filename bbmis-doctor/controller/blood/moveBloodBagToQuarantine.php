<?php
include("../connections.php");

if($_POST["formdata"]){
  parse_str($_POST["formdata"], $params);
  $serial_no = $params['hidden_underqserialno'];
  $storage_id = $params["hidden_storageid"];
  // settype($storage_id, "int");
  // print_r($serial_no);
  // print_r($storage_id);
  //
  // mysqli_query($connections, " UPDATE tblbloodbag SET intStorageId = $storage_id WHERE strBloodBagSerialNo = '$serial_no' ");
  $check_ifbloodbaghasserologicalrecord = mysqli_query($connections, " SELECT * FROM tblserologicalscreening tss JOIN tblbloodbag tbb ON tss.intBloodBagId = tbb.intBloodBagId WHERE strBloodBagSerialNo = '$serial_no' ");
  $check_ifstorageisnotfull = mysqli_query($connections, " SELECT * FROM tblstorage WHERE intStorageId = $storage_id ");
  $fetch_totalbloodbags = mysqli_query($connections, " SELECT COUNT(strBloodBagSerialNo) as 'bloodbagcount' FROM tblbloodbag tbb JOIN tblstorage ts ON tbb.intStorageId = ts.intStorageId WHERE tbb.intStorageId = $storage_id ");
  $stg_count = mysqli_fetch_assoc($check_ifstorageisnotfull);
  $storagecount = $stg_count["intStorageCapacity"];
  $bb_count = mysqli_fetch_assoc($fetch_totalbloodbags);
  $bloodbagcount = $bb_count["bloodbagcount"];

  if($storagecount > $bloodbagcount){
    if(mysqli_num_rows($check_ifbloodbaghasserologicalrecord) > 0){
      mysqli_query($connections, " UPDATE tblbloodbag SET intStorageId = $storage_id WHERE strBloodBagSerialNo = '$serial_no' ");
      echo "1"; //success
    }
    else {
      echo "2"; //no record in sero
    }
  }
  else {
    echo "3"; // if storage is full
  }

}

 ?>
