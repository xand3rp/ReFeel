<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Survey</title>
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
    <?php include "components/sidebar.php"; ?>
    <main class="mainpanel">
      <?php include "components/header.php"; ?>
			<a href ="addNewSurvey.php">
				<button title="Add new survey" class="btn btn-lg btn-danger" style="position: fixed; bottom: 20px; right: 30px; z-index: 99; border-radius: 60px;">
					<i class="fas fa-plus"></i>
				</button>
			</a>
			<a href="#jump">
				<button title="Back to Top" class="btn btn-lg btn-danger" style="position: fixed; bottom: 80px; right: 30px; z-index: 99; border-radius: 60px;">
					<i class="fas fa-angle-double-up"></i>
				</button>
			</a>
      <div class="page-title">
        <h3 class="p-2">Survey</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 4rem">
                <h4 id="jump" class="py-2">Available Surveys</h4>
                <?php
                  $fetchsurveyvercurr = mysqli_query($connections,"
										SELECT DISTINCT(decQuestionVersion)
										FROM tblquestion
										WHERE boolVersionInUse = '1'
									");
									$rowsurveyvercurr = mysqli_fetch_assoc($fetchsurveyvercurr);
									$varsurveyvercurr = $rowsurveyvercurr["decQuestionVersion"];
									
									$fetchsurveyverunused = mysqli_query($connections,"
										SELECT DISTINCT(decQuestionVersion)
										FROM tblquestion
										WHERE boolVersionInUse = '0'
										ORDER BY 1 ASC
									");
                ?>
                <table class='table table-bordered table-hover mt-2 text-center' id='tblsurvey' style="tr:first-child {background-color: rgb(234,72,127)}">
									<tr class="text-white" style="background-color: #ff4848;">
										<td>Survey Version</td>
										<td>Action</td>
									</tr>
									<tbody>
										<tr class="text-danger">
											<td class="align-middle">
												<?php echo $varsurveyvercurr;?>
											</td>
											<td class="">
												<a href ="fetchSurvey.php?selected=<?php echo $varsurveyvercurr; ?>">
													<button type='button' class='btn btn-outline-secondary btn-sm'  name = 'check_survey'>
														<i class="fa fa-eye fa-sm mr-1"></i>
														View
													</button>
												</a>
											</td>
										</tr>
									<?php
										while ($row = mysqli_fetch_assoc($fetchsurveyverunused)) {
											$version = $row["decQuestionVersion"];
											//$inuse = $row["boolVersionInUse"];

											/*if($inuse == '1'){
												$inusetext = "Yes";
											}
											elseif ($inuse == '0') {
												$inusetext = "No";
											}*/

									?>
										<tr>
											<td class="align-middle"><?php echo $version; ?></td>
											<td>
												<a href ="fetchSurvey.php?selected=<?php echo $version; ?>">
													<button type='button' class='btn btn-outline-secondary btn-sm'  name = 'check_survey'>
														<i class="fa fa-eye fa-sm mr-1"></i>
														View
													</button>
												</a>
											</td>
										</tr>
									<?php 
										}
									?>
									</tbody>
                </table>
                <!--<a href ="addNewSurvey.php"><button type = 'button' class='btn btn-outline-danger float-right mt-1' id = "make_survey" style="margin-top: -10px">Make a new Survey</button></a>-->
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
    $('#maintenance').addClass('active');
    $('#survey').addClass('active');
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