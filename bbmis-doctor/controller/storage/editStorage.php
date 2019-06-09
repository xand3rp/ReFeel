<?php
include("../connections.php");
include("../sanitize.php");

parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$bloodstorageid = $params["bloodstorage_ID"];
$bloodstoragename = $params["editBloodStorageName"];
$bloodstoragecapacity = $params["editBloodStorageCapacity"];
$sanitized_storagename = sanitize($bloodstoragename);
if($bloodstorageid && $sanitized_storagename && $bloodstoragecapacity){

  $count_bloodbagsinstorage = mysqli_query($connections, " SELECT COUNT(strBloodBagSerialNo) as 'bloodbagcount' FROM tblbloodbag WHERE intStorageId = $bloodstorageid ");
  $row = mysqli_fetch_assoc($count_bloodbagsinstorage);
  $bloodbagcount = $row["bloodbagcount"];
  $viewstorage = mysqli_query($connections,"SELECT * FROM tblstorage WHERE strStorageName LIKE '$sanitized_storagename' ");
  // if storage already exists
  if(mysqli_num_rows($viewstorage) <= 0){
    if ($bloodbagcount > $bloodstoragecapacity){
      echo "4"; // storage capacity is lower than current blood bag count
    }
    else if ($bloodbagcount == $bloodstoragecapacity){
      echo "5";
    }
    else if ($bloodbagcount < $bloodstoragecapacity){
      mysqli_query($connections,"UPDATE tblstorage SET strStorageName = '$sanitized_storagename', intStorageCapacity = '$bloodstoragecapacity' WHERE intStorageId = '$bloodstorageid'");
      echo "1";
    }
  }
  elseif (mysqli_num_rows($viewstorage) > 0) {//if ] nageexist yung blood component
    mysqli_query($connections,"UPDATE tblstorage SET intStorageCapacity = '$bloodstoragecapacity' WHERE intStorageId = '$bloodstorageid'");
    echo "2";
  }

}
else {
  echo "3";
}
?>
