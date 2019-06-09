<?php
include("../connections.php");
$donor_id = $_POST['donor_id'];
/*parse_str($_POST["formdata"], $params);
$date = $params["date_init"];*/

    $searchbloodbag = mysqli_query($connections,"SELECT *
                                                FROM tblbloodbag
                                                WHERE intBloodDispatchmentId = 3
                                                AND intClientId = '$donor_id' ");

              if(mysqli_num_rows($searchbloodbag)>0){
                    while($row = mysqli_fetch_assoc($searchbloodbag)){
                          $bloodID = $row['intBloodBagId'];
                          echo $bloodID;
                        }
              }else{
                  echo "No Available Blood Bag";
              }
?>
