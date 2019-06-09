<?php

include("../connections.php");
parse_str(mysqli_real_escape_string($connections, $_POST["formdata"]), $params);

$from_range = $params['from_range'];
$to_range = $params['to_range'];

$reports_critical = mysqli_query($connections,"SELECT strBloodBagSerialNo, dtmDateStored, stfBloodType, stfBloodTypeRhesus, intBloodVolume, intPreservativeLifespan, TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(dtmDateStored, INTERVAL intPreservativeLifespan DAY)) AS 'Days Remaining' FROM tblbloodbag tbb
          JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
          JOIN tblstorage ts ON ts.intStorageId = tbb.intStorageId
          JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
          JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
          WHERE DATEDIFF(NOW(), tbb.dtmDateStored) >= tp.intPreservativeCriticalPercentage AND DATEDIFF(NOW(), tbb.dtmDateStored) <= tp.intPreservativeLifespan");

$reports_wastage = mysqli_query($connections, "
	SELECT bt.intBloodTypeId, stfBloodType, stfBloodTypeRhesus, COUNT(intBloodBagId) AS 'count_wastage'
	FROM tblbloodtype bt
	JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId
	WHERE stfIsBloodBagExpired ='Yes'
	AND stfTransfusionSuccess = 'No'
	AND bb.dtmDateStored BETWEEN '$from_range' AND '$to_range'
	GROUP BY bt.intBloodTypeId, YEAR(dtmDateStored)
");

$reports_daily = mysqli_query($connections, "
	SELECT DATE_FORMAT(dtmDateStored, '%W') AS 'Day', COUNT(intBloodBagId) AS 'Blood Bag Count', stfBloodType
	FROM tblbloodbag bb
	JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
	JOIN tblpreservatives pr ON bb.intPreservativeId = pr.intPreservativeId
	WHERE bb.dtmDateStored BETWEEN '$from_range' AND '$to_range'
	GROUP BY 3;
");

$reports_monthly = mysqli_query($connections,"
	SELECT DATE_FORMAT(dtmDateStored, '%M %Y') AS 'Month Year', COUNT(intBloodBagId) AS 'Blood Bag Count', stfBloodType
	FROM tblbloodbag bb
	JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
	WHERE bb.dtmDateStored BETWEEN '$from_range' AND '$to_range'
	GROUP BY 3
	ORDER BY 1 ASC
");

$reports_yearly = mysqli_query($connections,"
	SELECT DATE_FORMAT(dtmDateStored, '%Y') AS 'Year', COUNT(intBloodBagId) AS 'Blood Bag Count', stfBloodType
	FROM tblbloodbag bb
	JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
	WHERE bb.dtmDateStored BETWEEN '$from_range' AND '$to_range'
	GROUP BY 3
	ORDER BY 1 ASC
");

$bloodbagpertype = mysqli_query($connections,"
	SELECT bt.stfBloodType AS 'Blood Type', COUNT(bb.intBloodTypeId) AS 'Blood Bag Count'
	FROM tblbloodtype bt
	JOIN tblbloodbag bb ON bt.intBloodTypeId = bb.intBloodTypeId
	WHERE stfIsBloodBagExpired = 'No'
	GROUP BY 1
");

$donorpertype = mysqli_query($connections,"
	SELECT COUNT(DISTINCT(d.intDonationId)) AS 'Donor Count', stfBloodType AS 'Blood Type'
	FROM tblserologicalscreening s
	JOIN tbldonation d ON s.intDonationId = d.intDonationId
	JOIN tblclient c ON d.intClientId = c.intClientId
	JOIN tblbloodtype bt ON c.intBloodTypeId = bt.intBloodTypeId
	WHERE dtmDateScreened BETWEEN '$from_range' AND '$to_range'
	GROUP BY 2
");

$bloodcomponentfailedcount = mysqli_query($connections,"
	SELECT DATE_FORMAT(dtmDateScreened, '%M %Y') AS 'Month Year' , bc.strBloodComponent, COUNT(*) AS 'Failed Client Count'
	FROM tblbloodcomponent bc
	JOIN tblinitialscreening ins ON bc.intBloodComponentId = ins.intBloodComponentId
	WHERE ins.strBloodComponentRemarks = 'Failed' AND dtmDateScreened BETWEEN '$from_range' AND '$to_range'
	GROUP BY 2
");

$bloodcomponentfailedlist = mysqli_query($connections,"
	SELECT DATE_FORMAT(dtmDateScreened, '%M %Y') AS 'Month Year', strBloodComponent, CONCAT(c.strClientFirstName, ' ', c.strClientLastName) AS 'Client Full Name'
	FROM tblclient c
	JOIN tbldonation d ON c.intClientId = d.intClientId
	JOIN tblinitialscreening ins ON d.intDonationId = ins.intDonationId
	JOIN tblbloodcomponent bc ON ins.intBloodComponentId = bc.intBloodComponentId
	WHERE ins.strBloodComponentRemarks = 'Failed'
	AND dtmDateScreened BETWEEN '$from_range' AND '$to_range'
	GROUP BY 3
");

$blooddiseasefailedcount = mysqli_query($connections,"
	SELECT DATE_FORMAT(dtmDateScreened, '%M %Y') AS 'Month Year', d.strDisease, COUNT(*) AS 'Failed Client Count'
	FROM tbldisease d
	JOIN tblserologicalscreening ss ON d.intDiseaseId = ss.intDiseaseId
	WHERE ss.stfDonorSerologicalScreeningRemarks = 'Failed'
	AND dtmDateScreened BETWEEN '$from_range' AND '$to_range'
	GROUP BY 2
");

$blooddiseasefailedlist = mysqli_query($connections,"
	SELECT DATE_FORMAT(dtmDateScreened, '%M %Y') AS 'Month Year', strDisease, CONCAT(c.strClientFirstName, ' ', c.strClientLastName) AS 'Client Full Name'
	FROM tblclient c
	JOIN tbldonation d ON c.intClientId = d.intClientId
	JOIN tblserologicalscreening ss ON d.intDonationId = ss.intDonationId
	JOIN tbldisease di ON di.intDiseaseId = ss.intDiseaseId
	WHERE ss.stfDonorSerologicalScreeningRemarks = 'Failed'
	AND dtmDateScreened BETWEEN '$from_range' AND '$to_range'
	GROUP BY 3
");

$donorcountperage = mysqli_query($connections,"
	SELECT TIMESTAMPDIFF(YEAR, datClientBirthday, NOW()) AS 'Client Age', COUNT(*) AS 'Client Count'
	FROM tblclient
	GROUP BY 1
	ORDER BY 1 ASC
");

$donorcountpersex = mysqli_query($connections,"
	SELECT stfClientSex AS 'Client Sex', COUNT(*) AS 'Client Count'
	FROM tblclient
	GROUP BY 1
");
?>
<?php
// if (mysqli_num_rows($reports_remaining) > 0 ){
// $output = "";
// while ($row = mysqli_fetch_assoc($reports_remaining)) {
//   $blood_type = $row["stfBloodType"];
//   $rhesus = $row["stfBloodTypeRhesus"];
//   $remaining = $row["count_remaining"];
//   $output .=
//   "
//   <tbody>
//   <tr>
//   <td>$blood_type</td>
//   <td>$rhesus</td>
//   <td>$remaining</td>
//   </tr>
//   </tbody>
//   ";
// }
// $output .= "
// </table>
// ";
// echo $output;
// }
// else if (mysqli_num_rows($reports_remaining) == 0){
// $output =
// "<tr>
//   <td></td>
//   <td>No records</td>
//   <td></td>
// </tr>
// </table>";
// echo $output;
// }
 ?>
 <div class="card">
	 <div class="card-header" id="hdg_criticalbb">
		 <!-- <h4 class="mb-0"> -->
			 <h5 class="karla" data-toggle="collapse" data-target="#div_criticalbb" aria-expanded="true" aria-controls="div_criticalbb">Currently Critical Blood Bags</h5>
		 <!-- </h4> -->
	 </div>
	 <div class="collapse show col-md-12" id="div_criticalbb" aria-labelledby="hdg_criticalbb" data-parent="#accordion">
		 <div class="card-body">
			 <table class='table text-center'>
				 <thead>
					 <tr>
						 <th>Blood Bag Serial</th>
						 <th>Blood Type</th>
						 <th>Date Stored</th>
						 <th>Days Remaining</th>
					 </tr>
				 </thead>
				 <?php
				 if (mysqli_num_rows($reports_critical) > 0){
					 $output = "";
					 while($row = mysqli_fetch_assoc($reports_critical)){
						 $serial = $row["strBloodBagSerialNo"];
						 $datestored = $row["dtmDateStored"];
						 $bloodType = $row["stfBloodType"];
						 $remaining = $row["Days Remaining"];
						 $output .=
						 "
						 <tbody>
						 <tr>
						 <td>$serial</td>
						 <td>$datestored</td>
						 <td>$bloodType</td>
						 <td>$remaining</td>
						 </tr>
						 </tbody>
						 ";
					 }
					 $output .= "</table>";
					 echo $output;
				 }
				 else if (mysqli_num_rows($reports_critical) == 0){
					 $output =
					 "
					 <tr>
						 <td>No records</td>
						 <td></td>
					 </tr>
					 </table>
					 ";
					 echo $output;
				 }
					?>
		 </div>
	 </div>
 </div>
 <!-- <div id="accordion"> -->
   <div class="card">
     <div class="card-header" id="hdg_remainingbbpertype">
       <!-- <h4 class="mb-0"> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_remainingbbpertype" aria-expanded="true" aria-controls="div_remainingbbpertype">Remaining Blood Bag Count Per Blood Type</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse show col-md-12" id="div_remainingbbpertype" aria-labelledby="hdg_remainingbbpertype" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Blood Type</th>
               <th>Blood Bag Count</th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($bloodbagpertype) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($bloodbagpertype)){
               $day = $row["Blood Type"];
               $bloodbagamount = $row["Blood Bag Count"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$day</td>
               <td>$bloodbagamount</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($bloodbagpertype) == 0){
             $output =
             "
             <tr>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_wastage">
       <!-- <h4 class="mb-0"> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_wastage" aria-expanded="false" aria-controls="div_wastage">Wastage Report</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_wastage" aria-labelledby="hdg_wastage" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center' style="width:100%">
           <thead>
             <tr>
               <th>Blood Type</th>
               <th>Rhesus</th>
               <th>Remaining Count</th>
             </tr>
           </thead>
          <?php
          if (mysqli_num_rows($reports_wastage) > 0){
            $output = "";
            while($row = mysqli_fetch_assoc($reports_wastage)){
            $blood_type = $row["stfBloodType"];
            $rhesus = $row["stfBloodTypeRhesus"];
            $wastage = $row["count_wastage"];
            $output .=
            "
            <tbody>
            <tr>
            <td>$blood_type</td>
            <td>$rhesus</td>
            <td>$wastage</td>
            </tr>
            </tbody>
            ";
            }
            $output .=
            "</table>";
            echo $output;
          }
          else if (mysqli_num_rows($reports_wastage) == 0) {
           $output =
            "
            <tr>
              <td></td>
              <td>No records</td>
              <td></td>
            </tr>
            </table>";
            echo $output;
          }
           ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_dailybloodextraction">
       <!-- <h4 class="mb-0"> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_dailybloodextraction" aria-expanded="false" aria-controls="div_dailybloodextraction">Daily Blood Extraction</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_dailybloodextraction" aria-labelledby="hdg_dailybloodextraction" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Day</th>
               <th>Blood Bag Count</th>
               <th>Blood Type </th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($reports_daily) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($reports_daily)){
               $day = $row["Day"];
               $bloodbagamount1 = $row["Blood Bag Count"];
               $bloodType = $row["stfBloodType"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$day</td>
               <td>$bloodbagamount1</td>
               <td>$bloodType</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($reports_daily) == 0){
             $output =
             "
             <tr>
               <td></td>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_monthlybloodextraction">
       <!-- <h4 class="mb-0"> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_monthlybloodextraction" aria-expanded="false" aria-controls="div_monthlybloodextraction">Monthly Blood Extraction</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_monthlybloodextraction" aria-labelledby="hdg_monthlybloodextraction" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Month Year</th>
               <th>Blood Bag Count</th>
               <th>Blood Type </th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($reports_monthly) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($reports_monthly)){
               $month_year = $row["Month Year"];
               $bloodbagamount2 = $row["Blood Bag Count"];
               $bloodType = $row["stfBloodType"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$month_year</td>
               <td>$bloodbagamount2</td>
               <td>$bloodType</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($reports_monthly) == 0){
             $output =
             "
             <tr>
               <td></td>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_yearlybloodextraction">
       <!-- <h4> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_yearlybloodextraction" aria-expanded="false" aria-controls="div_yearlybloodextraction">Yearly Blood Extraction</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_yearlybloodextraction" aria-labelledby="hdg_yearlybloodextraction" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Year</th>
               <th>Blood Bag Count</th>
               <th>Blood Type </th>
             </tr>
           </thead>
           <?php
           if(mysqli_num_rows($reports_yearly) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($reports_yearly)){
               $day = $row["Year"];
               $bloodbagamount = $row["Blood Bag Count"];
               $bloodType = $row["stfBloodType"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$day</td>
               <td>$bloodbagamount</td>
               <td>$bloodType</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($reports_yearly) == 0){
             $output =
             "
             <tr>
               <td></td>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_donorcountpertype">
       <!-- <h4 class="mb-0"> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_donorcountpertype" aria-expanded="false" aria-controls="div_donorcountpertype">Donor Count Per Blood Type</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_donorcountpertype" aria-labelledby="hdg_donorcountpertype" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Blood Type</th>
               <th>Donor Count</th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($donorpertype) > 0) {
             $output = "";
             while($row = mysqli_fetch_assoc($donorpertype)){
               $day = $row["Blood Type"];
                 $bloodbagamount = $row["Donor Count"];
                 $output .=
                 "
                 <tbody>
                 <tr>
                 <td>$day</td>
                 <td>$bloodbagamount</td>
                 </tr>
                 </tbody>
                 ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($donorpertype) == 0 ){
             $output =
             "
             <tr>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_faileddonorpercomponent">
       <!-- <h4 class="mb-0"> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_faileddonorpercomponent" aria-expanded="false" aria-controls="div_faileddonorpercomponent">Count of donor fail per Component</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_faileddonorpercomponent" aria-labelledby="hdg_faileddonorpercomponent" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Month Year</th>
               <th>Blood Component</th>
               <th>Failed Client Count</th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($bloodcomponentfailedcount) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($bloodcomponentfailedcount)){
               $monthyear = $row["Month Year"];
               $day = $row["strBloodComponent"];
               $bloodbagamount = $row["Failed Client Count"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$monthyear</td>
               <td>$day</td>
               <td>$bloodbagamount</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($bloodcomponentfailedcount) == 0){
             $output =
             "
             <tr>
               <td></td>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_donorlistfailedpercomponent">
       <!-- <h4 class="mb-0"> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_donorlistfailedpercomponent" aria-expanded="false" aria-controls="div_donorlistfailedpercomponent">List of donor fail per Component</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_donorlistfailedpercomponent" aria-labelledby="hdg_donorlistfailedpercomponent" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Month Year</th>
               <th>Blood Component</th>
               <th>Failed Client Name</th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($bloodcomponentfailedlist) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($bloodcomponentfailedlist)){
               $monthyear = $row["Month Year"];
               $day = $row["strBloodComponent"];
               $bloodbagamount = $row["Client Full Name"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$monthyear</td>
               <td>$day</td>
               <td>$bloodbagamount</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($bloodcomponentfailedlist) == 0 ){
             $output =
             "
             <tr>
               <td></td>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header">
       <!-- <h4 class="mb-0"> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_donorcountfailperdisease" aria-expanded="false" aria-controls="div_donorcountfailperdisease">Count of donor fail per Disease</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_donorcountfailperdisease" aria-labelled="hdg_donorcountfailperdisease" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Month Year</th>
               <th>Disease</th>
               <th>Failed Client Count</th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($blooddiseasefailedcount) > 0){
             $output = "";
             while($row=mysqli_fetch_assoc($blooddiseasefailedcount)){
               $monthyear = $row["Month Year"];
               $day = $row["strDisease"];
               $bloodbagamount = $row["Failed Client Count"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$monthyear</td>
               <td>$day</td>
               <td>$bloodbagamount</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($blooddiseasefailedcount) == 0){
             $output =
             "
             <tr>
               <td></td>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_donorlistfailperdisease">
       <!-- <h4> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_donorlistfailperdisease" aria-expanded="false" aria-controls="div_donorlistfailperdisease">List of donor fail per Disease</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_donorlistfailperdisease" aria-labelledby="hdg_donorlistfailperdisease" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Month Year</th>
               <th>Disease</th>
               <th>Failed Client Count</th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($blooddiseasefailedlist) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($blooddiseasefailedlist)){
               $monthyear = $row["Month Year"];
               $day = $row["strDisease"];
               $bloodbagamount = $row["Client Full Name"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$monthyear</td>
               <td>$day</td>
               <td>$bloodbagamount</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($blooddiseasefailedlist) == 0 ){
             $output =
             "
             <tr>
               <td></td>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_donorcountperage">
       <!-- <h4> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_donorcountperage" aria-expanded="false" aria-controls="div_donorcountperage">Count of Client per Age</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_donorcountperage" aria-labelledby="hdg_donorcountperage" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Client Age</th>
               <th>Client Count</th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($donorcountperage) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($donorcountperage)){
               $monthyear = $row["Client Age"];
               $day = $row["Client Count"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$monthyear</td>
               <td>$day</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($donorcountperage) == 0){
             $output =
             "
             <tr>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
   </div>

   <div class="card">
     <div class="card-header" id="hdg_donorcountpersex">
       <!-- <h4> -->
         <h5 class="karla" data-toggle="collapse" data-target="#div_donorcountpersex" aria-expanded="false" aria-controls="div_donorcountpersex">Count of Client per Sex</h5>
       <!-- </h4> -->
     </div>
     <div class="collapse" id="div_donorcountpersex" aria-labelledby="hdg_donorcountpersex" data-parent="#accordion">
       <div class="card-body">
         <table class='table text-center'>
           <thead>
             <tr>
               <th>Client Sex</th>
               <th>Client Count</th>
             </tr>
           </thead>
           <?php
           if (mysqli_num_rows($donorcountpersex) > 0){
             $output = "";
             while($row = mysqli_fetch_assoc($donorcountpersex)){
               $monthyear = $row["Client Sex"];
               $day = $row["Client Count"];
               $output .=
               "
               <tbody>
               <tr>
               <td>$monthyear</td>
               <td>$day</td>
               </tr>
               </tbody>
               ";
             }
             $output .= "</table>";
             echo $output;
           }
           else if (mysqli_num_rows($donorcountpersex) == 0 ){
             $output =
             "
             <tr>
               <td>No records</td>
               <td></td>
             </tr>
             </table>
             ";
             echo $output;
           }
            ?>
       </div>
     </div>
 <!-- </div> -->
