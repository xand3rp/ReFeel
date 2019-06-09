<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "bbmis");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$request = mysqli_real_escape_string($link, $_REQUEST['term']);
if(isset($request)){
    // Prepare a select statement
// $getlatestdonationIDquery = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$clientid' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");
// while ($row2 = mysqli_fetch_assoc($getlatestdonationIDquery)) {
//   $latestdonationID = $row2["intDonationId"];
// }
//
    $sql ="SELECT *
    FROM tblclient c
    LEFT JOIN tblbloodbag bb ON c.intClientId = bb.intClientId JOIN tbldonation d ON d.intClientId = c.intClientId
    WHERE c.intClientId NOT IN (SELECT intClientId from tblbloodbag where stfIsBloodBagExpired = 'No')
    AND  stfDonationRemarks = 'Incomplete'
    AND CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) LIKE ? ";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term = '%'. $request . '%';

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["strClientFirstName"] ." ". $row["strClientMiddleName"]." ".$row["strClientLastName"]."</p>";
                }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// close connection
mysqli_close($link);
?>
