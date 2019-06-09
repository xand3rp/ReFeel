<?php 
include "../controller/fetchEmpAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ReFeel - Reports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../public/img/blood.ico">
  <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/all.css">
</head>
<body>
  <?php 
  include "components/loader.php";
  ?>
  <div class="wrapper">
    <?php 
    include "components/sidebar.php";
    ?>
    <main class="mainpanel">
      <?php 
      include "components/header.php";
      $datenow = date('Y-m-d');
      ?>
      <div class="page-title">
        <h3>Reports</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-lg-12 p-0">
              <div class="content-container">
                <div class="row">
                  <div class="form-group col-md-12">
                    <h5 class="nunito">Select timeline</h5>
                    <form id = "daterange" name = "daterange">
                      <label>From:</label>
                      <input type = "date" name="from_range" id = "from_range" class = "form-control-inline" value="<?php echo $datenow ?>">
                      <label class="ml-3">To:</label>
                      <input type="date" name="to_range" id="to_range" class="form-control-inline" value="<?php echo $datenow ?>">
                      <button type="submit" class ="btn form-control-inline">Go</button>
                      <button type="button" class="btn btn-outline-danger float-right clearfix mb-5" id="btn_genpdf" ><i class="fas fa-print"></i> Print Reports</button>
                    </form>
                  </div>
                  <div id="rep" class="col-md-12 col-lg-12 p-0">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <script src="../public/rep/jquery-3.3.1.min.js"></script>
  <script src="../public/rep/popper.min.js"></script>
  <script src="../public/rep/bootstrap.min.js"></script>
  <script src="../public/js/notification.js"></script>
  <script>
    $('#reports').addClass('active');
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

    var formdata = $("form[name='daterange']").serialize();
    console.log(formdata);
    $.ajax({
      url: "../controller/reports/fetchReports.php",
      type: "POST",
      data:{formdata:formdata},
      success:function(data){
        // console.log(data);
        $("#rep").html(data);
        // document.getElementById('reports').innerHTML = data;
      }
    });

    $(document).on("submit","form[name='daterange']",function(e){
      e.preventDefault();
      var formdata = $("form[name='daterange']").serialize();
      $.ajax({
        url: "../controller/reports/fetchReports.php",
        type: "POST",
        data:{formdata:formdata},
        success:function(data){
          // console.log(data);
          // document.getElementById('reports').innerHTML = data;
          $("#rep").html(data);
        }
      });
    });

    $(document).on("click","#btn_genpdf",function(e){
      var from_range = $("#from_range").val();
      var to_range = $("#to_range").val();
      window.location.href = "genReportsPdf.php?from_range=" + from_range + "&to_range=" + to_range;
    });
  </script>
</body>
</html>