<?php
include("../connections.php");

parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$id = $params['clientId'];
settype($id,'int');
$occupation = $params['clientocc'];
$contact = $params['clientcontact'];
$civilstat = $params['clientcivstat'];
$blood_type = $params['clientbloodtype'];
$clientfname =  $params['clientfname'];
$clientminit =  $params['clientminit'];
$clientlname =  $params['clientlname'];
//$clientsex =  $params['clientsex'];


if($occupation && $contact && $civilstat && $blood_type && $clientfname  && $clientlname )
{
  mysqli_query($connections,"UPDATE tblclient
                            SET strClientContact = '$contact', strClientOccupation = '$occupation', stfClientCivilStatus = '$civilstat', intBloodTypeId = '$blood_type',strClientFirstName ='$clientfname',strClientMiddleName ='$clientminit',strClientLastName='$clientlname'
                            WHERE intClientId = $id");

  //echo  "<script type='text/javascript'>alert('Edit Succesful!');</script>";
  //echo "<script type='text/javascript'>window.location.href = '../donor-tab.php'</script>";
  //echo $id.$occupation.$contact.$civilstat.$blood_type;
  echo '1';
}
else{
  //echo  "<script type='text/javascript'>alert('Edit Unsuccesful!');</script>";
  //echo "<script type='text/javascript'>window.location.href = '../donor-tab.php'</script>";
  echo '2';
}
?>
