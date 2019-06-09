<?php
include("connections.php");

// fetch numbers that will be used to compare to dates
// $fetch_statusgood = mysqli_query($connections, " SELECT * FROM tblbloodstatus WHERE intBloodStatusId = 1 ");
// while ($row_statusgood = mysqli_fetch_assoc($fetch_statusgood)){
//   $good_beginday = $row_statusgood["intStartDayRange"];
//   $good_endday = $row_statusgood["intEndDayRange"];
//   settype($good_beginday, "int");
//   settype($good_endday, "int");
// }
// $fetch_statusmedium = mysqli_query($connections, " SELECT * FROM tblbloodstatus WHERE intBloodStatusId = 2 ");
// while ($row_statusmedium = mysqli_fetch_assoc($fetch_statusmedium)){
//   $medium_beginday = $row_statusmedium["intStartDayRange"];
//   $medium_endday = $row_statusmedium["intEndDayRange"];
//   settype($medium_beginday,"int");
//   settype($medium_endday,"int");
// }
// $fetch_statuscritical = mysqli_query($connections, " SELECT * FROM tblbloodstatus WHERE intBloodStatusId = 3 ");
// while($row_statuscritical = mysqli_fetch_assoc($fetch_statuscritical)){
//   $critical_beginday = $row_statuscritical["intStartDayRange"];
//   $critical_endday = $row_statuscritical["intEndDayRange"];
//   settype($critical_beginday,"int");
//   settype($critical_endday,"int");
// }
// notifications query
$countbloodbagrotten = mysqli_query($connections, " SELECT COUNT(*) as countrotten FROM tblbloodbag tbb JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE DATEDIFF(NOW(), tbb.dtmDateStored) > tp.intPreservativeLifespan AND stfIsBloodBagExpired = 'Yes' AND stfIsBloodBagDiscarded = 'No' " );
$countbloodbagalmostrotten = mysqli_query($connections, " SELECT COUNT(*) as countalmostrotten FROM tblbloodbag tbb JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId WHERE DATEDIFF(NOW(), tbb.dtmDateStored) < intPreservativeLifespan AND DATEDIFF(NOW(), tbb.dtmDateStored) > intPreservativeCriticalPercentage AND intBloodDispatchmentId = 1 AND stfIsBloodBagExpired = 'No' ");
$countincompleteremarks = mysqli_query($connections, " SELECT COUNT(DISTINCT(intClientId)) as countincomplete FROM tbldonation WHERE stfDonationRemarks = 'Incomplete' ");
$counteditrequests = mysqli_query($connections, " SELECT COUNT(*) as counteditrequests
            FROM tblrequest
            WHERE stfRequestStatus = 'Requested' AND stfUpdateStatus = 'Not Updated' AND stfRequestFeedback = 'Unnotified' ");
$countuncheckedsurvey = mysqli_query($connections, " SELECT DISTINCT(d.intDonationId), c.intClientId, CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) AS Applicant_DonorName
                                                FROM tbldonation d JOIN tblclient c ON d.intClientId = c.intClientId JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
                                                WHERE stfAnswerRemarks = 'Unchecked'
                                                AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 4 DAY) AND NOW() ");
$ctruncheckedsurvey = 0;
while($rowrotten = mysqli_fetch_assoc($countbloodbagrotten)){
  $ctrrotten = $rowrotten["countrotten"];
}
while($rowalmostrotten = mysqli_fetch_assoc($countbloodbagalmostrotten)){
  $ctralmostrotten = $rowalmostrotten["countalmostrotten"];
}
while($rowincomplete = mysqli_fetch_assoc($countincompleteremarks)){
  $ctrincomplete = $rowincomplete["countincomplete"];
}
while($roweditrequests = mysqli_fetch_assoc($counteditrequests)){
  $ctreditrequests = $roweditrequests["counteditrequests"];
}
while($rowuncheckedsurvey = mysqli_fetch_assoc($countuncheckedsurvey)){
  $ctruncheckedsurvey = $ctruncheckedsurvey + 1;
}
echo $ctralmostrotten + $ctrrotten + $ctrincomplete + $ctreditrequests + $ctruncheckedsurvey;

?>
