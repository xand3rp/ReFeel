<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Donor Records</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
  <link rel="stylesheet" href="../public/css/datatables.min.css">
  <link rel="stylesheet" href="../public/css/bs-override.css">
  <link rel="stylesheet" href="../public/css/jquery-ui.css">
</head>
<body>
  <?php include "components/loader.php"; ?>
  <div class="wrapper">
    <?php include "components/sidebar.php"; ?>
    <main class="mainpanel">
      <?php include "components/header.php";
				$datenow = date('Y-m-d');
				$datenow_1 = new DateTime($datenow);
      ?>
			<div class="page-title">
				<h3 class="p-2 align-middle">Donor Records</h3>
			</div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container">
                <div id="donorRecords" class="mt-2">
                  <table id="tblDonorRecords" class="table table-hover table-bordered text-center">
                    <thead>
                      <tr class="bg-danger text-white">
                        <td style="width: 50%">Name</td>
                        <td style="width: 50%">Action</td>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div id="donorInfo" style="display: none">
                  <button type="button" class="btn" id='btn-backtorecords' onclick='location.href="donor-records.php"'> <i class="fas fa-long-arrow-alt-left"></i> Back to records</button><br><br>
                  <b class="labeldonordiv">Name: </b>
                  <label id='cname'></label><br>
                  <b class="labeldonordiv">Birthday: </b>
                  <label id='cbday'></label><br>
                  <b class="labeldonordiv">Sex: </b>
                  <label id='csex'></label><br>
                  <b class="labeldonordiv">Contact: </b>
                  <label id='ccontact'></label><br>
                  <b class="labeldonordiv">Civil Status: </b>
                  <label id='ccivstat'></label><br>
                  <b class="labeldonordiv">Occupation: </b>
                  <label id='coccupation'></label>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2" id="addPhysical" style="display: none">
              <div class="content-container">
                <div id="addPhysical" class="mt-2">
                  <h4><small><span class="badge badge-pill badge-dark" style="margin-right: 1rem;">2</span></small>Physical Exam</h4>
                  <form name="adddonorphysrecord">
                    <div class="row">
                      <!-- <div class=""> -->
                      <div class="form-group col-md-5">
                        <label for="date_phys">Date Screened</label>
                        <input type="text" name="date_phys" class="screenDate form-control" readonly value=<?php echo $datenow ?> required>
                      </div>
                      <!-- </div> -->
                      <div class="col-md-5">
                        <!-- <div class="form-group"> -->
                        <label for="donorweight">Weight</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id='donorweight' name="donorweight" required>
                          <div class="input-group-append">
                            <div class="input-group-text">kg</div>
                          </div>
                        </div>
                        <input type ="hidden" name ="clientId_phys" id ="clientId_phys">
                        <!-- </div> -->
                      </div>
                      <div class="col-md-5">
                        <label for="donorbloodpressure_systole">Blood Pressure</label>
                        <!-- <div class="form-group"> -->
                          <!-- <div class="row"> -->
                        <div class="input-group">
                          <input type="number" class="form-control col-md-4" id='donorbloodpressure_systole' name="donorbloodpressure_systole" required>
                          <input type="number" class="form-control col-md-4" id='donorbloodpressure_diastole' name="donorbloodpressure_diastole" required>
                          <div class="input-group-append">
                            <div class="input-group-text">mmHg</div>
                          </div>
                        </div>
                      <!-- </div> -->
                    <!-- </div> -->
                      </div>
                      <div class="col-md-5">
                        <!-- <div class="form-group"> -->
                        <label for="donorpulserate">Pulse Rate</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id='donorpulserate' name="donorpulserate" required>
                          <div class="input-group-append">
                            <div class="input-group-text">per minute</div>
                          </div>
                        </div>
                        <!-- </div> -->
                      </div>
                      <div class="col-md-5">
                        <!-- <div class="form-group"> -->
                        <label for="donortemperature">Temperature</label>
                        <div class="input-group">
                          <input type="number" class="form-control" id='donortemperature' name='donortemperature' required>
                          <div class="input-group-append">
                            <div class="input-group-text">°C</div>
                          </div>
                        </div>
                        <!-- </div> -->
                      </div>
                      <!-- <div class=""> -->
                      <div class="form-group col-md-9">
                        <label for="donorgenapp">General Appearance</label>
                        <input type="text" class="form-control" id='donorgenapp' name="donorgenapp" required>
                      </div>
                      <!-- </div> -->
                      <!-- <div class=""> -->
                      <div class="form-group col-md-9">
                        <label for="donorheent">Head, Ears, Eyes, Nose & Throat (HEENT)</label>
                        <input type="text" class="form-control" id='donorheent' name="donorheent" required>
                      </div>
                      <!-- </div> -->
                      <!-- <div class=""> -->
                      <div class="form-group col-md-9">
                        <label for="donorheartlungs">Heart and Lungs</label>
                        <input type="text" class="form-control" id='donorheartlungs' name="donorheartlungs" required>
                      </div>
                      <!-- </div> -->
                      <!-- <div class=""> -->
                      <div class="form-group col-md-9">
                        <label for="examremarks">Exam Remarks</label>
                        <select class="form-control" id='examremarks' name="examremarks" required>
                          <option selected disabled>Select Exam Remarks</option>
                          <option value="Accepted">Accepted</option>
                          <option value="Temporarily Deferred">Temporarily Deferred</option>
                          <option value="Permanently Deferred">Permanently Deferred</option>
                        </select>
                      </div>
                      <!-- </div> -->
                      <div class="col-md-9" id = "amount" style="display : none;">
                        <div class="form-group">
                          <label for="bloodamount">Amount of Blood</label>
                          <input type="radio" name="bloodamount" value = "250cc" id = "bloodamount" >250cc
                          <input type="radio" name="bloodamount" value = "450cc" id = "bloodamount">450cc
                        </div>
                      </div>
                      <div class="col-md-9" id = "reason"  style="display : none;">
                        <div class="form-group">
                          <label for="reasonfordeferal">Reason for Defferal</label>
                          <input type="text" name="reasonfordeferal" id = "reasonfordeferal" class="form-control">
                          <label for="instruction">Instructions</label>
                          <input type="text" name="instruction" id = "instruction" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success ml-1 float-right" id='donorphysrecord_save'>Save</button>
                        <button type="button" class="btn float-right" id='btnclearphys'>Clear</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2" id="addInitial" style="display: none"> 
              <div class="content-container">
                <div id="addInitial" class="mt-2" style="padding-bottom: 3rem; ">
                  <h4><small><span class="badge badge-pill badge-dark" style="margin-right: 1rem;">3</span></small>Initial Screening</h4>
                  <form name="adddonorinitexam">
                    <input type="hidden" id="clientId_init" name ="clientId_init">
                    <div class="form-group col-md-5">
                      <label for="date_init">Date Screened</label>
                      <input type="text" name="date_init" class="screenDate form-control" readonly value=<?php echo $datenow ?> required>
                    </div>
                    <table class = "table table-striped">
                      <thead>
                        <tr>
                          <th>Blood Component</th>
                          <th>Result</th>
                          <th>Remarks</th>
                          <th>Screener</th>
                          <th>Verifier</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
													$fetch_components = mysqli_query($connections,"
														SELECT *
														FROM tblbloodcomponent
														WHERE stfBloodComponentStatus = 'Active'
													");

													if(mysqli_num_rows($fetch_components)>0)	{
														while ($row = mysqli_fetch_assoc($fetch_components))	{
															$bloodcomponentid = $row['intBloodComponentId'];
															$componentname = $row['strBloodComponent'];
															$maleleast = $row['decMaleLeastVal'];
															$malemax = $row['decMaleMaxVal'];
															$femaleleast = $row['decFemaleLeastVal'];
															$femalemax = $row['decFemaleMaxVal'];
                        ?>
													<input type="hidden" value="<?php echo $bloodcomponentid; ?>" name ='hidden_ID'>
													<tr>
														<td><?php echo $componentname; ?></td>
														<td>
															<input type="number" step = 'any' class="form-control BC_result" placeholder="Enter Result" name = "BC_result<?php echo $bloodcomponentid; ?>" id = "<?php echo $bloodcomponentid; ?>" data-ml ='<?php echo $maleleast; ?>' data-mm ='<?php echo $malemax; ?>' data-fl ='<?php echo $femaleleast; ?>'	data-fm ='<?php echo $femalemax; ?>' required="required">
														</td>
                            <!--  
															<td>
                                <label class="radio-inline"><input type="radio" name="BC_remarks<?php echo $bloodcomponentid; ?>" id="BC_remarks<?php echo $bloodcomponentid; ?>" value="Passed" required>Passed</label>
                                <label class="radio-inline"><input type="radio" name="BC_remarks<?php echo $bloodcomponentid; ?>" id="optradio<?php echo $bloodcomponentid; ?>" value="Failed" required>Failed</label>
                              </td>
														-->
                              <td>
                                <button type = "button" class ="btn btn-success" disabled style="display:none;" id = "BCremarkspassed<?php echo $bloodcomponentid; ?>" >PASSED</button>
                                <button type = "button" class ="btn btn-danger" disabled style="display:none;" id = "BCremarksfailed<?php echo $bloodcomponentid; ?>" >FAILED</button>
                              </td>
                              <td>
                                <select class="form-control" name="BC_screener<?php echo $bloodcomponentid; ?>" id="BC_screener<?php echo $bloodcomponentid; ?>" required="required">
                                <?php
                                  include("connections.php");

                                  $fetch_staff = mysqli_query($connections, "
																		SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
                                    FROM tblemployee
																		WHERE stfEmployeeStatus = 'Active'
                                  ");
																	
                                  if(mysqli_num_rows($fetch_staff) > 0 )	{
                                    while($row = mysqli_fetch_assoc($fetch_staff))	{
                                      $fullname = $row["Fullname"];
                                ?>
																	<option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                                <?php
                                    }
                                  }
                                ?>
                                </select>
                              </td>
                              <td>
                                <select class="form-control" name="BC_verifier<?php echo $bloodcomponentid; ?>" id="BC_verifier<?php echo $bloodcomponentid; ?>" required>
                                <?php
                                  include("connections.php");

                                  $fetch_staff = mysqli_query($connections, "
																		SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
																		FROM tblemployee WHERE stfEmployeeStatus = 'Active'
                                  ");

                                  if(mysqli_num_rows($fetch_staff) > 0 )	{
                                    while($row = mysqli_fetch_assoc($fetch_staff))	{
                                      $fullname = $row["Fullname"];
                                ?>
                                      <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                                <?php
                                    }
                                  }
                                ?>
                                </select>
                              </td>
                            </tr>
                        <?php
														}
													}
                        ?>
                      </tbody>
                    </table>
                    <button type="submit" class="btn btn-success ml-1 float-right" id='donorinitrecord_save'>Save</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2" id="addSerological" style="display: none">
              <div class="content-container">
                <div id="addSerological" class="mt-2" style="padding-bottom: 3rem">
                  <h4><small><span class="badge badge-pill badge-dark" style="margin-right: 1rem;">4</span></small>Serological Screening</h4>
                  <form name="adddonorseroexam">
                    <input type="hidden" id="clientId_sero" name ="clientId_sero">
                    <div class="form-group col-md-5">
                      <label for="date_sero">Date Screened</label>
                      <input type="text" name="date_sero" class="screenDate form-control" readonly value=<?php echo $datenow ?> required>
                    </div>
                    <div class="form-group col-md-5">
                      <label for="date_sero">Blood Bag</label>
                      <input type="text" id ="bloodbag_underquarantine" class = "form-control" name = "bloodbag_underquarantine" readonly required>
                    </div>
                    <table class = "table table-striped">
                      <thead>
                        <tr>
                          <th>Disease</th>
                          <th>Result</th>
                          <th>Screener</th>
                          <th>Verifier</th>
                          <th>Remarks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
													$fetch_disease = mysqli_query($connections,"
														SELECT *
														FROM tbldisease
														WHERE stfDiseaseStatus = 'Active'
													");
													$fetch_diseasecount = mysqli_query($connections,"
														SELECT COUNT(intDiseaseId) AS diseasecount
														FROM tbldisease
														WHERE stfDiseaseStatus = 'Active'
													");

                          while($row = mysqli_fetch_assoc($fetch_diseasecount))	{
                            $diseasecount = $row['diseasecount'];
                          }

													if(mysqli_num_rows($fetch_disease)>0)	{
														while ($row = mysqli_fetch_assoc($fetch_disease))	{
															$diseaseid = $row['intDiseaseId'];
															$diseasename = $row['strDisease'];
                        ?>
                            <input type ="hidden" value="<?php echo $diseaseid ?>" name ='hidden_ID' id='hidden_ID'>
                            <input type ="hidden" value="<?php echo $diseasecount ?>" id ='hidden_count'>
                            <tr>
                              <td><?php echo $diseasename; ?></td>
                              <td>
																<input type="number" step = 'any' class="form-control d_remarks" placeholder="Enter Remarks" name = "D_remarks<?php echo $diseaseid; ?>" id = "<?php echo $diseaseid; ?>"  data-trial='hi' required>
															</td>
                              <td>
                                <select class="form-control" name="D_screener<?php echo $diseaseid; ?>" id="D_screener<?php echo $diseaseid; ?>" required>
                                <?php
                                  include("connections.php");

                                  $fetch_staff = mysqli_query($connections, "
																		SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
                                    FROM tblemployee
																		WHERE stfEmployeeStatus = 'Active'
                                  ");

                                  if(mysqli_num_rows($fetch_staff) > 0 )	{
                                    while($row = mysqli_fetch_assoc($fetch_staff))	{
                                      $fullname = $row["Fullname"];

                                ?>
                                      <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                                <?php
                                    }
                                  }
                                ?>
                                </select>
                              </td>
                              <td>
                                <select class="form-control" name="D_verifier<?php echo $diseaseid; ?>" id="D_verifier<?php echo $diseaseid; ?>" required>
                                <?php
                                  include("connections.php");

                                  $fetch_staff = mysqli_query($connections, "
																		SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
																		FROM tblemployee
																		WHERE stfEmployeeStatus = 'Active'
                                  ");

                                  if(mysqli_num_rows($fetch_staff) > 0 )	{
                                    while($row = mysqli_fetch_assoc($fetch_staff))	{
                                      $fullname = $row["Fullname"];
                                ?>
                                      <option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                                      <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </td>
                              <!--<td>
                                <label class="radio-inline"><input type="radio" name="optradiosero<?php echo $diseaseid; ?>" id="optradiosero<?php echo $diseaseid; ?>" value="Passed" required>Negative</label>
                                <label class="radio-inline"><input type="radio" name="optradiosero<?php echo $diseaseid; ?>" id="optradiosero<?php echo $diseaseid; ?>" value="Failed" required>Positive</label>
                              </td>-->
                              <td>
                                <button type = "button" class ="btn btn-danger" disabled style="display:none;" id = "remarkspositive<?php echo $diseaseid; ?>" >POSITIVE</button>
                                <button type = "button" class ="btn btn-success" disabled style="display:none;" id = "remarksnegative<?php echo $diseaseid; ?>" >NEGATIVE</button>
                              </td>
                            </tr>
                        <?php
														}
													}
                        ?>
                      </tbody>
                    </table>
                    <label for="D_phlebotomist">Phlebotomist</label>
                    <select class="form-control" name="D_phlebotomist" id="D_phlebotomist" required>
                    <?php
                      include("connections.php");

                      $fetch_staff = mysqli_query($connections, "
												SELECT CONCAT(strEmployeeFirstName,' ',strEmployeeMiddleName,' ',strEmployeeLastName) AS 'Fullname'
                        FROM tblemployee
												WHERE stfEmployeeStatus = 'Active'
                      ");

                      if(mysqli_num_rows($fetch_staff) > 0 )	{
                        while($row = mysqli_fetch_assoc($fetch_staff))	{
                          $fullname = $row["Fullname"];
                    ?>
													<option value="<?php echo $fullname ?>"><?php echo $fullname ?></option>
                    <?php
                        }
											}
										?>
                    </select>
                    <button type="submit" class="btn btn-success mt-2 float-right" id='donorserorecord_save'>Save</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modal declaration -->
  <div class="modal fade" id="editdonorinfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="editdonorinfo">
						<i class="fa fa-edit px-2 fa-sm"></i> 
						Edit Donor Info
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-close="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form name="editdonor">
              <div class="form-group">
                <input type = "hidden" id ='clientId' name ='clientId'>
                <label for="clientfname">First Name</label>
                <input type="text" class="form-control" id='clientfname' name ='clientfname' >
              </div>
              <div class="form-group">
                <label for="clientminit">Middle Name</label>
                <input type="text" class="form-control" id='clientminit' name ='clientminit'>
              </div>
              <div class="form-group">
                <label for="clientlname">Last Name</label>
                <input type="text" class="form-control" id='clientlname' name ='clientlname'>
              </div>
              <div class="form-group">
                <label for="clientocc">Occupation</label>
                <input type="text" class="form-control" id='clientocc' name ='clientocc'>
              </div>
              <div class="form-group">
                <label for="clientcontact">Contact</label>
                <input type="number" class="form-control" id='clientcontact' name="clientcontact">
              </div>
              <div class="form-group">
                <label for="clientsex">Sex</label>
                <select class ='form-control' name='clientsex' id = 'clientsex' disabled>
                  <option value='Male'>Male</option>
                  <option value='Male'>Female</option>
                </select>
              </div>
              <div class="form-group">
                <label for="clientbloodtype">Blood Type</label>
                <select class="form-control" name="clientbloodtype" id="clientbloodtype">
                <?php
                  include("connections.php");

                  $fetch_bloodtype = mysqli_query($connections, "
										SELECT *
										FROM tblbloodtype
										WHERE stfBloodTypeStatus = 'Active'
									");

                  if(mysqli_num_rows($fetch_bloodtype) > 0 )	{
                    while($row = mysqli_fetch_assoc($fetch_bloodtype))	{
                      $blood_typeid = $row["intBloodTypeId"];
                      $blood_type = $row["stfBloodType"];
                      $rhesus = $row["stfBloodTypeRhesus"];
                ?>
                      <option value="<?php echo $blood_typeid ?>"><?php echo $blood_type." ".$rhesus ?></option>
                <?php
                    }
                  }
                ?>
                </select>
              </div>
              <div class="form-group">
                <label for="clientcivstat">Civil Status</label>
                <select name="clientcivstat" class="form-control" id="clientcivstat">
                  <option value="Married">Married</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Separated">Separated</option>
                  <option value="Divorced">Divorced</option>
                  <option value="Single">Single</option>
                </select>
              </div>
              <div class="form-group">
                <label for="clientbday">Birthday</label>
                <input type="text" class="form-control" id='clientbday' disabled>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times pr-1 fa-sm"></i> 
							Close
						</button>
            <button type="submit" class="btn btn-success" id="submit_editdonor">
						<i class="fa fa-save pr-1 fa-sm"></i> 
							Save
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="chooseStorageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form name='change_storageForm' id='change_storageForm'>
            <div class="form-group">
              <label for="bloodbag_underquarantine2">Underquarantined Blood</label>
              <input type="text" id ="bloodbag_underquarantine2" class = "form-control" name = "bloodbag_underquarantine2" readonly required>
            </div>
            <div class="form-group">
              <label for="chosenStorage">Choose a Storage</label>
              <select class="form-control" name="chosenStorage" id="chosenStorage" required>
              <?php
                $fetch_storage = mysqli_query($connections, "
									SELECT intStorageId, intStorageCapacity, strStorageName
									FROM tblstorage
									WHERE intStorageTypeId = 2
								");

                if(mysqli_num_rows($fetch_storage) > 0 )	{
                  while($row = mysqli_fetch_assoc($fetch_storage))	{
                    $storageid = $row["intStorageId"];
                    $storagename = $row["strStorageName"];
                    $storagecapacity = $row["intStorageCapacity"];

                    $check_ifmayspacepa = mysqli_query($connections,"
											SELECT COUNT(intBloodBagId) AS bloodcount
											FROM tblbloodbag bb
											JOIN tblstorage s ON bb.intStorageId = s.intStorageId
											WHERE intBloodDispatchmentId = '1'
											AND stfIsBloodBagExpired = 'No'
											AND intStorageTypeId = 2
											AND s.intStorageId = $storageid
										");

                    while ($row2 = mysqli_fetch_assoc($check_ifmayspacepa)) {
                      $quantity = $row2["bloodcount"];
                    }

                    if($quantity < $storagecapacity)	{
              ?>
                    <option value="<?php echo $storageid ?>"><?php echo $storagename ?></option>
              <?php
										}
                  }
                }
              ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="submit_changestorage">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php 
  include "components/core-script.php";
  ?>
  <script src="../public/js/datatables.min.js"></script>
  <script src="../public/js/notification.js"></script>
  <script src="../public/js/jquery-ui.js"></script>
  <script>
    $('#transaction').addClass('active');
    $('#donor-records').addClass('active');
    $('.loader').hide();
    $('.screenDate').datepicker({
      dateFormat: 'yy-mm-dd'
    });
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

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });

    //show donor records
    let donorRecords = 'donorRecords';
    $('#tblDonorRecords').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs':	[{
				'orderable': false,
				'targets': 1
			}],
      'ajax': {
        url: '../controller/donor/datatables.php',
        type: 'POST',
        data: { type: donorRecords }
      }
    });
    $('#tblDonorRecords').on("click", ".btnAddphysical", function(){
      var clientid = $(this).attr("data-id");
      console.log(clientid);
      $('#clientId_phys').val(clientid);

      $.ajax({
        type: "POST",
        url: '../controller/donor/fetchNewDonorInfo.php',
        data: 'clientid=' + clientid,
        dataType: "json",
        success:function(data){
          $('#cname').text(data.strClientFirstName);
          $('#cname').append(" ");
          $('#cname').append(data.strClientMiddleName);
          $('#cname').append(" ");
          $('#cname').append(data.strClientLastName);
          $('#cbday').text(data.datClientBirthday);
          $('#csex').text(data.stfClientSex);
          $('#ccontact').text(data.strClientContact);
          $('#ccivstat').text(data.stfClientCivilStatus);
          $('#coccupation').text(data.strClientOccupation);
          $('#donorRecords').hide(600);
          // $('#divsearchdonor').hide(600);
          $('#donorInfo').show(600);
          $('#addPhysical').show(600);
          $('#clientId_phys').val(clientid);
          $('#clientId_init').val(clientid);
          $('#clientId_sero').val(clientid);
        }
      });
    });

    $('#tblDonorRecords').on("click", ".btnAddinitial", function(){
      var clientid = $(this).attr("data-id");
      console.log(clientid);
      $('#clientId_init').val(clientid);

      $.ajax({
        type: "POST",
        url: '../controller/donor/fetchNewDonorInfo.php',
        data: 'clientid=' + clientid,
        dataType: "json",
        success: function(data){
          $('#cname').text(data.strClientFirstName);
          $('#cname').append(" ");
          $('#cname').append(data.strClientMiddleName);
          $('#cname').append(" ");
          $('#cname').append(data.strClientLastName);
          $('#cbday').text(data.datClientBirthday);
          $('#csex').text(data.stfClientSex);
          $('#ccontact').text(data.strClientContact);
          $('#ccivstat').text(data.stfClientCivilStatus);
          $('#coccupation').text(data.strClientOccupation);
          $('#donorRecords').hide(600);
          // $('#divsearchdonor').hide(600);
          $('#donorInfo').show(600);
          $('#addInitial').show(600);
        }
      })
    });

    $('#tblDonorRecords').on("click", ".btnAddserological", function(){
      var clientid = $(this).attr("data-id");
      console.log(clientid);
      $('#clientId_sero').val(clientid);

      $.ajax({//kung magpoproceed sa sero kunin mo yung nakaquarantine na bloodbag
        type: "POST",
        url: '../controller/blood/fetchUnderQuarantineBloodBag.php',
        data: {clientid:clientid},
        success:function(data){
          $('#bloodbag_underquarantine').val(data);
          $('#bloodbag_underquarantine2').val(data);
        }
      });

      $.ajax({
        type: "POST",
        url: '../controller/donor/fetchNewDonorInfo.php',
        data: 'clientid=' + clientid,
        dataType: "json",
        success:function(data){
          $('#cname').text(data.strClientFirstName);
          $('#cname').append(" ");
          $('#cname').append(data.strClientMiddleName);
          $('#cname').append(" ");
          $('#cname').append(data.strClientLastName);
          $('#cbday').text(data.datClientBirthday);
          $('#csex').text(data.stfClientSex);
          $('#ccontact').text(data.strClientContact);
          $('#ccivstat').text(data.stfClientCivilStatus);
          $('#coccupation').text(data.strClientOccupation);
          $('#donorRecords').hide(600);
          // $('#divsearchdonor').hide(600);
          $('#donorInfo').show(600);
          $('#addSerological').show(600);
        }
      });
    });

    $(".d_remarks").change(function(){
      var diseasecount = $(this).attr("id");
      var input = parseFloat($(this).val());
      var sex = $("#csex").text();
      console.log(sex);

      if(input <= 1.0 && input >= 0.1){
      $("#remarkspositive"+diseasecount).hide();
      $("#remarksnegative"+diseasecount).show();
      }else{
      $("#remarkspositive"+diseasecount).show();
      $("#remarksnegative"+diseasecount).hide();
      }
    });

    $(".BC_result").change(function(){
      var bccount = $(this).attr("id");
      var input = parseFloat($(this).val());
      var sex = $("#csex").text();
      var ml = $(this).data('ml');
      var mm = $(this).data('mm');
      var fl = $(this).data('fl');
      var fm = $(this).data('fm');
      console.log(ml+mm+fl+fm+sex);
      if(sex == 'Male'){
        if(input >= ml && input <= mm){
          $("#BCremarkspassed"+bccount).show();
          $("#BCremarksfailed"+bccount).hide();
        }else{
          $("#BCremarkspassed"+bccount).hide();
          $("#BCremarksfailed"+bccount).show();
        }
      }else if (sex =='Female'){
        if(input >= fl && input <= fm){
          $("#BCremarkspassed"+bccount).show();
          $("#BCremarksfailed"+bccount).hide();
        }else{
          $("#BCremarkspassed"+bccount).hide();
          $("#BCremarksfailed"+bccount).show();
        }
      }
    });

    //check the exam remark selected
  $("#examremarks").change(function() {
    var chosenType = (this).value;

    if(chosenType == 'Temporarily Deferred'){
      $("#reason").show();
      $("#amount").hide();
      $("#bloodamount").val("N/A");
      $("#reasonfordeferal").prop('required',true);
      $("#instruction").prop('required',true);
      $("#bloodamount").prop('required',false);
    }
    else if (chosenType == 'Permanently Deferred') {
      $("#reason").show();
      $("#amount").hide();
      $("#bloodamount").val("N/A");
      $("#reasonfordeferal").prop('required',true);
      $("#instruction").prop('required',true);
      $("#bloodamount").prop('required',false);
    }
    else if (chosenType == 'Accepted'){
      $("#amount").show();
      $("#bloodamount").prop('required',true);
      $("#reason").hide();
      $("#reasonfordeferal").val("");
      $("#reasonfordeferal").prop('required',false);
      $("#instruction").val("");
      $("#instruction").prop('required',false);
    }
  });

  

  $('#editdonorinfo').on('show.bs.modal', function(e) {
    var rowid = $(e.relatedTarget).data('id');
    //alert(rowid);
    $.ajax({
      type: "POST",
      url: '../controller/donor/fetchDonorInfo.php',
      data: 'rowid=' + rowid,
      dataType: "json",
      success: function(data){
        $('#clientId').val(data.intClientId);
        $('#clientfname').val(data.strClientFirstName);
        $('#clientminit').val(data.strClientMiddleName);
        $('#clientlname').val(data.strClientLastName);
        $('#clientcontact').val(data.strClientContact);
        $('#clientsex').val(data.stfClientSex);
        $('#clientbloodtype').val(data.intBloodTypeId);
        $('#clientcivstat').val(data.stfClientCivilStatus);
        $('#clientbday').val(data.datClientBirthday);
        $('#clientocc').val(data.strClientOccupation);
        /*var btype = $('#clientbloodtype').val();
        console.log(btype);*/
      }
    });
  });

  $("form[name = 'editdonor' ]").submit(function(e){
    e.preventDefault();
    var clientocc = $("#clientocc").val();
    var clientcontact = $("#clientcontact").val();
    var clientcivstat = $("#clientcivstat").val();
    var confirm_input = confirm("Are you sure?");
    var formdata = $(this).serialize();
    console.log(formdata);
    if(clientcontact.length == 11)
    {
      if(confirm_input == true)
      {
        $.ajax({
          url: "../controller/donor/editDonorRecord2.php",
          method: "POST",
          data: {formdata : formdata},
          success:function(data){
            console.log(data);
            if (data == '1')
            {
              alert("Edit Successful");
              $('#editdonorinfo').modal('hide');
              $("#editdonorinfo .modal-body input").val("");
            }
            else if(data == '2')
            {
              alert("Edit Unsuccessful");
            }
          }
        });
      }
    }else{
      alert("Invalid Contact");
    }
  });

  $("form[name='adddonorphysrecord']").on('submit',function(e){
    e.preventDefault();
    var status =$("#donorstatus option:selected").text();
    var confirm_input = confirm("Are you sure? Once you hit OK you cannot change your inputs");

    if(confirm_input == true){

      e.preventDefault();
      var formdata = $("form[name='adddonorphysrecord']").serialize();
      console.log(formdata);
      $.ajax({
        type: "POST",
        url: '../controller/donor/savePhysicalExam.php',
        data: {formdata,formdata},
        success:function(data){
          console.log(data);
          if (data == '1')
          {
            alert("Insert Successful");
            $('#addPhysical').hide(600);
            $('#addInitial').show(600);
          }
          else if(data == '2')
          {
            alert("Insert Successful, You will not proceed to Initial Screening because the donor failed in Physical Exam");
            $("#donorphysrecord_save").hide();
            $("#btnclearphys").hide();
          }
          else if (data == '3') {
            alert("Insert Unsuccessful");
          }
          else if(data == '42'){
            alert("Insert Succesful, Donor will not be allowed to donate again");
            $('#donorphysrecord_save').hide(600);

          }
          else if(data == '5'){
            alert("Insert unsuccesful, The date must not be greater than today's date");


          }
        }
      });
    }//confirm
    else{
      alert("Confirmation Cancelled");
      return false;
    }

  });

  $("form[name='adddonorinitexam']").on('submit',function(e){
    e.preventDefault();
    var confirm_input = confirm("Are you sure? Once you hit OK you cannot change your inputs");
    var donor_id = $('#clientId_init').val();
    var formdata = $("form[name='adddonorinitexam']").serialize();
    console.log(formdata);
    if (confirm_input == true){

      $.ajax({
        type: "POST",
        url: '../controller/donor/saveDonorInitialExam.php',
        data: {formdata,formdata},
        success:function(data){
          console.log(data);
          if(data == '1'){
            alert("Insert Successful");
            $('#addInitial').hide(600);
            $('#addSerological').show(600);

            $.ajax({//kung magpoproceed sa sero kunin mo yung nakaquarantine na bloodbag
              type: "POST",
              url: '../controller/blood/fetchNewUnderQuarantineBloodBag.php',
              data: {donor_id,donor_id},
              success:function(data){
                $('#bloodbag_underquarantine').val(data);
              }
            });

          }
          else if(data == '2'){
            alert("Insert Successful, You will not proceed to Serological Screening because the donor failed in Initial Screening Exam");
            $('#donorinitrecord_save').hide();
          }
          else if(data == '3'){
            alert("Insert Unsuccessful");
          }
          else if(data == '4'){
            alert("Insert Unsuccessful,The date must not be greater than today's date");
          }

        }
      });
    }//if true
    else{
      alert("Confirmation Cancelled");
      return false;
    }
  });

  $("form[name='change_storageForm']").on('submit',function(e){
    e.preventDefault();
    var confirm_input = confirm("Are you sure?");
    var formdata = $("form[name='change_storageForm']").serialize();

    if (confirm_input == true){
      console.log(formdata);
      $.ajax({
        type:"POST",
        url:"../controller/blood/updateStorage.php",
        data:{formdata,formdata},
        success:function(data){
          console.log(data);
          if(data == 1){
          $('#chooseStorageModal').modal('hide');
          window.location.href = "donor-records.php";
        }
        else{
          alert("We've encountered an error"+' '+data);
        }
        }
      });
    }else{
      alert("Confirmation Cancelled");
      return false;
    }
  });

  $("form[name='adddonorseroexam']").on('submit',function(e){
    e.preventDefault();
    var confirm_input = confirm("Are you sure? Once you hit OK you cannot change your inputs");
    var formdata = $("form[name='adddonorseroexam']").serialize();

    if (confirm_input == true){
      console.log(formdata);
      $.ajax({
        type: "POST",
        url: '../controller/donor/saveDonorSerologicalExam.php',
        data: {formdata,formdata},
        success:function(data){
          console.log(data);
          if(data == 1){
            console.log(data);
            alert("Insert Unsuccessful");
          /*  $('#div_donoraddserological').hide(600);
            $('#donorinitrecord_save').hide();*/
            //$('#donortable').show();
            //$('#divdonoraddsero').show(600);
          }
          else if(data == 2){
            alert("Insert Unsuccessful, No Blood Bag Record");
          }
          else if(data == 3){
            alert("Insert Succesful, Donor will not be allowed to donate again");
            $('#addSerological').hide(600);
            $('#donorinitrecord_save').hide();
          }
          else if(data == 4){
            alert("Insert Successful, Choose a storage");
            $('#chooseStorageModal').modal('show');
          }
          else if(data == 5){
            alert("Insert Unsuccessful,The date must not be greater than today's date");
          }

        }
      });
    }//if true
    else{
      alert("Confirmation Cancelled");
      return false;
    }
  });
  </script>
</body>
</html>