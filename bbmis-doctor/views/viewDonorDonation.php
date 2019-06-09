<?php 
	include "../controller/fetchEmpAcc.php";
	
	$id = $_GET["id"];
	$stat = $_GET["stat"];
	$clientId = $_GET["clientId"];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Donation Info</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
  <link rel="stylesheet" href="../public/css/bs-override.css">
</head>
<body>
  <?php include "components/loader.php"; ?>
  <div class="wrapper">
    <main class="mainpanel" style="width: 100%;">
      <?php include "components/special-header.php"; ?>
			<div class="page-title">
        <div class="d-flex justify-content-between">
					<div>
						<h3 class="p-2 align-middle">Donation Info</h3>
					</div>
					<div class="p-2">
						<button type="button" onclick="location.href='viewDonorRecordInfo.php?id=' + <?php echo $clientId ?>" class="btn btn-outline-danger">
							<i class="fas fa-long-arrow-alt-left"></i>
							Back
						</button>
					</div>
				</div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
						<!--
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container">
                <div class="form-group">
                  <h4 for="donorweight">Completion :</h4>
                  <input type="text" class="form-control col-md-6 text-center" value = "The record is <?php echo $stat?>" readonly>
                </div>
              </div>
            </div>
						-->
            <!-- medical exam -->
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container">
                <?php
                  $qryFetchSheetVer = mysqli_query($connections, "
										SELECT DISTINCT(q.decQuestionVersion)
                    FROM tblquestion q
										JOIN tblmedicalexam me ON q.intQuestionId = me.intQuestionId
										WHERE me.intDonationId = (
											SELECT me1.intDonationId
                      FROM tbldonation d
                      JOIN tblmedicalexam me1 ON d.intDonationId = me1.intDonationId
                      WHERE d.intDonationId = $id
                      LIMIT 1
											)
									");
                  while ($version = mysqli_fetch_assoc($qryFetchSheetVer) ) {
                    $version_used = $version["decQuestionVersion"];
                  }
									
                  $medicalexamQry = mysqli_query($connections,"
										SELECT *
										FROM tblmedicalexam me
										JOIN tblquestion q ON me.intQuestionId = q.intQuestionId
										WHERE me.intDonationId = '$id'
									");
									
                  if(mysqli_num_rows($medicalexamQry) > 0)	{
                ?>
								<span class="d-flex my-2">
									<button type="button" class="btn btn-danger mr-2" style="height: 50px; width: 50px; border-radius: 25px;" data-toggle="collapse" href="#pnlME" role="button" aria-expanded="false" aria-controls="collapseExample">
										<i class="fa fa-notes-medical fa-lg"></i>
									</button>
									<h4 class="p-2">Medical Exam</h4>
									<p class="pl-2 font-italic text-secondary mt-2"><small>v<?php echo $version_used ?></small></p>
								</span>
								<div class="collapse show pt-2" id="pnlME">
									<table class='table table-bordered text-center table-hover' id='tbldonorsurvey'>
										<thead>
											<tr class='bg-danger text-white'>
												<td style='width: 5%'>No.</td>
												<td style='width: 55%'>Question</td>
												<td style='width: 25%'>Answers</td>
												<td style='width: 15%'>Remarks</td>
											</tr>
										</thead>
										<?php
											$varCounter = 1;
											
											while($medical = mysqli_fetch_assoc($medicalexamQry)){
												$questionId = $medical["intQuestionId"];
												$answerYN = $medical["stfAnswerYn"];
												$answerDate = $medical["datAnswerDate"];
												$answerQuan = $medical["intAnswerQuantity"];
												$answerstr = $medical["strAnswerString"];
												$remarks = $medical["stfAnswerRemarks"];
												$qtype = $medical["stfQuestionType"];

												$questionQry = mysqli_query($connections,"
													SELECT txtquestion
													FROM tblquestion
													WHERE intQuestionId = '$questionId'
												");
												while ($question = mysqli_fetch_assoc($questionQry)) {
													$txtquestion = $question["txtquestion"];
												}
										?>
										<tr>
											<td class="align-middle"><?php echo $varCounter; ?></td>
											<td class="align-middle"><?php echo $txtquestion; ?></td>
											<td class="align-middle">
												<?php
													echo isset($answerYN) && $answerYN != '' ? ($answerYN == 'Yes' ? 'Oo' : 'Hindi') . '<br>' : null;
													echo isset($answerDate) && $answerDate != '0000-00-00' ? date_format(date_create($answerDate), 'F d, Y') . '<br>' : null;
													echo isset($answerQuan) && stripos($qtype, "Qua") ? $answerQuan . '<br>' : null;
													echo isset($answerstr) && $answerstr != '' ? $answerstr . '<br>' : null;
												?>
											</td>
											<td class="align-middle">
												<?php
													echo ($remarks == 'Correct' || $remarks == 'Wrong') ? ($remarks != 'Wrong' ? $remarks = 'Acceptable' : 'Unacceptable') : $remarks;
												?>
											</td>
											
											<!--
											<td><?php echo $txtquestion; ?></td>
											<td><?php echo $answerYN; ?></td>
											<td><?php echo $answerDate; ?></td>
											<td><?php echo $answerQuan; ?></td>
											<td><?php echo $answerstr; ?></td>
											<td><?php echo $remarks; ?></td>
											-->
										</tr>
										<?php
												$varCounter++;
											}
										?>
									</table>
								</div>
                <?php
                  }
									else	{
                ?>
                  <p>No Medical Exam record.</p>
                <?php
                    }
                ?>
              </div>
            </div>
            <!-- end medical exam -->
            <!-- physical exam -->
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container">
                <span class="d-flex my-2">
									<button type="button" class="btn btn-danger mr-2" style="height: 50px; width: 50px; border-radius: 25px;" data-toggle="collapse" href="#pnlPE" role="button" aria-expanded="false" aria-controls="collapseExample">
										<i class="fa fa-stethoscope fa-lg"></i>
									</button>
									<h4 class="p-2">Physical Exam</h4>
								</span>
                <?php
                  $physicalexamQry = mysqli_query($connections,"
										SELECT *
										FROM tblphysicalexam
										WHERE intDonationId = '$id'
									");
									
                  if(mysqli_num_rows($physicalexamQry) > 0)	{
										while($physical = mysqli_fetch_assoc($physicalexamQry))	{
											$weight = $physical["decClientWeight"];
											$bp = $physical["strClientBloodPressure"];
											$pulserate = $physical["strClientPulseRate"];
											$temp = $physical["decClientTemperature"];
											$genapp = $physical["txtClientGenAppearance"];
											$heent = $physical["txtClientHEENT"];
											$heartnlungs = $physical["txtClientHeartLungs"];
											$m_remarks = $physical["stfMedicalStatRemarks"];
											$bloodvolume = $physical["intBloodVolumeId"];
											$deferralID = $physical["intDeferralId"];
								?>
								<div class="collapse show" id="pnlPE">
									<div class="row">
										<div class="col-3 mx-auto text-center">
											<h4 class="pt-3">
												<?php
													echo $weight . ' kg';
												?>
											</h4>
											<p class="mt-n2 pt-0">Weight</p>
										</div>
										<div class="col-3 mx-auto text-center">
											<h4 class="pt-3">
												<?php
													echo $bp . ' mmHg';
												?>
											</h4>
											<p class="mt-n2 pt-0">Blood Pressure</p>
										</div>
										<div class="col-3 mx-auto text-center">
											<h4 class="pt-3">
												<?php
													echo $pulserate . '/min';
												?>
											</h4>
											<p class="mt-n2 pt-0">Pulse Rate</p>
										</div>
										<div class="col-3 mx-auto text-center">
											<h4 class="pt-3">
												<?php
													echo $temp . '&deg;C';
												?>
											</h4>
											<p class="mt-n2 pt-0">Temperature</p>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md">
											<div class="form-group">
												<label for="donorgenapp">General Appearance</label>
												<textarea class="form-control" readonly="readonly"><?php echo $genapp ?></textarea>
											</div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<label for="donorheent">Head, Ears, Eyes, Nose & Throat (HEENT)</label>
												<textarea class="form-control" readonly="readonly"><?php echo $heent?></textarea>
											</div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<label for="donorheartlungs">Heart and Lungs</label>
												<textarea class="form-control" readonly="readonly"><?php echo $heartnlungs?></textarea>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col-md">
											<div class="form-group">
												<label for="donorheartlungs">Remarks</label>
												<input type="text" class="form-control" value = "<?php echo $m_remarks?>" readonly>
											</div>
										</div>
									<?php
												if($m_remarks == "Temporarily Deferred" || $m_remarks == "Permanently Deferred")	{
													$deferralqry = mysqli_query($connections,"
														SELECT *
														FROM tbldeferral
														WHERE intDeferralId = '$deferralID'
													");
													if(mysqli_num_rows($deferralqry) > 0)	{
														while($deferrals = mysqli_fetch_assoc($deferralqry)){
															$reason = $deferrals["txtDeferralReason"];
															$instruction =$deferrals["txtDeferralInstructions"];
														}
													}
									?>
										<div class="col-md">
											<div class="form-group">
												<label for="donorheartlungs">Deferral Reason</label>
												<textarea class="form-control" readonly="readonly"><?php echo $reason?></textarea>
											</div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<label for="donorheartlungs">Deferral Instruction</label>
												<textarea class="form-control" readonly="readonly"><?php echo $instruction?></textarea>
											</div>
										</div>
									<?php
												}
												else	{ //Accepted PE Remarks
													$qryFetchBloodVolume = mysqli_query($connections, "
														SELECT intBloodVolume
														FROM tblbloodvolume
														WHERE intBloodVolumeId = $bloodvolume
													");
													$rowFetchBloodVolume = mysqli_fetch_assoc($qryFetchBloodVolume);
													$varBloodVolume = $rowFetchBloodVolume["intBloodVolume"];
									?>
										<div class="col-md">
											<div class="form-group">
												<label for="donorheartlungs">Blood Volume</label>
												<input type="text" class="form-control" value = "<?php echo $varBloodVolume . 'cc'?>" readonly="readonly">
											</div>
										</div>
									<?php
												}
									?>
									</div>
								</div>
								<?php
										}
									}
									else	{
                ?>
                  <div class="text-center">
                    <i class="fas fa-user-slash fa-5x"></i>
                    <h5 class='my-3'>No Physical Exam record.</h5>
                  </div>
                <?php
									}
                ?>
              </div>
            </div>
            <!-- end physical exam -->
            <!-- initial screening -->
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container">
                <span class="d-flex my-2">
									<button type="button" class="btn btn-danger mr-2" style="height: 50px; width: 50px; border-radius: 25px;" data-toggle="collapse" href="#pnlIS" role="button" aria-expanded="false" aria-controls="collapseExample">
										<i class="fa fa-vial fa-lg"></i>
									</button>
									<h4 class="p-2">Initial Screening</h4>
								</span>
                <?php
                  $initialQry = mysqli_query($connections,"
										SELECT *
										FROM tblinitialscreening
										WHERE intDonationId = '$id'
									");
									
                  if(mysqli_num_rows($initialQry) > 0)	{
                ?>
								<div class="collapse show pt-2" id="pnlIS">
									<table class='table table-bordered text-center'>
										<thead>
											<tr class="bg-danger text-white">
												<td style="width: 30%">Blood Component</td>
												<td style="width: 25%">Screener</td>
												<td style="width: 25%">Verifier</td>
												<td style="width: 10%">Result</td>
												<td style="width: 10%">Remarks</td>
											</tr>
										</thead>
									<?php
										while($initial = mysqli_fetch_assoc($initialQry)){
											$componentid = $initial["intBloodComponentId"];
											$result = $initial["strBloodComponentResult"];
											$remarks = $initial["strBloodComponentRemarks"];
											$screener = $initial["strBloodComponentScreener"];
											$verifier = $initial["strIBloodComponentVerifier"];

											$componentnQry = mysqli_query($connections,"
												SELECT strBloodComponent
												FROM tblbloodcomponent
												WHERE intBloodComponentId = '$componentid'
											");
											while ($component = mysqli_fetch_assoc($componentnQry)) {
												$bloodcomponent = $component["strBloodComponent"];
											}
									?>
										<tr>
											<td><?php echo $bloodcomponent; ?></td>
											<td><?php echo $screener; ?></td>
											<td><?php echo $verifier; ?></td>
											<td><?php echo $result . '/unit'; ?></td>
											<td><?php echo $remarks; ?></td>
										</tr>
									<?php
										}
									?>
									</table>
								</div>
                <?php
                  }
									else	{
                ?>
								<div class="text-center">
									<i class="fas fa-user-slash fa-5x"></i>
									<h5 class='my-3'>No Initial Screening record.</h5>
								</div>
                <?php
                  }
                ?>
              </div>
            </div>
            <!-- end initial screening -->
            <!-- serological screening -->
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container">
                <span class="d-flex my-2">
									<button type="button" class="btn btn-danger mr-2" style="height: 50px; width: 50px; border-radius: 25px;" data-toggle="collapse" href="#pnlSS" role="button" aria-expanded="false" aria-controls="collapseExample">
										<i class="fa fa-microscope fa-lg"></i>
									</button>
									<h4 class="p-2">Serological Screening</h4>
								</span>
								<div class="d-flex justify-content-around py-2">
									<div class="h5">
										Blood Bag Serial No.:
										<span id="spnBloodBagId"></span>
									</div>
									<div class="h5">
										Date Stored:
										<span id="spnBagStored"></span>
									</div>
								</div>
								<?php
									$serologicalQry = mysqli_query($connections,"
										SELECT *
										FROM tblserologicalscreening
										WHERE intDonationId = '$id'
									");
							
									if(mysqli_num_rows($serologicalQry) > 0)	{
								?>
								<div class="collapse show pt-2" id="pnlSS">
									<table class='table table-bordered text-center'>
										<thead>
											<tr class="bg-danger text-white">
												<td style="width: 30%">Disease</td>
												<td style="width: 25%">Screener</td>
												<td style="width: 25%">Verifier</td>
												<td style="width: 10%">Result</td>
												<td style="width: 10%">Remarks</td>
											</tr>
										</thead>
										<?php
											$bloodbagserial = 'N/A';
											$datestored = 'N/A';
											
										?>
												<script type='text/javascript'>
													document.getElementById('spnBloodBagId').innerHTML = <?php echo '$bloodbagserial' ?>;
													document.getElementById('spnBagStored').innerHTML = <?php echo '$datestored' ?>;
												</script>
										<?php
											
											while($serological = mysqli_fetch_assoc($serologicalQry))	{
												$diseaseid = $serological["intDiseaseId"];
												$dremarks = $serological["decDiseaseRemarks"];
												$dscreener = $serological["strDiseaseScreener"];
												$dverifier = $serological["strDiseaseVerifier"];
												$dpass = $serological["stfDonorSerologicalScreeningRemarks"];
												$dbloodbag = $serological["intBloodBagId"];

												$bloodbagQry = mysqli_query($connections,"
													SELECT strBloodBagSerialNo, DATE_FORMAT(dtmDateStored, '%M %d, %Y - %h:%m %p') AS 'Date Stored'
													FROM tblbloodbag 
													WHERE intBloodBagId = $dbloodbag
												");
												
												if(mysqli_num_rows($bloodbagQry) > 0)	{
													while($bags = mysqli_fetch_assoc($bloodbagQry))	{
														$bloodbagserial = $bags["strBloodBagSerialNo"];
														$datestored = $bags["Date Stored"];
													}
												}
												else	{
													$bloodbagserial = 'N/A';
													$datestored = 'N/A';
												}
												
												echo "
													<script type='text/javascript'>
														document.getElementById('spnBloodBagId').innerHTML = '$bloodbagserial';
														document.getElementById('spnBagStored').innerHTML = '$datestored';
													</script>
												";

												$diseaseQry = mysqli_query($connections,"
													SELECT strDisease
													FROM tbldisease
													WHERE intDiseaseId = '$diseaseid'
												");
												while($disease = mysqli_fetch_assoc($diseaseQry)) {
													$diseaseName = $disease["strDisease"];
												}
										?>
										<tr>
											<td><?php echo $diseaseName; ?></td>
											<td><?php echo $dscreener; ?></td>
											<td><?php echo $dverifier; ?></td>
											<td><?php echo $dremarks; ?></td>
											<td><?php echo $dpass; ?></td>
										</tr>
										<?php
												}
										?>
									</table>
								</div>
								<?php
											}
											else	{
								?>
										<div class="text-center">
											<i class="fas fa-user-slash fa-5x"></i>
											<h5 class='my-3'>No Serological Screening record.</h5>
										</div>
								<?php
											}
								?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <?php 
  include "components/core-script.php";
  ?>
  <script src="../public/js/notification.js"></script>
  <script>
    $('.loader').hide();
    checkExpiringBloodBags();

    function checkExpiringBloodBags() {
      $.ajax({
        type: "POST",
        url: "../controller/blood/checkExpiringBloodBags.php",
        complete: function(){
          setTimeout(checkExpiringBloodBags, 60000);
        }
      });
    }
  </script>
</body>
</html>