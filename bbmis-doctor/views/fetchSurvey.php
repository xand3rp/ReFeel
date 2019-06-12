<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="../../public/assets/blood.ico">
  <link rel="stylesheet" href="../../public/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/main.css">
  <link rel="stylesheet" href="../../public/css/all.css">
  <link rel="stylesheet" href="../../public/css/jquery-ui.css">
  <link rel="stylesheet" href="../../public/css/bs-override.css">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ReFeel - Survey Questions</title>
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
						<h3 class="p-2 align-middle">Survey Questions</h3>
					</div>
					<div class="p-2">
						<button type="button" onclick="location.href='survey.php'" class="btn btn-outline-danger">
							<i class="fas fa-long-arrow-alt-left mr-1"></i>
							Back
						</button>
					</div>
				</div>
			</div>
			<!--
      <div class="page-title">
        <h3>Survey Questions</h3>
				<a href="#jump">
				<button type="button" onclick="location.href='survey.php'" class="btn"><i class="fas fa-long-arrow-alt-left"></i> Back</button>
			</a>
      </div>
			-->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container pt-3" style="padding-bottom: 4rem;">
                <?php
                  $selectedVer = $_GET["selected"];

                  $questions = mysqli_query($connections,"
										SELECT *
                    FROM tblquestion
                    WHERE decQuestionVersion = $selectedVer
									");
									
									$first_id_qry = mysqli_query($connections,"
										SELECT intQuestionId
										FROM tblquestion
										WHERE decQuestionVersion = $selectedVer
										ORDER BY intQuestionId DESC
										LIMIT 1
									");

									while ($row2 = mysqli_fetch_assoc($first_id_qry)) {
										$first_id = $row2["intQuestionId"];
									}

									if(mysqli_num_rows($questions) > 0)	{
                ?>
                <form method = 'POST' action = 'editquestion.php' id = 'survey' name = 'survey'>
                  <table class='table table-bordered table-hover mb-4 text-center' id='tblsurvey'>
                    <input type="hidden" id='hiddensurveyversion' value='<?php echo $selectedVer;?>'>
                    <thead>
                      <tr class="bg-danger text-white">
                        <td style="width: 45%">Question</td>
                        <td style="width: 15%">Question Type</td>
                        <td style="width: 20%">Question Category</td>
                        <td style="width: 20%">Action</td>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      while($row = mysqli_fetch_assoc($questions))	{
                        $id = $row["intQuestionId"];
                        $question = $row["txtQuestion"];
                        $type = $row["stfQuestionType"];
                        $categoryID = $row["intQuestionCategoryId"];

                        $getcategorystring = mysqli_query($connections,"
													SELECT stfQuestionCategory
													FROM tblquestioncategory
													WHERE intQuestionCategoryId = $categoryID
												");
                        // while ($row3 = mysqli_fetch_assoc($getcategorystring)) {
                        //   $category = $row3["stfQuestionCategory"];
                        // }
                        $row3 = mysqli_fetch_assoc($getcategorystring);
                        $category = $row3["stfQuestionCategory"];
                    ?>
                      <tr id = '<?php echo $row['intQuestionId'];?>'>
                        <td>
													<textarea class='que form-control' value ='<?php echo $question; ?>' name='question<?php echo $id; ?>' id='question<?php echo $id; ?>' readonly><?php echo $question; ?></textarea>
												</td>
                        <td class="align-middle">
													<input type = 'text' value = '<?php echo $type; ?>' name = 'type<?php echo $id; ?>' id='type<?php echo $id; ?>' class = "type form-control" readonly>
												</td>
                        <td class="align-middle">
													<input type = 'text' value = '<?php echo $category; ?>' name = 'category<?php echo $id;?>' id='category<?php echo $id; ?>' class ="cat form-control" readonly>
												</td>
                        <td class="align-middle">
												<!--
                          <button type='button' class='btn' data-toggle='modal' data-target='#editsurveyitem' data-id='<?php echo $row['intQuestionId'];?>'>Edit</button> <button type='button' class='btn btn-danger' data-id='<?php echo $row['intQuestionId'];?>'>Delete</button>
												-->
													<button type='button' class='btn btn-sm btn-outline-primary mr-1' data-toggle='modal' data-target='#editsurveyitem' data-id='<?php echo $row['intQuestionId'];?>'>
														<i class="fa fa-sm fa-edit mr-1"></i>
														Edit
													</button>
													<button type='button' class='btn btn-sm btn-outline-danger deleteQuestion' data-id='<?php echo $row['intQuestionId'];?>'>
														<i class="fa fa-sm fa-trash mr-1"></i>
														Delete
													</button>
                        </td>
                      </tr>
										<!--
										  <tr id = '<?php echo $row['intQuestionId'];?>'>
                        <td class="align-middle"><?php echo $question; ?></td>
                        <td class="align-middle"><?php echo $type; ?></td>
                        <td class="align-middle"><?php echo $category; ?></td>
                        <td class="align-middle">
                          <button type='button' class='btn btn-sm btn-outline-primary mr-1' data-toggle='modal' data-target='#editsurveyitem' data-id='<?php echo $row['intQuestionId'];?>'>
														<i class="fa fa-sm fa-edit mr-1"></i>
														Edit
													</button>
													<button type='button' class='btn btn-sm btn-outline-danger' data-id='<?php echo $row['intQuestionId'];?>'>
														<i class="fa fa-sm fa-trash mr-1"></i>
														Delete
													</button>
                        </td>
                      </tr>
										-->
                    <?php
											}
                    ?>
                    </tbody>
                  </table>
                </form>
                <?php
									}
                ?>
                <div class="mt-3">
                  <button type = 'button' class='btn btn-primary mr-2 float-right' id = 'setasactive'>
										<i class="fa fa-sm fa-check mr-1"></i>
										Set Survey as Active
									</button>
                  <button type = 'button' class='btn btn-success mr-2 float-right' id = 'save_changes' style = 'display : none;'>
										<i class="fa fa-sm fa-save mr-1"></i>
										Save Changes
									</button>
                  <button type = 'button' class='btn btn-success mr-2 float-right' id = 'add_question' data-toggle='modal' data-target='#addsurveyitem'>
										<i class="fa fa-sm fa-plus mr-1"></i>
										Add a Question
									</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modal declaration -->
  <!-- edit survey question -->
  <div class="modal fade" id="editsurveyitem" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
					<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
						<h5 class="modal-title text-white">
							<i class="fa fa-edit mx-2"></i>
							Edit Question
						</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
					<div class="form-group">
						<label for="editQuestion" class="col-form-label">Question</label>
						<input type="hidden" name = "question_id" id = "question_id">
						<input type="text" class="form-control" id='editQuestion' name ='editQuesion'>
					</div>
					<div class="row">
						<div class="form-group col-6">
							<label for="editquestiontype" class="col-form-label">Question Type</label>
							<select class="form-control" id = "editquestiontype" name="editquestiontype" >
								<option selected disabled>Select Question Type</option>
								<!--
								<option value = "Yn">Yes Or no</option>
								<option value = "YnDate">Yes Or no & Date</option>
								<option value = "YnQua">Yes Or no & Qua</option>
								<option value = "YnStr">Yes Or no & Str</option>
								<option value = "YnDateQua">Yes Or no & Date & Quantity</option>
								<option value = "YnDateStr">Yes Or no & Date & String</option>
								<option value = "YnQuaStr">Yes Or no & Quantity & String</option>
								<option value = "YnDateQuaStr">Yes Or no & Date & Quatity & String</option>
								<option value = "Date">Date</option>
								<option value = "DateQua">Date & Quantity</option>
								<option value = "DateStr">Date & String</option>
								<option value = "DateQuaStr">Date & Quantity & String</option>
								<option value = "Qua">Quantity</option>
								<option value = "QuaStr">Quantity & String</option>
								<option value = "Str">String</option>
								-->
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
						<div class="form-group col-6">
							<label for="editquestioncategory" class="col-form-label">Question Category</label>
							<select class="form-control" id = "editquestioncategory" name = 'editquestioncategory'>
								<option selected disabled>Select Question Category</option>
								<?php
								//include("../connections.php");

								$getcategories = mysqli_query($connections,"
									SELECT *
									FROM tblquestioncategory
									WHERE stfQuestionCategoryStatus = 'Active'
								");
								while($row = mysqli_fetch_assoc($getcategories)){
									$category = $row["stfQuestionCategory"];
								?>
									<option value = "<?php echo $category;?>"><?php echo $category;?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
						<i class="fa fa-sm fa-times mr-1"></i>
						Close
					</button>
          <button type="button" class="btn btn-success" id="btnsaveeditquestion">
						<i class="fa fa-sm fa-save mr-1"></i>
						Save
					</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end of edit survey question -->
  <!--Add question to survey modal-->
  <div class="modal fade-lg" id="addsurveyitem" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
				<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
						<h5 class="modal-title text-white" id="addQuestionTitle">
							<i class="fa fa-plus px-2"></i>
							Add Question
						</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
					<div class="form-group">
						<label class="col-form-label">Question</label>
						<input type="text" placeholder="Insert Question Here" id ="add_question_text" class="form-control">
					</div>
					<div class="row">
						<div class="form-group col-6">
							<label class="col-form-label">Question Type</label>
							<select class="form-control" id = "add_questiontype" name="add_questiontype">
								<option selected disabled>Select Question Type</option>
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
						<div class="form-group col-6">
							<label class="col-form-label">Question Category</label>
							<select class="form-control" id = "add_questioncategory" name = "add_questioncategory">
								<option selected disabled>Select Question Category</option>
								<?php
								//include("../connections.php");
									$getcategories = mysqli_query($connections,"
										SELECT *
										FROM tblquestioncategory
										WHERE stfQuestionCategoryStatus = 'Active'
									");
									while($row = mysqli_fetch_assoc($getcategories))	{
										$category = $row["stfQuestionCategory"];
								?>
									<option value = "<?php echo $category;?>"><?php echo $category;?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
        </div>
				<div class="modal-footer">
					<button class="btn btn-success" id ="add_submit_item">
						<i class="fa fa-plus mr-1"></i>
						Add
					</button>
				</div>
				<div class="modal-body">
					<div id = "add_survey_items">
						<table id = "add_table_questions" class="table table-bordered table-hover text-center">
							<thead>
								<tr class="bg-danger text-white">
									<td>Select</td>
									<td>Question</td>
									<td>Question Category</td>
									<td>Question Type</td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
        </div>
				<div class="modal-footer">				
					<button class="btn btn-outline-danger" type="button" class="add_delete-row">
						<i class="fa fa-trash mr-1"></i>
						Delete Row
					</button>
					<button class="btn btn-success" type="button" id = "add_save">
						<i class="fa fa-plus mr-1"></i>
						Add to Survey
					</button>
				</div>
      </div>
    </div>
  </div>
  <!-- end of modal -->

  <?php include "components/core-script.php"; ?>
  <script src="../public/js/jquery-ui.js"></script>
  <script src="../public/js/notification.js"></script>
  <script>
    // feather.replace();
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

    $(document).ready(function(){
    editsurvey();
    add_deleterow();
    addrow();
    saveeditedquestion();
    saveeditedsurvey();
    $("#tblsurvey tbody").sortable({
    connectWith: ".table tbody"
  }).disableSelection();
    var tr_number_add = 0;
    var deleted_rows = 0;
    $('#surveytab').addClass("active");
    function editsurvey(){
      $('#editsurveyitem').on('show.bs.modal', function(e) {
        $("#save_changes").show();
        var rowid = $(e.relatedTarget).data('id');
        //alert(rowid);
        var question = $('#question'+rowid).val();
        var type = $('#type'+rowid).val();
        var category = $('#category'+rowid).val();

        $('#question_id').val(rowid);
        $('#editQuestion').val(question);
        $('#editquestiontype').val(type);
        $('#editquestioncategory').val(category);
      });
    }
    function add_deleterow(){
      $(".add_delete-row").click(function(){
        $("#add_table_questions tbody").find('input[name="record"]').each(function(){
          if($(this).is(":checked")){
            $('#add_submit_item').attr("disabled", false);
            $(this).parents("tr").remove();
          }
        });
      });
    }
    //------------------------------------------------------------------------------------------------------------------------
    function addrow(){
      var rowid;

      $('#add_submit_item').click(function() {
        $(this).attr("disabled", true);
        var add_chosenType = $('#add_questiontype option:selected').val();
        var add_chosenCategory = $('#add_questioncategory option:selected').val();
        var add_question = $("#add_question_text").val();
        rowid = parseInt($('#tblsurvey tr:last').attr('id')) + 1;
        console.log(rowid);
        // var add_total_row = "<tr><td><input type='checkbox' name='record'></td><td>" + "<input type ='text' id = 'question_add"+rowid+"' "+"value = '"+ add_question +"'>" + "</td><td>" + "<input type ='text' id = 'category_add"+rowid+"' "+"value = '" + add_chosenCategory +"'>" + "</td><td>" + "<input type ='text' id = 'type_add"+rowid+"' "+"value = '" + add_chosenType + "'>" + "</td></tr>";
        var add_total_row = `<tr><td><input type='checkbox' name='record'></td><td><input type ='text' id = 'question_add${rowid}' value = "${add_question}"></td><td><input type ='text' id = 'category_add${rowid}'value = ' ${add_chosenCategory} '></td><td><input type ='text' id = 'type_add${rowid}' value = ' ${add_chosenType} '></td></tr>`;

        console.log(add_total_row);
        $("#add_table_questions tbody").append(add_total_row);
        $("#items input").val("");
      });

      //function addtoselectedsurvey(){

      $("#add_save").click(function(e){
        var rowCount = $('#add_table_questions tr').length;
        rowid = $('#tblsurvey tr:last').attr('id');
        var counter = parseInt(rowid) + (parseInt(rowCount) - 1);
        console.log(rowCount);
        console.log(rowid);
        console.log(counter);
        for(var i = parseInt(rowid) + 1; i <= counter; i++){
          var new_chosenType = $("#type_add"+i).val();
          var new_chosenCategory = $("#category_add"+i).val();
          var new_question = $("#question_add"+i).val();
          console.log(new_question+new_chosenType+new_chosenCategory);
          console.log(tr_number_add);

          // var add_total_row =  "<tr id ='"+i+"'><td><textarea class='form-control' value ='"+new_question+"' name='question"+i+"' id='question"+i+"' readonly>"+new_question+"</textarea></td>"+"<td><input type = 'text' value = '"+new_chosenType+"' name = 'type"+i+"' id='type"+i+"' readonly></td>"+"<td><input type = 'text' value = '"+new_chosenCategory+"' name = 'category"+i+"' id='category"+i+"' readonly></td>"+
          // "<td><button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editsurveyitem' data-id='"+i+"'>Edit</button> <button type='button' class='btn btn-danger' data-id='"+i+"'>Delete</button></td></tr>";
          var add_total_row =
          `<tr id ="${i}">
          <td><textarea class="que form-control" value ="${new_question}" name="question${i}" id="question${i}"  readonly>${new_question}</textarea></td>
          <td><input type = "text" value = "${new_chosenType}" name = "type${i}" id="type${i}" class="type"readonly></td>
          <td><input type = "text" value = "${new_chosenCategory}" name = "category${i}" id="category${i}" class="cat"readonly></td>
          <td><button type="button" class="btn ml-2 btn-sm" data-toggle="modal" data-target="#editsurveyitem" data-id="${i}">Edit</button> <button type="button" class="btn btn-danger" data-id="${i}">Delete</button></td>
          </tr>`;

          console.log(add_total_row);
          //$("#tblsurvey :last-child").append(add_total_row);
          $("#save_changes").show();
          $('#tblsurvey tr:last').after(add_total_row);
          $('#add_questiontype').val("Select Question Type");
          $('#add_questioncategory').val("Select Question Category");
          $("#add_question_text").val("");

          $("#add_table_questions tbody").find('input[name="record"]').each(function(){
            //  if($(this).is(":checked")){
            $('#add_submit_item').attr("disabled", false);
            $(this).parents("tr").remove();

            //    }
          });
        }

      });
      //}
    }
    //------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------



    function saveeditedquestion(){
      $("#btnsaveeditquestion").click(function(e){
        e.preventDefault(e);
        var confirm_input = confirm("Are you sure?");
        var id = $('#question_id').val();
        var question = $('#editQuestion').val();
        var type = $('#editquestiontype').val();
        var category = $('#editquestioncategory').val();
        if (confirm_input == true){
          $('#question'+id).val(question);
          $('#type'+id).val(type);
          $('#category'+id).val(category);
          alert("Changes appended");
        }
        else{
          alert("Confirmation Cancelled");
          return false;
        }
      });
    }

    // function saveeditedsurvey(){
    //   $("#save_changes").click(function(e){
    //     e.preventDefault;
    //     var formdata = $("form[name ='survey']").serialize();
    //     var selected = $('#hiddensurveyversion').val();
    //     var rowCount = $('#tblsurvey tr').length;
    //     var confirm_input = confirm("Are you sure?");
    //     rowCount = rowCount - 1;
    //     var allrows = rowCount+deleted_rows;
    //     console.log(formdata);
    //     console.log(allrows);
    //     if (confirm_input == true){
    //       $.ajax({
    //         url:"../controller/survey/editQuestion.php",
    //         type:"POST",
    //         data:{formdata:formdata,
    //           selected:selected,
    //           allrows:allrows},
    //           dataType: "json",
    //           success:function(data){
    //             //console.log(data);
    //             alert("Changes had been saved the survey is named :"+data.decQuestionVersion);
    //             // console.log(data.intQuestionVersion);
    //             window.location.href = "survey.php";
    //           },
    //           error: function(xhr, status, error) {
    //             var err = JSON.parse(xhr.responseText);
    //             alert(err.Message);
    //           }
    //         });
    //       }
    //       else{
    //         alert("Confirmation Cancelled");
    //         return false;
    //       }
    //     });
    //   }
    function saveeditedsurvey(){
      $("#save_changes").click(function(e){
        e.preventDefault;
        var formdata = $("form[name ='survey']").serialize();
        var selected = $('#hiddensurveyversion').val();
        var rowCount = $('#tblsurvey tr').length;
        var confirm_input = confirm("Are you sure?");
        rowCount = rowCount - 1;
        var allrows = rowCount+deleted_rows;

        var obj = [];
        $("#tblsurvey tbody").find("tr").each(function(){
          var que = $(this).find('.que').text();
          var type = $(this).find('.type').val().trim();
          var cat = $(this).find('.cat').val().trim();

          obj.push({
            que:que,
            type:type,
            cat:cat,
          });

        });
          console.log(obj);
          if (confirm_input == true){
           $.ajax({
             url:"../controller/survey/editQuestion.php",
             type:"POST",
             data:{obj:obj,
               selected:selected,
               allrows:allrows},
               dataType: "json",
               success:function(data){
                 //console.log(data);
                 alert("Changes had been saved the survey is named :"+data.decQuestionVersion);
                 // console.log(data.intQuestionVersion);
                 window.location.href = "survey.php";
               },
               error: function(xhr, status, error) {
                 // var err = JSON.parse(xhr.responseText);
                 // alert(err.Message);
                 console.log(xhr, status, error);
               }
             });
           }
           else{
             alert("Confirmation Cancelled");
             return false;
           }




        // var formdata = $("form[name ='survey']").serialize();
        // var selected = $('#hiddensurveyversion').val();
        // var rowCount = $('#tblsurvey tr').length;
        // var confirm_input = confirm("Are you sure?");
        // rowCount = rowCount - 1;
        // var allrows = rowCount+deleted_rows;
        // console.log(formdata);
        // console.log(allrows);
        // if (confirm_input == true){
        //   $.ajax({
        //     url:"../controller/survey/editQuestion.php",
        //     type:"POST",
        //     data:{formdata:formdata,
        //       selected:selected,
        //       allrows:allrows},
        //       dataType: "json",
        //       success:function(data){
        //         //console.log(data);
        //         alert("Changes had been saved the survey is named :"+data.decQuestionVersion);
        //         // console.log(data.intQuestionVersion);
        //         window.location.href = "survey.php";
        //       },
        //       error: function(xhr, status, error) {
        //         var err = JSON.parse(xhr.responseText);
        //         alert(err.Message);
        //       }
        //     });
        //   }
        //   else{
        //     alert("Confirmation Cancelled");
        //     return false;
        //   }
        });
      }

      $('#tblsurvey tbody').on('click','.deleteQuestion',function(){
        var confirm_delete = confirm("Are you sure you want to delete?");

        if(confirm_delete == true){
          $("#save_changes").show();
          $(this).closest('tr').remove();
          deleted_rows = deleted_rows + 1;
          console.log(deleted_rows);
        }
        else{
          alert("Confirmation Cancelled");
          return false;
        }
      });

      $('#setasactive').click(function(){
        var survey = $("#hiddensurveyversion").val();
        var confirm_changes = confirm("Are you sure you want to change the survey to "+survey+"?");
        console.log("hi");
        if(confirm_changes == true){
          $.ajax({
            url:"../controller/survey/changeActiveSurvey.php",
            type:"POST",
            data:{survey:survey},
            success:function(data){
              console.log(data);
              alert("The survey in use is "+data);
              window.location.href = "survey.php";
            }

          });
        }else{
          alert("Confirmation Cancelled");
          return false;
        }

      });



      // $("#tblsurvey tbody").sortable();
//       $(function () {
//       $('#tblsurvey').sortable({
//           tolerance: 'touch',
//           drop: function () {
//               alert('delete!');
//           }
//       });
// });


    });
  </script>
</body>
</html>
