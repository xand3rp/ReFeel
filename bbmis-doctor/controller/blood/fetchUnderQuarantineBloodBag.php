<?php
include("../connections.php");
$donor_id = $_POST['clientid'];
/*parse_str($_POST["formdata"], $params);
$date = $params["date_init"];*/



    $searchbloodbag = mysqli_query($connections,"SELECT *
                                                FROM tblbloodbag bb JOIN tblstorage s ON bb.intStorageId = s.intStorageId
                                                WHERE intStorageTypeId = 1
                                                AND intClientId = '$donor_id' ");



              if(mysqli_num_rows($searchbloodbag)>0){
                    while($row = mysqli_fetch_assoc($searchbloodbag)){
                          $bloodID = $row['strBloodBagSerialNo'];
                          echo $bloodID;
                        }
              }else{
                  echo "No Available Blood Bag";
              }
?>
