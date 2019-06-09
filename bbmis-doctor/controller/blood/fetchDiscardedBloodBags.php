<?php
include "../connections.php";
$res = array();
$fetchDiscardedBloodBags = mysqli_query($connections, "SELECT * FROM tblbloodbag WHERE stfIsBloodBagDiscarded = 'Yes' ");

if (mysqli_num_rows($fetchDiscardedBloodBags) > 0) {
  while($row = mysqli_fetch_assoc($fetchDiscardedBloodBags)) {
    $res[] = $row;
  }
  echo json_encode($res);
} else {
  echo "1";
}
?>