<?php
include("connections.php");

// fetch numbers that will be used to compare to dates
// $fetch_bloodstatus = mysqli_query($connections, " SELECT * FROM tblpreservatives tp JOIN tblbloodbag tbb ON tp.intPreservativeId = tbb.intPreservativeId");
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


//notification query
$getnotificationdetailsrotten = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE DATEDIFF(NOW(), tbb.dtmDateStored) > tp.intPreservativeLifespan AND stfIsBloodBagExpired = 'Yes' AND stfIsBloodBagDiscarded = 'No'  " );
$getnotificationdetailsalmostrotten = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE DATEDIFF(NOW(), tbb.dtmDateStored) < intPreservativeLifespan AND DATEDIFF(NOW(), tbb.dtmDateStored) > intPreservativeCriticalPercentage AND intBloodDispatchmentId = 1 AND stfIsBloodBagExpired = 'No' ");
$getnotificationincomplete = mysqli_query($connections, " SELECT DISTINCT(td.intClientId), strClientFirstName, strClientMiddleName, strClientLastName FROM tbldonation td JOIN tblclient tcc ON td.intClientId = tcc.intClientId WHERE stfDonationRemarks = 'Incomplete' ");
$getnotificationeditrequest = mysqli_query($connections, " SELECT * FROM tblrequest tr JOIN tblclient tcc ON tr.intClientId = tcc.intClientId WHERE stfRequestStatus = 'Requested' AND stfUpdateStatus = 'Not Updated' AND stfRequestFeedback = 'Unnotified' ");
$getnotificationuncheckedsurvey = mysqli_query($connections, " SELECT DISTINCT(d.intDonationId), c.intClientId, CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) AS Applicant_DonorName
                                                FROM tbldonation d JOIN tblclient c ON d.intClientId = c.intClientId JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
                                                WHERE stfAnswerRemarks = 'Unchecked'
                                                AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 4 DAY) AND NOW() ");
$output = '
<h6 class="dropdown-header" style="font-weight: 600;">Notifications</h6>

';
while($rowalmostrotten = mysqli_fetch_assoc($getnotificationdetailsalmostrotten)){

  $serialnoalmostrotten = $rowalmostrotten["strBloodBagSerialNo"];
  $getnotificationdetailsalmostrottenbb = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE DATEDIFF(NOW(), tbb.dtmDateStored) < intPreservativeLifespan AND DATEDIFF(NOW(), tbb.dtmDateStored) > intPreservativeCriticalPercentage AND intBloodDispatchmentId = 1 AND stfIsBloodBagExpired = 'No' AND strBloodBagSerialNo = '$serialnoalmostrotten' ");

  while($rowalmostrottenbb = mysqli_fetch_assoc($getnotificationdetailsalmostrottenbb)){
    $output .= "
    <li class='p-1'>
    <a href='#' style='list-style: none; text-decoration: none; color: black;'>
    <strong>$serialnoalmostrotten</strong><br>
    <small>This blood bag is about to expire</small>
    </a>
    </li>
    <div class='dropdown-divider'></div>
    ";
  }

}
while($rowrotten = mysqli_fetch_assoc($getnotificationdetailsrotten)){
  $serialnorotten = $rowrotten["strBloodBagSerialNo"];

  $getnotificationdetailsrottenbb = mysqli_query($connections, " SELECT COUNT(*) as countrotten FROM tblbloodbag tbb JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE DATEDIFF(NOW(), tbb.dtmDateStored) > tp.intPreservativeLifespan AND stfIsBloodBagExpired = 'Yes' AND stfIsBloodBagDiscarded = 'No' AND strBloodBagSerialNo = '$serialnorotten' " );
  if (mysqli_num_rows($getnotificationdetailsrottenbb) > 0){
    while ( $rowrottenbb = mysqli_fetch_assoc($getnotificationdetailsrottenbb)){
      $output .= "
      <li class='p-1'>
      <a href='#' style='list-style: none; text-decoration: none; color: black;'>
      <strong>$serialnorotten</strong><br>
      <small>This blood bag is expired.</small>
      </li>
      <div class='dropdown-divider'></div>
      ";
    }
  }
}
while($rowincomplete = mysqli_fetch_assoc($getnotificationincomplete)){
  $clientfirstname = $rowincomplete["strClientFirstName"];
  $clientmiddlename = $rowincomplete["strClientMiddleName"];
  $clientlastname = $rowincomplete["strClientLastName"];
  $output .= "
  <li class='p-1'>
  <a type='btn' href='#' style='list-style: none; text-decoration: none; color: black;'>
  <strong>Incomplete</strong><br>
  <small>$clientfirstname $clientmiddlename $clientlastname hasn't completed his exams</small>
  </li>
  <div class='dropdown-divider'></div>
  ";
}
while($roweditrequests = mysqli_fetch_assoc($getnotificationeditrequest)){
  $clientfirstname = $roweditrequests["strClientFirstName"];
  $clientmiddlename = $roweditrequests["strClientMiddleName"];
  $clientlastname = $roweditrequests["strClientLastName"];
  $output .= "
  <li class='p-1'>
  <a href='#' style='list-style: none; text-decoration: none; color: black;'>
  <strong>Update request</strong><br>
  <small>$clientfirstname $clientmiddlename $clientlastname requested for an update</small>
  </li>
  <div class='dropdown-divider'></div>
  ";
}
while($rowuncheckedsurvey = mysqli_fetch_assoc($getnotificationuncheckedsurvey)){
  $fullname = $rowuncheckedsurvey['Applicant_DonorName'];
  $output .= "
  <li class='p-1'>
  <a href='#' style='list-style: none; text-decoration: none; color: black;'>
  <strong>Check survey</strong><br>
  <small>$fullname's survey is still not checked</small>
  </li>
  <div class='dropdown-divider'></div>
  ";
}
// $output .= "</ul>";
if (mysqli_num_rows($getnotificationdetailsrotten) > 0 && mysqli_num_rows($getnotificationdetailsalmostrotten) > 0 && mysqli_num_rows($getnotificationincomplete) > 0 && mysqli_num_rows($getnotificationeditrequest) > 0 && mysqli_num_rows($getnotificationuncheckedsurvey)) {
  echo "1";
} else {
  echo $output;
}


?>
