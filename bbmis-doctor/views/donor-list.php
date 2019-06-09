<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Donor List</title>
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
        <h3 class="p-2">Donor List</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container">
                <h4 class="p-2">Unchecked Survey</h4>
                <div id="donorSurveyList" class="text-center">
                  <!-- content goes here -->
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container">
                <h4 class="p-2">Expected Donors</h4>
                <div id="expectedDonor" class="text-center">
                  <!-- content goes here -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <?php include "components/core-script.php"; ?>
  <script src="../public/js/notification.js"></script>
  <script>
    // 'use strict';
    $('#home').addClass('active');
    $('#donor-list').addClass('active');
    $('.loader').hide();

    checkExpiringBloodBags();
    fetchExpectedDonor();
    fetchUncheckedSurveys();

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

    // show donor list
    function fetchUncheckedSurveys() {
      let uncheckedSurveyRes = ``;
      $.ajax({
        url: "../controller/survey/fetchUncheckedSurvey.php",
        dataType: "json",
        success: data => {
          console.log(data);
          if (data.length == 0) {
            uncheckedSurveyRes = `
							<i class="fas fa-scroll fa-7x"></i>
							<!--<h4 style="margin: 10px 0px 10px 0px">No unchecked surveys found.</h4>-->
							<h4 class='my-3'>No unchecked surveys found.</h4>
            `;
            $('#donorSurveyList').html(uncheckedSurveyRes);
          } 
					
					else if (data.length !== 0) {
            uncheckedSurveyRes = `
            <table class='table table-bordered table-hover text-center' id='tbldonorsurvey'>
              <thead>
                <tr class="bg-danger text-white">
									<td style='width: 15%'>Exam Code</td>
									<td style='width: 15%'>Donor Code</td>
									<td style='width: 45%'>Donor/Applicant Name</td>
									<td style='width: 25%'>
										<i class=""></i>
										Action
									</td>
                </tr>
              </thead>
              <tbody>
                ${ iterateOverUncheckedSurvey(data) }
              </tbody>
            </table>
            `;
            $('#donorSurveyList').html(uncheckedSurveyRes);
          }
        },
        complete: function() {
          setTimeout(fetchUncheckedSurveys, 5000);
        }
      });
    }

    function iterateOverUncheckedSurvey(arr) {
      return arr.map( obj => {
        return `
        <tr>
          <td class="align-middle">${ obj.intDonationId }</td>
          <td class="align-middle">${ obj.intClientId }</td>
          <td class="align-middle">${ obj.Applicant_DonorName }</td>
          <td>
						<a href="fetchDonorSurveyAnswers.php?rowid=${ obj.intDonationId }">
							<button type="button" class="btn btn-sm btn-success" data-id="${ obj.intDonationId }">
								<i class="fa fa-check fa-sm mr-1"></i>
								Check Survey
							</button>
						</a>
					</td>
        </tr>
        `;
      });
    }

    function fetchExpectedDonor() {
      let expectedDonor = ``;
      
      $.ajax({
        url: '../controller/donor/fetchExpectedDonor.php',
        dataType: 'json',
        success: data => {
          console.log(data);
          
          if (data.length == 0) {
            expectedDonor = `
							<i class="fas fa-user-slash fa-7x"></i>
							<h4 class='my-3'>No expected donor found.</h4>
            `;
            $('#expectedDonor').html(expectedDonor);
          } 
					else if (data.length !== 0) {
            let iterateExpDonor = iterateOverExpectedDonor(data).toString();
            expectedDonor = `
							<table class='table table-bordered table-hover text-center' id='tbldonorsurvey'>
								<thead>
									<tr class="bg-danger text-white">
										<td style='width: 15%'>Exam Code</td>
										<td style='width: 15%'>Donor Code</td>
										<td style='width: 45%'>Donor/Applicant Name</td>
										<td style='width: 25%'>Date</td>
									</tr>
								</thead>
								<tbody> 
									${ iterateExpDonor.replace(/[,]/g, "") }
								</tbody>
							</table>
            `;
            $('#expectedDonor').html(expectedDonor);
            // console.log(iterateOverExpectedDonor(data));
          }
        },
        complete: function() {
          setTimeout(fetchExpectedDonor, 5000);
        }
      });

    }
    //show expected donor

    function iterateOverExpectedDonor(arr) {
      console.log(arr);
      return arr.map( obj => {
        return `
        <tr>
          <td>${ obj.intDonationId }</td>
          <td>${ obj.intClientId }</td>
          <td>${ obj.Applicant_DonorName }</td>
          <td>${ obj.Expectation_Date }</td>
        </tr>
        `;
      });
    }
  </script>
	</body>
</html>