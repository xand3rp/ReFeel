<?php
include("../connections.php");

$fetchbloodbagrotten = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb
  JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
  JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId
  JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
  JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
  WHERE DATEDIFF(NOW(), tbb.dtmDateStored) > tp.intPreservativeLifespan
  ORDER BY tbb.dtmDateStored ASC ");

  // if there are rotten blood bags
  if (mysqli_num_rows($fetchbloodbagrotten) > 0 ){
    while ($row = mysqli_fetch_assoc($fetchbloodbagrotten)){
      $serialno = $row["strBloodBagSerialNo"];

      mysqli_query($connections, " UPDATE tblbloodbag SET stfIsBloodBagExpired = 'Yes' WHERE strBloodBagSerialNo = '$serialno' ");
    }
  }


$fetch_med = mysqli_query($connections,"SELECT * FROM tbldonation d JOIN tblclient c ON d.intClientId = c.intClientId JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
WHERE d.intDonationId NOT IN (SELECT intDonationId FROM tblmedicalexam WHERE stfAnswerRemarks = 'Wrong')
AND d.intDonationId NOT IN(SELECT intDonationId FROM tblphysicalexam)");

if (mysqli_num_rows($fetch_med) > 0 ){
  while ($row = mysqli_fetch_assoc($fetch_med)){
    $examid = $row["intDonationId"];
    $date = $row["dtmExamTaken"];

    $checkvalidity = mysqli_query($connections,"SELECT * FROM tblmedicalexam WHERE '$date' BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()
    AND intDonationId = '$examid'");

    if(mysqli_num_rows($checkvalidity) > 0){
      echo "Bamboozle";
    }else if (mysqli_num_rows($checkvalidity) == 0){
      mysqli_query($connections,"UPDATE tblmedicalexam SET stfAnswerRemarks = 'Expired' WHERE intDonationId = '$examid'");
      mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete', stfDonationStatus = 'Unable' WHERE intDonationId = '$examid'");
    }

  }
}
 ?>
