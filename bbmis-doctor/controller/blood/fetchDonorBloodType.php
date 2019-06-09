<?php
include("../connections.php");
//parse_str($_POST["formdata"], $params);
$donorname = mysqli_real_escape_string($connections,$_POST["donor"]);

  $bloodtypeIdqry = mysqli_query($connections,"SELECT bt.intBloodTypeId,stfBloodType,stfBloodTypeRhesus
                                                FROM tblbloodtype bt JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
                                                WHERE CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) LIKE '%$donorname%'");

      $row = mysqli_fetch_assoc($bloodtypeIdqry);
      echo json_encode($row);

  ?>
