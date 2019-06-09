<?php
include("../connections.php");
include("../checkSession.php");
$reqId = $_POST["reqId"];

mysqli_query($connections,"UPDATE tblrequest SET stfRequestFeedback = 'Granted', dtmDateAccepted = NOW(), intEmployeeId = '$varEmpId' WHERE intClientReqId = $reqId");

?>
