<?php
  include "../controller/fetchEmpAcc.php";
  $varQueCount = 1;
  $varDbId = $_GET["client_id"];
  //$varDbId = 1;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ReFeel - Survey Answers</title>
	<link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
  <link rel="stylesheet" href="../public/css/bs-override.css">
</head>
<body>
  <?php
  include "components/loader.php";
  ?>
  <div class="wrapper">
    <main class="mainpanel" style="width: 100%">
      <?php
      include "components/special-header.php";
      ?>
      <div class="page-title">
        <div class="d-flex justify-content-between">
						<div>
							<h3 class="p-2 align-middle">Survey Answers</h3>
						</div>
						<div class="p-2">
							<button type="button" onclick="location.href='donor-records.php'" class="btn btn-outline-danger">
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
              <div class="content-container">
                <form id='idIntSheet'>
                  <div class="form-group">
										<div class="row pt-2 pb-1 pl-4">
											<h5 class="mr-4">Date Answered</h5>
											<input type="date" name="date_med" required="required">
											<!--
											<input type="time" name="date_med" required="required">
											-->
										</div>
                  </div>
                  <input type="hidden" name="hidden_id" value="<?php echo $varDbId;?>">
                  <?php
                    $qryDistQueCtg = mysqli_query($connections, "
											SELECT DISTINCT(qc.stfQuestionCategory)
											FROM tblquestion q
											JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
                    ");

                    $qryCountQueCtg = mysqli_num_rows($qryDistQueCtg);

                    $qryCliSex = mysqli_query($connections, "
											SELECT stfClientSex
											FROM tblclient
											WHERE intClientId = $varDbId
										");
                    $rowCliSex = mysqli_fetch_assoc($qryCliSex);
                    $varSex = $rowCliSex["stfClientSex"];

                    function typeYn($varQueId)	{
                      echo "
                          <div class='row'>
                            <div class='btn-group-toggle text-center w-100' data-toggle='buttons'>
                              <label id='btnYn$varQueId' class='btn btn-outline-danger form-control col-4 mr-sm-2' value='Yes'>
                                <input type='radio' name='txtYn$varQueId' value='Yes' autocomplete='off' required='required' />Oo
                              </label>
                              <label id='btnYn$varQueId' class='btn btn-outline-danger form-control col-4' value='No'>
                                <input type='radio' name='txtYn$varQueId' value='No' autocomplete='off' required='required' />Hindi
                              </label>
                            </div>
                          </div>
                      ";
                    }

                    function typeDate($varQueId)	{
                      echo "
                          <div class='row mt-3'>
                            <div class='form-group col-4'>
                              <select class='form-control' name='optDm$varQueId' placeholder='Month'>
                              <option value='00'>Month</option>';
                              ";

                                  for($m=1; $m<=12; $m++) {
                                    $month = date("F", mktime(0,0,0,$m, 1, date("Y")));
                                    echo "<option value='$m'>$month</option>'";
                                  }

                      echo "
                              </select>
                            </div>
                            <div class='form-group col-4'>
                              <select class='form-control' name='optDd$varQueId'>
                                <option value='00'>Day</option>
                                ";
                              for($d=1; $d<=31; $d++)	{
                                echo "
                                  <option value='$d'>$d</option>
                                ";
                              }

                      echo "
                              </select>
                            </div>
                            <div class='form-group col-4'>
                              <select class='form-control' name='optDy$varQueId'>
                              <option value='0000'>Year</option>;
                              ";
                                  $curYear = date("Y");
                                  for($y=0; $y<=($curYear-($curYear-60)); $y++)	{
                                    $z = $curYear-$y;
                                    echo "<option value='$z'>$z</option>";
                                  }
                      echo "
                              </select>
                            </div>
                          </div>
                      ";
                    }

                    function typeQua($varQueId)	{
                      echo "
                          <div class='row'>
                            <div class='form-group m-auto mb-sm-3'>
                              <input type='number' min='0' class='form-control' name='intQua$varQueId' value=0 />
                            </div>
                          </div>
                      ";
                    }

                    function typeStr($varQueId)	{
                      echo "
                          <div class='row'>
                            <div class='form-group m-auto'>
                              <input type='text' class='form-control' name='txtStr$varQueId'/>
                            </div>
                          </div>
                      ";
                    }

                    function btnRems($varQueId)	{
                      echo "
                        <div class='btn-group-toggle' data-toggle='buttons'>
                          <label id='btnYn$varQueId' class='btn btn-outline-success form-control col-12 mb-sm-2' value='Yes'>
                            <input type='radio' name='updatestatus$varQueId' value='Correct' autocomplete='off' required='required' />
                              Acceptable
                          </label>
                          <label id='btnYn$varQueId' class='btn btn-outline-danger form-control col-12' value='No'>
                            <input type='radio' name='updatestatus$varQueId' value='Wrong' autocomplete='off' required='required' />
                              Unacceptable
                          </label>
                        </div>
                      ";
                    }

                    for($x=0; $x<$qryCountQueCtg; $x++)	{
                      $qryQueCtg = mysqli_query($connections, "
                        SELECT DISTINCT(qc.stfQuestionCategory), qc.intQuestionCategoryId
                        FROM tblquestion q
                        JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
                        WHERE decQuestionVersion = (
                            SELECT DISTINCT(q1.decQuestionVersion)
                            FROM tblquestion q1
                            WHERE boolVersionInUse = '1'
                          )
                        LIMIT 1 OFFSET $x
                      ");

                      while($rowCtg = mysqli_fetch_assoc($qryQueCtg))	{
                        $varQueCtg = $rowCtg["stfQuestionCategory"];
                        $varQueCtgId = $rowCtg["intQuestionCategoryId"];

                        if($varSex == 'Male')	{
                          if($varQueCtgId == 3)	{
                            //break;
                            continue;
                          }
                        }

                        echo "
                          <table class='table table-bordered table-hover'>
                            <tr>
                              <td class='text-white text-center' colspan='4' style='background-color: #FF7575'>
                                $varQueCtg
                              </td>
                            </tr>
                        ";

                        $qryQue = mysqli_query($connections, "
                          SELECT q.intQuestionId, q.txtQuestion, q.stfQuestionType
                          FROM tblquestion q
                          JOIN tblquestioncategory qc ON q.intQuestionCategoryId = qc.intQuestionCategoryId
                          WHERE qc.stfQuestionCategory = '$varQueCtg'
                          AND decQuestionVersion = (
                            SELECT DISTINCT(q1.decQuestionVersion)
                            FROM tblquestion q1
                            WHERE boolVersionInUse = '1'
                          )
                        ");

                        while($rowQue = mysqli_fetch_assoc($qryQue))	{
                          $varQueId = $rowQue["intQuestionId"];
                          $varQue = $rowQue["txtQuestion"];
                          $varQueType = $rowQue["stfQuestionType"];

                          echo "
                            <tr>
                              <td class='align-middle text-center' style='width: 10%;'>
                                $varQueCount.
                              </td>
                              <td class='align-middle' style='width: 40%;'>
                                $varQue
                              </td>
                              <td class='align-middle' style='width: 50%;'>
                          ";

                          $varQueCount++;

                          if($varQueType == "Yn")	{typeYn($varQueId);}
                          else if($varQueType == "YnDate")	{typeYn($varQueId); typeDate($varQueId); }
                          else if($varQueType == "YnQua")	{typeYn($varQueId); typeQua($varQueId); }
                          else if($varQueType == "YnStr")	{typeYn($varQueId); typeStr($varQueId); }
                          else if($varQueType == "YnDateQua")	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); }
                          else if($varQueType == "YnDateStr")	{typeYn($varQueId); typeDate($varQueId); typeStr($varQueId); }
                          else if($varQueType == "YnQuaStr")	{typeYn($varQueId); typeQua($varQueId); typeStr($varQueId); }
                          else if($varQueType == "YnDateQuaStr")	{typeYn($varQueId); typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); }
                          else if($varQueType == "Date")	{typeDate($varQueId); }
                          else if($varQueType == "DateQua")	{typeDate($varQueId); typeQua($varQueId); }
                          else if($varQueType == "DateStr")	{typeDate($varQueId); typeStr($varQueId); }
                          else if($varQueType == "DateQuaStr")	{typeDate($varQueId); typeQua($varQueId); typeStr($varQueId); }
                          else if($varQueType == "Qua")	{typeQua($varQueId); }
                          else if($varQueType == "QuaStr")	{typeQua($varQueId); typeStr($varQueId); }
                          else if($varQueType == "Str")	{typeStr($varQueId); }
                          echo "
                              </td>
                              <td class='align-middle text-center' style='width: 10%;'>
                        ";

                        btnRems($varQueId);

                        echo "
                              </td>
                            </tr>
                          ";
                        }
                        echo "
                          </table>
                        ";
                      }
                    }
                  ?>
                  <button input="submit" class="form-control btn btn-danger my-2">Submit Answers</button>
                </form>
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
      $("#idIntSheet").submit(function(e){
        e.preventDefault();//para di siya lumipat ng link
        var formdata = $(this).serialize();//kukunin ko yung lahat ng laman ng form
        var confirm_inputs = confirm("Are you sure?");
        console.log(formdata);//tinitingnan ko sa console yung laman
        if(confirm_inputs == true){
          $.ajax({
            url: "../controller/survey/getIntSheetAnswers.php",
            method: "POST",
            data: {formdata,formdata},
            success: function(data)	{
              console.log(data);
              if(data == "2"){
                alert("Date Answered must not be greater than the date today!");
              }else{
              console.log(data);
              window.location.href = 'donor-records.php';
            }
          }
        });
      }  else{
        alert("Confirmation Cancelled");
        return false;
      }
    });
	});
  </script>
	</body>
</html>