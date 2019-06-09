<?php
include("../connections.php");
include("../checkSession.php");
parse_str(mysqli_real_escape_string($connections, $_POST["formdata"]), $params);
$id = $params['clientId_phys'];
settype($id,'int');
$weight = $params['donorweight'];
$Bp_s = $params['donorbloodpressure_systole'];
$Bp_d = $params['donorbloodpressure_diastole'];
$Pr = $params['donorpulserate'];
$Temp = $params['donortemperature'];
$GenApp = $params['donorgenapp'];
$heent = $params['donorheent'];
$HnL = $params['donorheartlungs'];
$remarks = $params['examremarks'];
$date = $params['date_phys'];
$datenow = date('Y-m-d H:i:s');
$date_1 = new DateTime($date);
$datenow_1 = new DateTime($datenow);

//

$reason = $params['reasonfordeferal'];
$instruction = $params['instruction'];

//$curdate = date("Y/m/d");
$donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

while($donation = mysqli_fetch_assoc($donationidqry)){
 $donation_id = $donation["intDonationId"];
}

if($date_1 <= $datenow_1){
if ($weight && $Bp_s && $Bp_d && $Pr && $Temp && $GenApp && $heent && $HnL ){
      if($remarks == 'Temporarily Deferred' || $remarks == 'Permanently Deferred'){
          $savedefferal  =  mysqli_query($connections,"INSERT INTO tbldeferral (intClientId,	txtDeferralReason,	txtDeferralInstructions)
                                      VALUES ('$id','$reason','$instruction') ");

          $getdeferralid = mysqli_query($connections,"SELECT * FROM tbldeferral
                                                                WHERE intClientId = '$id'
                                                                ORDER BY intDeferralId DESC LIMIT 1");
          while ($row = mysqli_fetch_assoc($getdeferralid)) {
            $defferalID = $row["intDeferralId"];
          }
            $status = 'Failed';

           mysqli_query($connections, "INSERT INTO tblphysicalexam(intDonationId,intEmployeeId, decClientWeight, strClientBloodPressure, strClientPulseRate, decClientTemperature, txtClientGenAppearance, txtClientHEENT, txtClientHeartLungs,stfMedicalStatRemarks, dtmExamTaken,intDeferralId,stfClientPhysicalExamRemarks)
           VALUES ('$donation_id','$varEmpId','$weight', '$Bp_s/$Bp_d', '$Pr', '$Temp', '$GenApp', '$heent', '$HnL','$remarks','$date','$defferalID','$status')");

           $is_saved = mysqli_query($connections,"SELECT * FROM tblphysicalexam WHERE intDonationId = '$donation_id'");

           if(mysqli_num_rows($is_saved) > 0){//ICHECK KUNG NASAVE TALAGA
             mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");
             if($remarks == 'Permanently Deferred'){
             mysqli_query($connections,"UPDATE tblclient SET stfClientCanDonate = 'No' WHERE intClientId = '$id'");
             echo '4';
             }else{

             }
           echo '2';
         } elseif (mysqli_num_rows($is_saved) == 0) {
           echo '3';
         }

      }//end of if remarks is deffered
      else if($remarks == 'Accepted'){
          $amount = $params['bloodamount'];

          $volumeIdqry = mysqli_query($connections,"SELECT * FROM `tblbloodvolume` WHERE `intBloodVolume` = '$amount'");
          while ($row2 = mysqli_fetch_assoc($volumeIdqry)) {
            // code...
            $volumeid = $row2['intBloodVolumeId'];
          }

          $status = 'Passed';
          mysqli_query($connections, "INSERT INTO tblphysicalexam(intDonationId,intEmployeeId, decClientWeight, strClientBloodPressure, strClientPulseRate, decClientTemperature, txtClientGenAppearance, txtClientHEENT, txtClientHeartLungs,stfMedicalStatRemarks, dtmExamTaken,intBloodVolumeId,stfClientPhysicalExamRemarks)
          VALUES ('$donation_id','$varEmpId','$weight', '$Bp_s/$Bp_d', '$Pr', '$Temp', '$GenApp', '$heent', '$HnL','$remarks','$date','$volumeid','$status')");

          $is_saved = mysqli_query($connections,"SELECT * FROM tblphysicalexam WHERE intDonationId = '$donation_id'");

          if(mysqli_num_rows($is_saved) > 0){//ICHECK KUNG NASAVE TALAGA
          echo '1';
        } elseif (mysqli_num_rows($is_saved) == 0) {
          echo '3';
        }


      }

}
else{
  echo 3;//if may kulang sa input
}
}
else{
  echo 5;
}

 ?>
