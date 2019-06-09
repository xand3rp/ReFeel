<?php 
include "../controller/fetchEmpAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Donor Survey Answers</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
</head>
<body>
  <?php include "components/loader.php"; ?>
  <div class="wrapper">
    <?php include "components/sidebar.php"; ?>
    <main class="mainpanel">
      <?php include "components/header.php"; ?>
      <div class="page-title">
        <div class="d-flex justify-content-between">
					<div>
						<h3 class="p-2 align-middle">Donor Survey Answers</h3>
					</div>
					<div class="p-2">
						<button type="button" onclick="location.href='donor-list.php'" class="btn btn-outline-danger">
							<i class="fas fa-long-arrow-alt-left"></i>
							Back
						</button>
					</div>
				</div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 3rem;">
                <?php
								if($_GET['rowid']){
									$surveycode = $_GET['rowid'];
									
									$unchecked_surveys = mysqli_query($connections, "
										SELECT intMedicalExamId, m.intQuestionId, intDonationId, stfAnswerYn, datAnswerDate, intAnswerQuantity, strAnswerString, q.txtQuestion, q.stfQuestionType, q.decQuestionVersion
										FROM tblmedicalexam m
										JOIN tblquestion q ON m.intQuestionId = q.intQuestionId
										WHERE stfAnswerRemarks = 'Unchecked'
										AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 4 DAY) AND NOW()
										AND intDonationId = '$surveycode'
									");
								
                  $getdonorid = mysqli_query($connections,"
										SELECT intClientId
										FROM tbldonation
										WHERE intDonationId = '$surveycode'
									");
									
                  while ($row2 = mysqli_fetch_assoc($getdonorid)) {
                    $client = $row2["intClientId"];
                  }
									
                  if(mysqli_num_rows($unchecked_surveys) > 0)	{
										$qry
                    ?>
                    <form name='submit_update' method='POST' action='save_update_survey.php'>
                      <table class='table table-bordered mt-3 text-center table-hover' id='tbldonorsurvey'>
                        <thead>
                          <tr class='bg-danger text-white'>
														<!-- <th>Donation Id</th> -->
														 
														<!--
														<td>Question</td>
														<td>Yes/No</td>
														<td>Date</td>
														<td>Quantity</td>
														<td>String</td>
														<td>Action</td>
														-->
														
														<td style='width: 05%'>No.</td>
														<td style='width: 55%'>Question</td>
                            <td style='width: 25%'>Answers</td>
                            <td style='width: 15%'>Action</td>
                          </tr>
                        </thead>
                        <?php
													$varCounter = 1;
													
													while ($row = mysqli_fetch_assoc($unchecked_surveys)) {
														$id = $row["intQuestionId"];
														//$client = $row["intClientId"];
														$examcode = $row["intDonationId"];
														$question = $row["txtQuestion"];
														$yn = $row["stfAnswerYn"];
														$date = $row["datAnswerDate"];
														$quantity = $row["intAnswerQuantity"];
														$string = $row["strAnswerString"];
														$qtype = $row["stfQuestionType"];
                          ?>
                          <tbody>
                            <tr>
                              <!-- <td><?php echo $examcode; ?></td> -->
															
                              <td class="align-middle"><?php echo $varCounter; ?></td>
                              <td class="align-middle"><?php echo $question; ?></td>
															
															<!--
                              <td><?php echo $yn; ?></td>
                              <td><?php echo $date; ?></td>
                              <td><?php echo $quantity; ?></td>
                              <td><?php echo $string; ?></td>
															-->
															
															<td class="align-middle">
																<?php
																	echo isset($yn) && $yn != '' ? ($yn == 'Yes' ? 'Oo' : 'Hindi') . '<br>' : null;
																	echo isset($date) && $date != '0000-00-00' ? date_format(date_create($date), 'F d, Y') . '<br>' : null;
																	echo isset($quantity) && stripos($qtype, "Qua") ? $quantity . '<br>' : null;
																	echo isset($string) && $string != '' ? $string . '<br>' : null;
																?>
															</td>
															
                              <td>
																<div class="btn-group-toggle" data-toggle='buttons'>
																	<label class='btn btn-outline-success form-control mb-2' value='Correct'>
																		<input type='radio' name='updatestatus<?php echo $id;?>' id='updatestatus<?php echo $id; ?>' value='Correct' autocomplete='off' required='required' />Acceptable
																	</label>
																	<br>
																	<label class='btn btn-outline-danger form-control' value='Wrong'>
																		<input type='radio' name='updatestatus<?php echo $id;?>' id='updatestatus<?php echo $id; ?>' value='Wrong' autocomplete='off' required='required' />Unacceptable
																	</label>
																</div>
                              </td>
                            </tr>
                          </tbody>
                        <?php
														$varCounter++;
													}
												?>
                      </table>
                      <input type="hidden" name="hiddenclientid" value="<?php echo $client;?>" required>
                      <input type="hidden" name="hiddenexamcode" value="<?php echo $examcode;?>" required>
                      <button type='submit' class='btn btn-outline-danger float-right' id='updatesurvey_save'>Submit</button>
                    </form>
                    <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <?php include "components/core-script.php"; ?>
	<script src="../public/js/sweetalert.min.js" type="text/javascript"></script>
  <script src="../public/js/notification.js"></script>
  <script>
	
	
  $('#home').addClass('active');
  $('#donor-list').addClass('active');
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

  $(function()	{
    $("form[name ='submit_update']").on('submit',function(e)	{
      e.preventDefault();
      var formdata = $("form[name ='submit_update']").serialize();
      console.log(formdata);
      // var confirmbutton = confirm("Are you sure?");
      // if(confirmbutton == true)	{
        // $.ajax({
          // url:"../controller/survey/saveUpdateSurvey.php",
          // method:"POST",
          // data:{formdata,formdata},
          // success: function(data){
            // alert("Survey has been checked");
            // window.location.href = "donor-list.php";
            // console.log(data);
          // }
        // });
      // }
      // else	{
        // alert("Confirmation Cancelled");
        // return false;
      // }
			
			var span = document.createElement("span");
			// span.innerHTML = "Acceptable answers: <span class='text-success'></span>" + "<br>" + "Unacceptable answers: " + "<br><br>" + "Are you sure you want to submit the checked survey?";
			// span.innerHTML = "Are you sure you want to submit the checked survey?";
			
			swal({
				title: 'Notice.',
				// content: span,
				text:  "Are you sure you want to submit the checked survey?",
				icon: 'warning',
				dangerMode: true,
				buttons: ['No', 'Yes'],
			}).then((willRequest) => {
				if(willRequest)	{
					$.ajax	({
						url: "../controller/survey/saveUpdateSurvey.php",
						type: "POST",
						data: {formdata:formdata},
						success: function(data)	{
							console.log(data);
							swal({
								title: 'Done!',
								text: 'Survey has been checked.',
								icon: 'success'
							}).then(() => {
								window.location.href = 'donor-list.php'
							});
						}
					});
				}
				else	{
					swal({
						text: 'Confirmation cancelled.',
					})
				}
			});
    });
  });
  </script>
</body>
</html>