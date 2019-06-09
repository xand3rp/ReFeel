<?php
include("../connections.php");
include("../checkSession.php");
parse_str(mysqli_real_escape_string($connections, $_POST["formdata"]), $params);
$date = $params["date_init"];
//$newdate = date_format($date,"Y/m/d");
$datenow = date('Y-m-d H:i:s');
$date_1 = new DateTime($date);
$datenow_1 = new DateTime($datenow);


$count_components = mysqli_query($connections,"SELECT intBloodComponentId, decMaleLeastVal,decMaleMaxVal,decFemaleLeastVal,decFemaleMaxVal FROM tblbloodcomponent WHERE stfBloodComponentStatus = 'Active'");


//}
if($date_1 <= $datenow_1){
if ($date){
    //for($i=1; $i<=$NumberOfComponents; $i++){
    while ($row = mysqli_fetch_assoc($count_components)){
      //$NumberOfComponents = $row["Number_of_Components"];
      $i = $row['intBloodComponentId'];
      $maleleast = $row['decMaleLeastVal'];
      settype($maleleast,'float');
      $malemax = $row['decMaleMaxVal'];
      settype($malemax,'float');
      $femaleleast = $row['decFemaleLeastVal'];
      settype($femaleleast,'float');
      $femalemax = $row['decFemaleMaxVal'];
      settype($femalemax,'float');
      $id = $params['clientId_init'];
      settype($id,'int');
      $result= $params["BC_result"."$i"];
        settype($result,'float');
      //$remarks = $params["BC_remarks"."$i"];
      $screener = $params["BC_screener"."$i"];
      $verifier = $params["BC_verifier"."$i"];


    //fetchlatestdonation-----------------------------------------------------------------
          $donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$id' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

          while($donation = mysqli_fetch_assoc($donationidqry)){
           $donation_id = $donation["intDonationId"];
          }
    //-------------------------------------------------------------------------------------
    //fetchDonorSex-----------------------------------------------------------------
          $fetchDonorSex = mysqli_query($connections,"SELECT stfClientSex FROM tblclient WHERE intClientId = '$id'");

          while($donor = mysqli_fetch_assoc($fetchDonorSex)){
           $sex = $donor["stfClientSex"];
          }
    //-------------------------------------------------------------------------------------
    if($sex == 'Male'){
      if($result >= $maleleast AND $result <= $malemax){
        $remarks = 'Passed';
        //echo $maleleast.' '.$result.' '.$malemax.' '.$remarks;
      }else{
        $remarks = 'Failed';
        //echo $maleleast.' '.$result.' '.$malemax.' '.$remarks;
      }

    }elseif ($sex == 'Female') {
      if($result >= $femaleleast AND $result <= $femalemax){
        $remarks = 'Passed';
        //echo $femaleleast.' '.$result.' '.$femalemax.' '.$remarks;
      }else{
        $remarks = 'Failed';
        //echo $femaleleast.' '.$result.' '.$femalemax.' '.$remarks;
      }
    }



    //$curdate = date("Y/m/d");
           mysqli_query($connections, "INSERT INTO tblinitialscreening(intDonationId,intBloodComponentId,strBloodComponentResult,strBloodComponentRemarks,strBloodComponentScreener,strIBloodComponentVerifier,dtmDateScreened)
           VALUES ('$donation_id','$i','$result', '$remarks', '$screener', '$verifier', '$date')");
          }

  $checkiffalse = mysqli_query($connections,"SELECT * FROM tblinitialscreening WHERE dtmDateScreened = '$date' AND strBloodComponentRemarks= 'Failed' AND intDonationId = '$donation_id'");

  if(mysqli_num_rows($checkiffalse) == 0){
  //  echo 1;//if walang nagfalse/fail dun sa 4 na bloodcomponent
    mysqli_query($connections,"UPDATE tblinitialscreening SET stfClientInitialScreeningRemarks = 'Passed' WHERE intDonationId = '$donation_id' AND dtmDateScreened = '$date' ");
    mysqli_query($connections,"UPDATE tbldonation SET stfDonationStatus = 'Able'  WHERE intDonationId = '$donation_id'");
    mysqli_query($connections,"UPDATE tblclient SET stfClientType = 'Donor'  WHERE intClientId = '$id'");
        $is_saved = mysqli_query($connections,"SELECT * FROM tblinitialscreening WHERE intDonationId = '$donation_id'");

        if(mysqli_num_rows($is_saved) > 0){//ICHECK KUNG NASAVE TALAGA
        echo '1';
      } elseif (mysqli_num_rows($is_saved) == 0) {
        echo '3';
      }

  }
  else if(mysqli_num_rows($checkiffalse) >= 1){
    mysqli_query($connections,"UPDATE tblinitialscreening SET stfClientInitialScreeningRemarks = 'Failed' WHERE intDonationId = '$donation_id' AND dtmDateScreened = '$date' ");
    mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");

        $is_saved = mysqli_query($connections,"SELECT * FROM tblinitialscreening WHERE intDonationId = '$donation_id'");

        if(mysqli_num_rows($is_saved) > 0){//ICHECK KUNG NASAVE TALAGA
          echo '2';//if may nagfail miski isa dun sa 4 na component
      } elseif (mysqli_num_rows($is_saved) == 0) {
        echo '3';
      }

  }
}
else{
  echo '3';//if di kumpleto yung input
}
}else{
  echo '4';
}

 ?>
