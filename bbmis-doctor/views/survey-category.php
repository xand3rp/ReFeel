<?php include "../controller/fetchEmpAcc.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Survey Categories</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
  <link rel="stylesheet" href="../public/css/datatables.min.css">
  <link rel="stylesheet" href="../public/css/bs-override.css">
</head>
<body>
  <?php include "components/loader.php"; ?>
  <div class="wrapper">
    <?php include "components/sidebar.php"; ?>
    <main class="mainpanel">
      <?php include "components/header.php"; ?>
      <div class="page-title">
        <h3 class="p-2">Survey Category</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Active Categories</h4>
                <table id="tblActiveSurveyCategory" class="table table-hover table-bordered text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 50%">Category</td>
                      <td style="width: 50%">Action</td>
                    </tr>
                  </thead>
                </table>
                <button type='button' class='btn btn-outline-danger float-right my-2 mx-3' data-toggle='modal' data-target='#addSurveyCategoryModal'>
									<i class="fa fa-plus mr-1"></i>
									Add Survey Category
								</button>
              </div>
            </div>
            <div class="col-md-12 col-lg-12 p-0 mt-2">
              <div class="content-container" style="padding-bottom: 4rem;">
                <h4 class="py-2">Inactive Categories</h4>
                <table id="tblInactiveSurveyCategory" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr class="bg-danger text-white">
                      <td style="width: 50%">Category</td>
                      <td style="width: 50%">Action</td>
                    </tr>
                  </thead>
                </table>
								<button type='button' class='btn btn-outline-danger float-right my-2 mx-3' data-toggle='modal' data-target='#addSurveyCategoryModal'>
									<i class="fa fa-plus mr-1"></i>
									Add Survey Category
								</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- modal declaration -->
  <!-- add survey category modal -->
  <div class="modal fade" id="addSurveyCategoryModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
					<div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
						<h5 class="modal-title text-white" id="addnewsurveycategoryTitle">
							<i class="fa fa-user-plus px-2 fa-sm"></i>
							Add Survey Category
						</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="addnewsurveycategory.php" name="form_addnewsurveycategory">
          <div class="modal-body">
            <div class="form-group">
              <label for="newSurveyCategoryName">Survey Category</label>
              <input type="text" class="form-control" id='newSurveyCategoryName' name ='newSurveyCategoryName' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times mr-1"></i>
							Close
						</button>
						<button type="reset" class="btn btn-outline-danger">
							<i class="fa fa-eraser mr-1"></i>
							Clear
						</button>
            <button type="submit" class="btn btn-success" id="btnsavenewsurveycategory">
							<i class="fa fa-plus mr-1"></i>
							Add
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- edit survey category modal -->
  <div class="modal fade" id="editSurveyCategoryModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="editnewsurveycategoryTitle">
						<i class="fa fa-edit px-2"></i>
						Edit Survey Category
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="editsurveycategory.php" name="form_editsurveycategory">
          <div class="modal-body">
            <div class="form-group">
              <label for="editSurveyCategoryName">Survey Category</label>
              <input type="hidden" name = "surveycategory_ID" id = "surveycategory_ID">
              <input type="text" class="form-control" id='editSurveyCategoryName' name ='editSurveyCategoryName' required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times mr-1"></i>
							Close
						</button>
            <button type="submit" class="btn btn-success" id="btnsaveeditsurveycategory">
							<i class="fa fa-save mr-1"></i>
							Save
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--View Details-->
  <div class="modal fade" id="viewSurveyCategoryModal" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="viewnewsurveycategoryTitle">
						<i class="fa fa-toggle-off px-2"></i>
						Survey Category
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="deletecategory.php" name="form_viewsurveycategory">
          <div class="modal-body">
            <div class="form-group">
              <label for="viewSurveyCategoryName">Survey Category</label>
              <input type="hidden" name = "viewsurveycategory_ID" id = "viewsurveycategory_ID">
              <input type="text" class="form-control" id='viewSurveyCategoryName' name ='viewSurveyCategoryName' readonly>
            </div>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times mr-1"></i>
							Close
						</button>
            <button type="submit" class="btn btn-danger" id="btnsavedeletesurveycategory">
							<i class="fa fa-toggle-off mr-1"></i>
							Disable
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- enable category -->
  <div class="modal fade" id="viewSurveyCategoryModal_enable" tabindex="-1" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 30px 30px 25px 25px;">
        <div class="modal-header bg-danger" style="border-radius: 25px 25px 0px 0px;">
          <h5 class="modal-title text-white" id="viewnewsurveycategoryTitle_enable">
						<i class="fa fa-toggle-on px-2"></i>
						Survey Category
					</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="text-white" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action ="enablecategory.php" name="form_viewsurveycategory_enable">
          <div class="modal-body">
            <div class="form-group">
              <label for="viewSurveyCategoryName">Survey Category</label>
              <input type="hidden" name = "viewsurveycategory_ID_enable" id = "viewsurveycategory_ID_enable">
              <input type="text" class="form-control" id='viewSurveyCategoryName_enable' name ='viewSurveyCategoryName_enable' readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
							<i class="fa fa-times mr-1"></i>
							Close
						</button>
            <button type="submit" class="btn btn-success" id="btnsaveenablesurveycategory">
							<i class="fa fa-toggle-on mr-1"></i>
							Enable
						</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include "components/core-script.php"; ?>
  <script src="../public/js/datatables.min.js"></script>
  <script src="../public/js/sweetalert.min.js"></script>
  <script src="../public/js/notification.js"></script>
  <script>
    $('#maintenance').addClass('active');
    $('#survey-category').addClass('active');
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

    //show active survey category
    let activeSurveyCategory = 'activeSurveyCategory';
    $('#tblActiveSurveyCategory').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 1
			}],
      'ajax': {
        url: '../controller/survey/datatables.php',
        type: 'POST',
        data: { type: activeSurveyCategory }
      },
      'language': {
        'emptyTable': 'No active category to show.'
      }
    });
    
    //show active survey category
    let inactiveSurveyCategory = 'inactiveSurveyCategory';
    $('#tblInactiveSurveyCategory').DataTable({
      'processing': true,
      'serverSide': true,
			'columnDefs': [{
				'orderable': false,
				'targets': 1
			}],
      'ajax': {
        url: '../controller/survey/datatables.php',
        type: 'POST',
        data: { type: inactiveSurveyCategory }
      },
      'language': {
        'emptyTable': 'No inactive category to show.'
      }
    });

    // $(document).ajaxStart(function() {
    //   $('.loader').show();
    // });

    // $(document).ajaxComplete(function() {
    //   $('.loader').hide();
    // });

    $(document).on("submit", "form[name='form_addnewsurveycategory']", function(e){
      e.preventDefault();
      var confirm_input = confirm("Are you sure?");
      var formdata = $("form[name='form_addnewsurveycategory']").serialize();

      if (confirm_input == true){
        $.ajax({
          type: "POST",
          url: '../controller/survey/addNewSurveyCategory.php',
          data: {formdata,formdata},
          success:function(data){
            if(data == 1){
              alert("Category Added");
              $('#addSurveyCategorytModal').modal('hide');
              $("#addSurveyCategory .modal-body input").val("");
              window.location.href = "survey-category.php";
              //$('#divdonoraddsero').show(600);
            }
            else if(data == 2){
              alert("The Survey Category You Entered Already Exists, Please check the disabled survey categories too.");
              window.location.href = "survey-category.php";
            }
            else if (data == 3) {
              alert("Survey Category is not saved");
              window.location.href = "survey-category.php";
            }
          }
        });
      }
      else{
        alert("Confirmation Cancelled");
        return false;
      }
    });

    $(document).on("show.bs.modal", "#editSurveyCategoryModal", function(e){
      var rowid = $(e.relatedTarget).data('id');
      //alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/survey/fetchSurveyCategory.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#surveycategory_ID').val(data.intQuestionCategoryId);
          $('#editSurveyCategoryName').val(data.stfQuestionCategory);
        }
      });
    });

    $(document).on("show.bs.modal", "#viewSurveyCategoryModal", function(e){
      var rowid = $(e.relatedTarget).data('id');
      //alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/survey/fetchSurveyCategory.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#viewsurveycategory_ID').val(data.intQuestionCategoryId);
          $('#viewSurveyCategoryName').val(data.stfQuestionCategory);
        }
      });
    });

    $(document).on("show.bs.modal","#viewSurveyCategoryModal_enable", function(e){
      var rowid = $(e.relatedTarget).data('id');
      //alert(rowid);
      $.ajax({
        type: "POST",
        url: '../controller/survey/fetchSurveyCategory.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#viewsurveycategory_ID_enable').val(data.intQuestionCategoryId);
          $('#viewSurveyCategoryName_enable').val(data.stfQuestionCategory);
        }
      });
    });

    $(document).on("submit", "form[name='form_editsurveycategory']", function(e){
      e.preventDefault();
      var confirm_input = confirm("Are you sure?");
      var formdata = $("form[name='form_editsurveycategory']").serialize();

      if (confirm_input == true){
        $.ajax({
          type: "POST",
          url: '../controller/survey/editSurveyCategory.php',
          data: {formdata,formdata},
          success:function(data){
            if(data == 1){
              alert("Survey Category Succesfully Edited");
              $('#editSurveyCategoryModal').modal('hide');
              $("#editSurveyCategoryModal .modal-body input").val("");
              window.location.href = "survey-category.php";
              //$('#divdonoraddsero').show(600);
            }
            else if(data == 2){
              alert("The Survey Category You Entered Already Exists");
              window.location.href = "survey-category.php";
            }
            else if (data == 3) {
              alert("Survey Category is not Edited");
              window.location.href = "survey-category.php";
            }
          }
        });
      }
      else{
        alert("Confirmation Cancelled");
        return false;
      }
    });

    $(document).on("click","#btnsavedeletesurveycategory", function(e){
      e.preventDefault();
      var id = $("#viewsurveycategory_ID").val();
      swal({
        title: "Are you sure?",
        text: "You are about to disable this category",
        icon: "info",
        buttons: true,
      })
      //var confirm_delete = confirm("Are you sure?");
      //if(confirm_delete == true){
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: '../controller/survey/disableCategory.php',
            data: {id:id},
            success:function(data){
              /*  alert("Category has been disabled");
              window.location.href = "category-tab.php";*/
              if(data == "deleted"){
                swal({
                  title: "",
                  text: "The category is now disabled",
                  icon: "success",
                  buttons: {text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href = "survey-category.php";
                  }
                });
              }else{
                swal({
                  title: "",
                  text: "The category is not disabled because "+data+" record/s uses this.",
                  icon: "error",
                  buttons: {text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href = "survey-category.php";
                  }
                });
              }
            }
          });
          /*}
          else{
          alert("Confirmation Cancelled");
          return false;
        }*/
      }
      else {
        swal("","Cancelled","info");
      }
    });
  });

    $(document).on("click", "#btnsaveenablesurveycategory", function(e){
      e.preventDefault();
      var id = $("#viewsurveycategory_ID_enable").val();
      var confirm_enable = confirm("Are you sure?");
      if(confirm_enable == true){
        $.ajax({
          type: "POST",
          url: '../controller/survey/enableCategory.php',
          data: {id:id},
          success:function(data){
            alert("Category has been enabled");
            window.location.href = "survey-category.php";
          }
        });
      }
      else{
        alert("Confirmation Cancelled");
        return false;
      }
    });
  </script>
</body>
</html>