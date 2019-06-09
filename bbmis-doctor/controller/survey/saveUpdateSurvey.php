<?php
include("../connections.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$client_ID = $params["hiddenclientid"];
$examcode = $params["hiddenexamcode"];

$donationidqry = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$client_ID' AND stfDonationRemarks = 'Incomplete' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

while($donation = mysqli_fetch_assoc($donationidqry)){
 $donation_id = $donation["intDonationId"];
}


$unchecked = mysqli_query($connections,"SELECT * FROM tblmedicalexam WHERE stfAnswerRemarks = 'Unchecked' AND intDonationId = '$examcode'");
while ($row = mysqli_fetch_assoc($unchecked)) {
  $medicalId = $row["intMedicalExamId"];
  $questionid = $row["intQuestionId"];

  $new_status = $params["updatestatus"."$questionid"];

    $update_answer = mysqli_query($connections,"UPDATE tblmedicalexam SET stfAnswerRemarks = '$new_status' , dtmExamChecked = NOW() WHERE intDonationId = '$examcode' AND intQuestionId = '$questionid' ");

    if($new_status == 'Wrong'){
        mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$examcode'");
    }

}



//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------

/*if($sex == 'Female'){

  for($i = $first_number; $i <= $first_number + $NumberOfQuestionsminusone; $i++)
  {

      $new_status = $params["updatestatus"."$i"];

				$update_answer = mysqli_query($connections,"UPDATE tblmedicalexam
                                                        SET stfAnswerRemarks = '$new_status' , dtmExamChecked = NOW()
                                                        WHERE
                                                       intDonationId = '$examcode'
                                                        AND intQuestionId = '$i'
                                                        ");

        if($new_status == 'Wrong'){
          	mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");
        }
echo $new_status;
  }
}else if($sex == 'Male'){
  for($i = $first_number; $i <= $first_number + $NumberOfQuestionminusFE; $i++)
  {

      $new_status = $params["updatestatus"."$i"];

				$update_answer = mysqli_query($connections,"UPDATE tblmedicalexam
                                                        SET stfAnswerRemarks = '$new_status' , dtmExamChecked = NOW()
                                                        WHERE
                                                       intDonationId = '$examcode'
                                                        AND intQuestionId = '$i'
                                                        ");

        if($new_status == 'Wrong'){
          	mysqli_query($connections,"UPDATE tbldonation SET stfDonationRemarks = 'Complete' WHERE intDonationId = '$donation_id'");
        }

}

}*/
?>
