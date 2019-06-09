<?php
include("../connections.php");

if($_POST["storage_id"]){
  $storage_id = $_POST["storage_id"];
  settype($storage_id, "int");

  // fetch numbers that will be used to compare to dates
  // $fetch_bloodstatus = mysqli_query($connections, " SELECT * FROM tblpreservatives tp JOIN tblbloodbag tbb ON tp.intPreservativeId = tbb.intPreservativeId ");
  // while($row = mysqli_fetch_assoc($fetch_bloodstatus)){
  //   $bloodbaglifespan = $row["intPreservativeLifespan"];
  //   $freshbloodbag = $row["intPreservativeFreshPercentage"];
  //   $mediumbloodbag = $row["intPreservativeNeutralPercentage"];
  //   $criticalbloodbag = $row["intPreservativeCriticalPercentage"];
  // }
  // settype($bloodbaglifespan, "int");
  // settype($freshbloodbag, "int");
  // settype($mediumbloodbag, "int");
  // settype($criticalbloodbag, "int");
  //
  // $fresh_percentage = $freshbloodbag / 100;
  // $medium_percentage = $mediumbloodbag / 100;
  // $critical_percentage = $criticalbloodbag / 100;
  //
  // $fresh_lifespan = $bloodbaglifespan * $fresh_percentage;
  // settype($fresh_lifespan, "int");
  // $medium_lifespan = $bloodbaglifespan * $medium_percentage;
  // settype($medium_lifespan, "int");
  // $critical_lifespan = $bloodbaglifespan * $critical_percentage;
  // settype($critical_lifespan, "int");

  $fetchbloodbagtypeab = mysqli_query($connections, " SELECT strBloodBagSerialNo, dtmDateStored, stfBloodType, stfBloodTypeRhesus, intBloodVolume, intPreservativeLifespan, TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(dtmDateStored, INTERVAL intPreservativeLifespan DAY)) AS 'Days Remaining' FROM tblbloodbag tbb
    JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
    JOIN tblstorage ts ON tbb.intStorageId = ts.intStorageId
    JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId
    JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
    JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
    WHERE tbb.intStorageId = $storage_id AND tbt.stfBloodType = 'AB' AND tbb.intBloodDispatchmentId = 1 AND tbb.stfIsBloodBagExpired = 'No' AND tbb.stfIsBloodBagDiscarded = 'No' AND DATEDIFF(NOW(), tbb.dtmDateStored) <= tp.intPreservativeLifespan ORDER BY 7 ASC ");
  $fetchbloodbagrotten = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb
        JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
        JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId
        JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
        JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
        WHERE tbb.intStorageId = $storage_id AND tbt.stfBloodType = 'AB' AND DATEDIFF(NOW(), tbb.dtmDateStored) > tp.intPreservativeLifespan
        ORDER BY tbb.dtmDateStored ASC ");
    //count query for blood BAGS
  $countbloodbagtypeab = mysqli_query($connections, " SELECT COUNT(strBloodBagSerialNo) as total FROM tblbloodbag tbb
  JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
  JOIN tblstorage ts ON tbb.intStorageId = ts.intStorageId
  JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
  WHERE tbb.intStorageId = $storage_id AND tbt.stfBloodType = 'AB' AND tbb.intBloodDispatchmentId = 1 AND stfIsBloodBagExpired = 'No' ");
    $row = mysqli_fetch_assoc($countbloodbagtypeab);
    $total = $row["total"];
    $output =
    "
    <h4>Blood Type AB</h4>
    <p><small style='color: rgb(150,150,150)'>Blood Bags: $total</small>
    </p>
    <hr style='background-color: rgb(231, 0, 62); '>
    ";
    $output .= "<div class='row'>";

    if(mysqli_num_rows($fetchbloodbagtypeab) > 0 ) {
      while($row = mysqli_fetch_assoc($fetchbloodbagtypeab)){
        $datestored = $row["dtmDateStored"];
        $serialno = $row["strBloodBagSerialNo"];
        $rhesus = $row["stfBloodTypeRhesus"];
        $volume = $row["intBloodVolume"];
        $daysremaining = $row["Days Remaining"];

        $fetchbloodbagcritical = mysqli_query($connections, " SELECT strBloodBagSerialNo, dtmDateStored, stfBloodType, stfBloodTypeRhesus, intBloodVolume, intPreservativeLifespan, TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(dtmDateStored, INTERVAL intPreservativeLifespan DAY)) AS 'Days Remaining' FROM tblbloodbag tbb
          JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
          JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId
          JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
          JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
          WHERE tbb.intStorageId = $storage_id AND tbt.stfBloodType = 'AB' AND DATEDIFF(NOW(), tbb.dtmDateStored) >= tp.intPreservativeCriticalPercentage AND DATEDIFF(NOW(), tbb.dtmDateStored) <= tp.intPreservativeLifespan
          AND strBloodBagSerialNo = '$serialno'
          ORDER BY tbb.dtmDateStored ASC ");
        $fetchbloodbagmedium = mysqli_query($connections, " SELECT strBloodBagSerialNo, dtmDateStored, stfBloodType, stfBloodTypeRhesus, intBloodVolume, TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(dtmDateStored, INTERVAL intPreservativeLifespan DAY)) AS 'Days Remaining' FROM tblbloodbag tbb
          JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
          JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId
          JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
          JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
          WHERE tbb.intStorageId = $storage_id AND tbt.stfBloodType = 'AB' AND DATEDIFF(NOW(), tbb.dtmDateStored) < tp.intPreservativeCriticalPercentage AND DATEDIFF(NOW(), tbb.dtmDateStored) > tp.intPreservativeFreshPercentage
          AND strBloodBagSerialNo = '$serialno'
          ORDER BY tbb.dtmDateStored ASC ");
        $fetchbloodbagfresh = mysqli_query($connections, " SELECT strBloodBagSerialNo, dtmDateStored, stfBloodType, stfBloodTypeRhesus, intBloodVolume, TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(dtmDateStored, INTERVAL intPreservativeLifespan DAY)) AS 'Days Remaining' FROM tblbloodbag tbb
          JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
          JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId
          JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
          JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
          WHERE tbb.intStorageId = $storage_id AND tbt.stfBloodType = 'AB' AND DATEDIFF(NOW(), tbb.dtmDateStored) <= tp.intPreservativeFreshPercentage AND DATEDIFF(NOW(), tbb.dtmDateStored) >= 0
          AND strBloodBagSerialNo = '$serialno'
          ORDER BY tbb.dtmDateStored ASC ");


          //blood bags are arranged according to their status (critical first, medium fresh second and lastly, the fresh)
          if (mysqli_num_rows($fetchbloodbagcritical) > 0 ){
            $output .= "
            <div class='col-md-2'>
            <button type='button' class='btn btn-danger btn_stock btn-block btn-lg mt-3' id=$serialno data-id=$serialno data-toggle='modal' data-target='#modal_selectedstorage'><small>$serialno<br>$volume cc<br>$rhesus<br>$daysremaining Days Remaining</small></button>
            </div>
            ";
          }
          else if (mysqli_num_rows($fetchbloodbagmedium) > 0 ){
            $output .= "
            <div class='col-md-2'>
            <button type='button' class='btn btn-warning btn_stock btn-block btn-lg mt-3' id=$serialno data-id=$serialno data-toggle='modal' data-target='#modal_selectedstorage'><small>$serialno<br>$volume cc<br>$rhesus<br>$daysremaining Days Remaining</small></button>
            </div>
            ";
          }
          else if (mysqli_num_rows($fetchbloodbagfresh) > 0 ){
            $output .= "
            <div class='col-md-2'>
            <button type='button' class=' btn btn-success btn_stock btn-block btn-lg mt-3' id=$serialno data-id=$serialno data-toggle='modal' data-target='#modal_selectedstorage'><small>$serialno<br>$volume cc<br>$rhesus<br>$daysremaining Days Remaining</small></button>
            </div>
            ";
          }
      }
      $output .= "</div>";
      echo $output;
    }
    else {
      $output .=
      "
        <h3 class='mx-auto text-center'>No Blood bags</h3>
      </div>
      ";
      echo $output;
    }
    // if there are rotten blood bags
    if (mysqli_num_rows($fetchbloodbagrotten) > 0 ){
      while ($row = mysqli_fetch_assoc($fetchbloodbagrotten)){
        $serialno = $row["strBloodBagSerialNo"];

        mysqli_query($connections, " UPDATE tblbloodbag SET stfIsBloodBagExpired = 'Yes' WHERE strBloodBagSerialNo = '$serialno' ");
      }
    }

}
 ?>
