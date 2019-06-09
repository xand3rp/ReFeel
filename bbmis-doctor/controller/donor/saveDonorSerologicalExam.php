<?php
include("../connections.php");
include("../checkSession.php");

parse_str(mysqli_real_escape_string($connections, $_POST["formdata"]), $params);
$id = $params['clientId_sero'];
$bloodbag = $params['bloodbag_underquarantine'];
settype($id,'int');
$date = $params["date_sero"];
$datenow = date('Y-m-d H:i:s');
$date_1 = new DateTime($date);
$datenow_1 = new DateTime($datenow);




$count_disease = mysqli_query($connections,"SELECT COUNT(intDiseaseId) AS Number_of_Diseases  FROM tbldisease WHERE stfDiseaseStatus = 'Active'");

while ($row = mysqli_fetch_assoc($count_disease)){
  $NumberOfDiseases = $row["Number_of_Diseases"];
}
if($date_1 <= $datenow_1){
if ($bloodbag != "No Available Blood Bag" && $bloodbag != ""){
  $bloodidQry = mysqli_query($connections,"SELECT intBloodBagId FROM tblbloodbag WHERE strBloodBagSerialNo = '$bloodbag'");
  while($blood = mysqli_fetch_assoc($bloodidQry)){
    $bloodid = $blood["intBloodBagId"];
  }
    for($i=1; $i<=$NumberOfDiseases; $i++){

      $phleb = $params["D_phlebotomist"];
      $remarks = $params["D_remarks"."$i"];
      $screener = $params["D_screener"."$i"];
      $verifier = $params["D_verifier"."$i"];
      settype($remarks,"float");
      //$option = $params["optradiosero"."$i"];

      $donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

      while($donation = mysqli_fetch_assoc($donationidqry)){
       $donation_id = $donation["intDonationId"];
            }

          if($remarks <= 1.0 AND $remarks >= 0.1){
            $option = 'Passed';
          }else {
            $option = 'Failed';
          }

           mysqli_query($connections, "INSERT INTO tblserologicalscreening(intDonationId,intBloodBagId,intDiseaseId,decDiseaseRemarks,strDiseaseScreener,strDiseaseVerifier,dtmDateScreened,strPhlebotomist,stfDonorSerologicalScreeningRemarks)
           VALUES ('$donation_id', '$bloodid', '$i', '$remarks', '$screener', '$verifier', '$date','$phleb', '$option')");

          }

          $checkiffalse = mysqli_query($connections,"SELECT * FROM tblserologicalscreening WHERE dtmDateScreened = '$date' AND stfDonorSerologicalScreeningRemarks = 'Failed' AND intDonationId = '$donation_id' ");

              if(mysqli_num_rows($checkiffalse) > 0){//if nagfail

                $updatebloodbag = mysqli_query($connections,"UPDATE tblbloodbag
                                                          SET stfIsBloodBagDiscarded = 'Yes', stfIsBloodBagExpired = 'Yes'
                                                          WHERE strBloodBagSerialNo = '$bloodbag' ");
                                                          mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete', stfDonationStatus = 'Able'  WHERE intDonationId = '$donation_id'");
                                                          mysqli_query($connections,"UPDATE tblclient SET stfClientCanDonate = 'No'  WHERE intClientId = '$id'");

                                                          $is_saved = mysqli_query($connections,"SELECT * FROM tblserologicalscreening WHERE intDonationId = '$donation_id'");

                                                          if(mysqli_num_rows($is_saved) > 0){//ICHECK KUNG NASAVE TALAGA
                                                            echo '3';//inserted
                                                        } elseif (mysqli_num_rows($is_saved) == 0) {
                                                          echo '1';//fail
                                                        }

              }else {//if di nagfail


                                                          $is_saved = mysqli_query($connections,"SELECT * FROM tblserologicalscreening WHERE intDonationId = '$donation_id'");

                                                          if(mysqli_num_rows($is_saved) > 0){//ICHECK KUNG NASAVE TALAGA
                                                            mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete', stfDonationStatus = 'Able'  WHERE intDonationId = '$donation_id'");
                                                            mysqli_query($connections,"UPDATE tblclient SET stfClientType = 'Donor'  WHERE intClientId = '$id'");
                                                            echo '4';
                                                        } elseif (mysqli_num_rows($is_saved) == 0) {
                                                          echo '1';//fail
                                                        }

              }




      }
else{
  echo '2';
}
}else{
  echo '5';
}

 ?>
