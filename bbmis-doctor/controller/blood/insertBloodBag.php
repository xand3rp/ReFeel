<?php
include("../connections.php");
parse_str(mysqli_real_escape_string($connections, $_POST["formdata"]), $params);
function sanitize($string){
  return filter_var($string,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
$bloodid = $params["bloodserial"];
settype($bloodid,'int');
//$bloodtype = $params["bloodtype"];
//$bloodstorage = $params["bloodstorage"];
$donorname = $params["donorname"];
$storage = $params["chosenStorage"];
$preservative = $params["chosenPreservative"];
//$volume = $params["bloodvolume"];
$sanitized_serialno = sanitize($bloodid);

if($sanitized_serialno && $donorname){


$check_ifseroremaining = mysqli_query($connections,"SELECT *
FROM tblclient c
LEFT JOIN tblbloodbag bb ON c.intClientId = bb.intClientId JOIN tbldonation d ON d.intClientId = c.intClientId
WHERE c.intClientId NOT IN (SELECT intClientId from tblbloodbag where stfIsBloodBagExpired = 'No')
AND  stfDonationRemarks = 'Incomplete'
AND stfDonationStatus = 'Able'
AND CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) LIKE '$donorname'
");

$viewbloodbagserial = mysqli_query($connections,"SELECT *
  FROM tblbloodbag
  WHERE strBloodBagSerialNo = '$sanitized_serialno' ");

$viewdonorwithnobloodbagrecord = mysqli_query($connections,"SELECT *
FROM tblclient c
LEFT JOIN tblbloodbag bb ON c.intClientId = bb.intClientId
WHERE c.intClientId NOT IN (SELECT intClientId from tblbloodbag where stfIsBloodBagExpired = 'No')
AND CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) LIKE '%$donorname%'");

$viewdonor = mysqli_query($connections,"SELECT intClientId
FROM tblclient
WHERE strClientFirstName  LIKE '%$donorname%' OR strClientMiddleName LIKE '%$donorname%' OR strClientLastName LIKE '%$donorname%' OR CONCAT(strClientFirstName, ' ', strClientLastName) LIKE '%$donorname%' OR CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) LIKE '%$donorname%'");

while($row = mysqli_fetch_assoc($viewdonor)){
$id = $row['intClientId'];
 }

$donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

$viewbloodtype = mysqli_query($connections,"SELECT bt.intBloodTypeId
FROM tblbloodtype bt JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
WHERE  c.intClientId = $id ");


$viewdonorbloodtype = mysqli_query($connections,"SELECT bt.intBloodTypeId
FROM tblbloodtype bt JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
WHERE  c.intClientId = $id AND bt.intBloodTypeId = '1'");

$check_ifmayspacepa = mysqli_query($connections,"SELECT COUNT(intBloodBagId) AS bloodcount FROM tblbloodbag WHERE intBloodDispatchmentId = '1' AND stfIsBloodBagExpired = 'No' AND intStorageId = '$storage'");
$getcapacity = mysqli_query($connections,"SELECT intStorageCapacity FROM tblstorage WHERE intStorageId = '$storage'");

while ($row2 = mysqli_fetch_assoc($check_ifmayspacepa)) {
  $bloodbagcount = $row2["bloodcount"];
  settype($bloodbagcount,"int");
}
while($row3 = mysqli_fetch_assoc($getcapacity)){
  $storagecapacity = $row3["intStorageCapacity"];
  settype($storagecapacity,"int");
}
// while($donation = mysqli_fetch_assoc($donationidqry)){
//   $donation_id = $donation["intDonationId"];
//   settype($donation_id,"int");
// }
if(mysqli_num_rows($donationidqry) > 0){
  while($donation = mysqli_fetch_assoc($donationidqry)){
   $donation_id = $donation["intDonationId"];
  }}else{
    $donation_id = null;
  }
$getVolumeqry = mysqli_query($connections,"SELECT intBloodVolumeId FROM tblphysicalexam WHERE intDonationId = '$donation_id' ");
if(mysqli_num_rows($getVolumeqry) > 0){
while($row4 = mysqli_fetch_assoc($getVolumeqry)){
  $volume = $row4['intBloodVolumeId'];
}
}else{

}

      if($bloodbagcount < $storagecapacity){
               if(mysqli_num_rows($viewdonorwithnobloodbagrecord) >= 1 AND mysqli_num_rows($viewbloodbagserial) == 0 AND mysqli_num_rows($viewdonorbloodtype) == 0 AND mysqli_num_rows($viewdonor)>=1 AND mysqli_num_rows($check_ifseroremaining) > 0 AND mysqli_num_rows($getVolumeqry) > 0){

                      while ($row4 = mysqli_fetch_assoc($viewbloodtype)) {
                      $bloodtype_ID = $row4["intBloodTypeId"];
                      }
                  mysqli_query($connections,"INSERT INTO tblbloodbag(strBloodBagSerialNo, intStorageId,intClientId, intBloodTypeId ,intBloodDispatchmentId, intBloodVolumeId,	intPreservativeId,stfIsBloodBagExpired,stfIsBloodBagDiscarded) VALUES ('$sanitized_serialno','$storage','$id','$bloodtype_ID','1','$volume','$preservative','No','No')");


                    echo "1";//if succesful at may record yung donorname na nilagay at di umulit yung serial
            }elseif (mysqli_num_rows($viewdonorbloodtype) > 0) {
              echo "2";//if wala pang bloodtype
            }else if (mysqli_num_rows($viewbloodbagserial) > 0) {
              echo "3";//if umulit yung serial
            }elseif (mysqli_num_rows($viewdonorwithnobloodbagrecord) == 0) {
              echo "4";//if may bloodbag na yung donor
            }else if (mysqli_num_rows($viewdonor) == 0) {
              echo "5"; //if wala pang record yung donor
            }else if(mysqli_num_rows($check_ifseroremaining) == 0){
              echo "6";//if wala pa record
            }else if(mysqli_num_rows($getVolumeqry) == 0){
            echo "7";//if walang physexam na may bloodvolume
            }else {
              echo "8";//if puno na yung underquarantine
            }
      }
      else {
        echo "10";
      }
    }
else{
  echo "9";//if di kumpleto o may mali sa ininsert na data
}
?>
