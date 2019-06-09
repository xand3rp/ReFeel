<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - New Survey</title>
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
      <div class="page-title">
        <h3 class="p-2">Create Survey</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container">
                <div id = "items" class="pt-2">
                  <div class="form-group">
                    <label for="question_text">Question</label>
                    <input type="text" class = "form-control" placeholder="Insert Question Here" id ="question_text">
                  </div>
                  <div class="form-row">
                    <div class="col">
                      <label for="questiontype">Question Type</label>
                      <select id = "questiontype" name="questiontype" class = "form-control">
                        <option value = "Yn">Yes/No</option>
												<option value = "YnDate">Yes/No, Date</option>
												<option value = "YnQua">Yes/No, Quantity</option>
												<option value = "YnStr">Yes/No, String</option>
												<option value = "YnDateQua">Yes/No, Date, Quantity</option>
												<option value = "YnDateStr">Yes/No, Date, String</option>
												<option value = "YnQuaStr">Yes/No, Quantity, String</option>
												<option value = "YnDateQuaStr">Yes/No, Date, Quatity, String</option>
												<option value = "Date">Date</option>
												<option value = "DateQua">Date, Quantity</option>
												<option value = "DateStr">Date, String</option>
												<option value = "DateQuaStr">Date, Quantity, String</option>
												<option value = "Qua">Quantity</option>
												<option value = "QuaStr">Quantity, String</option>
												<option value = "Str">String</option>
                      </select>
                    </div>
                    <div class="col">
                      <label for="questioncategory">Question Category</label>
                      <select id = "questioncategory" name = questioncategory class = "form-control">
                        <?php
													include("../connections.php");

													$getcategories = mysqli_query($connections,"
														SELECT *
														FROM tblquestioncategory
														WHERE stfQuestionCategoryStatus = 'Active'
													");
													while($row = mysqli_fetch_assoc($getcategories)){
														$category = $row["stfQuestionCategory"];
														$categoryid = $row["intQuestionCategoryId"]
												?>
														<!--
														<option value = "<?php echo $categoryid;?>"><?php echo $categoryid."  ".$category;?> </option>
														-->
														<option value = "<?php echo $categoryid;?>"><?php echo $category;?> </option>
												<?php
													}
                        ?>
                      </select>
                    </div>
                  </div>
									<div class="d-flex justify-content-end">
										<button id ="submit_item" class = "btn btn-success mt-3">
											<i class="fa fa-plus mr-1"></i>
											Add Question
										</button>
									</div>
								</div>
								<hr>
								<div id = "survey_items">
									<form method="post" name="save_questions">
										<!--
										<h4 class="mt-3" style="font-family: 'Nunito-Regular'">Survey Form</h4>
										-->
										<h4 class="pb-2">Survey Form</h4>
										<table id = "table_questions" class='table table-bordered text-center'>
											<thead>
												<tr class="bg-danger text-white">
													<td style="width: 5%">Select</td>
													<td style="width: 45%">Question</td>
													<td style="width: 25%">Question Category</td>
													<td style="width: 25%">Question Type</td>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
										<div class="d-flex justify-content-end pb-2">
											<button type="button" class="delete-row btn btn-outline-danger mr-2">
												<i class="fa fa-trash mr-1"></i>
												Delete Row
											</button>
											<button type="button" id = "save" class="btn btn-success">
												<i class="fa fa-save mr-1"></i>
												Save
											</button>
										</div>
									</form>
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

    var tr_number = 1;

    $('#submit_item').click(function() {
      var chosenType = $('#questiontype option:selected').val();
      var chosenCategory = $('#questioncategory option:selected').val();
      var question = $("#question_text").val();

      var total_row = "<tr><td class='align-middle'><input type='checkbox' name='record'></td><td class='align-middle'>" + "<textarea class = 'form-control' name = 'question"+tr_number+"' "+"value = '"+ question +"'>" +question+ "</textarea></td><td class='align-middle'>" + "<input class='form-control' type ='text' name = 'category"+tr_number+"' "+"value = '" + chosenCategory +"' readonly>" + "</td><td class='align-middle'>" + "<input class='form-control' type ='text' name = 'type"+tr_number+"' "+"value = '" + chosenType + "' readonly>" + "</td></tr>";

      console.log(total_row+question);
      $("table tbody").append(total_row);

      $("#acceptableValue input").val("");
      $("#items input").val("");
      tr_number = tr_number + 1 ;
    });

    $(".delete-row").click(function(){
      $("table tbody").find('input[name="record"]').each(function(){
          if($(this).is(":checked")){
              $(this).parents("tr").remove();
          }
      });
    });

    $("#save").click(function(e){
      e.preventDefault();
      var formdata = $("form[name ='save_questions']").serialize();
      var rowCount = $('#table_questions tr').length;
      var confirm_input = confirm("Are you sure?");
      console.log(formdata);
      console.log(rowCount);
      if(confirm_input == true){
        $.ajax({
          type: "POST",
          url: '../controller/survey/saveSurvey.php',
          data: {formdata:formdata,
                  rowCount:rowCount},
          dataType: "json",
          success:function(data){
            console.log(data);
            alert("You have just created a new survey. Version :"+data.decQuestionVersion);
            window.location.href = "survey.php";
          }
        });
      }
      else {
        alert("Confirmation Cancelled");
        return false;
      }
    });
  </script>    
	</body>
</html>