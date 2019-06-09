<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="../../public/assets/blood.ico">
  <link rel="stylesheet" href="../../public/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/login.css">
  <link rel="stylesheet" href="../../public/css/all.css">
  <link rel="stylesheet" href="../../public/css/bs-override.css">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to ReFeel!</title>
</head>
<body>
  <div class=" d-md-block d-lg-block mx-auto contents">
    <div class="logo-container text-center" style="padding-top: 1em;">
      <img src="../../public/assets/refeel-logo-refined.png" class="img-fluid" style="width: 60%">
    </div>
    <div class="form-container">
      <div class="login-form container-fluid text-center pb-5">
        <form name="employeeLogin">
          <div class="input-group" style="padding-left: 5%; padding-right: 5%;">
            <div class="input-group-prepend text-center">
              <div class="input-group-text" style="background-color: #DC4640;">
                <i class="fas fa-user" style="color: white"></i>
              </div>
            </div>
            <input type="text" class="form-control" name="txtUn" style="border-radius: 0;" placeholder="Username">
          </div>
          <div class="input-group mt-2" style="padding-left: 5%; padding-right: 5%;">
            <div class="input-group-prepend text-center">
              <div class="input-group-text" style="background-color: #DC4640;">
                <i class="fas fa-lock" style="color: white"></i>
              </div>
            </div>
            <input type="password" class="form-control" name="txtPw" style="border-radius: 0;" placeholder="Password">
          </div>
          <button type="submit" class="col-md-11 col-lg-11 submit">Login</button>
        </form>
      </div>
    </div>
  </div>
  <?php include "components/core-script.php"; ?>
	<script src="../../public/js/sweetalert2.all.min.js"></script>
  <!-- <script src="../../public/swal/sweetalert.min.js"></script> -->
  <script>
    $(document).on('submit', 'form[name="employeeLogin"]', function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      console.log(formdata);

      $.ajax({
        url: "../controller/employeeLogin.php",
        type: "POST",
        data: {formdata:formdata},
        success: function (data){
          if (data == 1){
            let timeInterval;
            swal({
              title: '',
              html: 'Login success!',
              timer: 1500,
              onOpen: () => {
                swal.showLoading();
                timerInterval = setInterval(() => {
                  swal.getContent().querySelector('strong')
                  .textContent = swal.getTimerLeft()
                }, 100);
                window.location.href = "graphs.php";
              },
              onClose: () => {
                clearInterval(timerInterval)
              }
            })
            .then((result) => {
              if (
                result.dismiss === swal.DismissReason.timer
              ) {
                console.log('I was closed by the timer')
              }
            });
          }
          else if (data == 2){
            swal({
              type: 'error',
              title: 'Oops...',
              text: 'Staffs and doctors are only allowed to access the doctor side page.'
            });
          }
          else if (data == 3){
            swal({
              type: 'error',
              title: 'Oops...',
              text: 'Password is incorrect.'
            });
          }
          else if (data == 4){
            swal({
              type: 'error',
              title: 'Oops...',
              text: 'Account does not exist, please register first.'
            });
          }
        }
      });
    });
    // $('#employeeLogin').submit(function(e){
    //   e.preventDefault();
    //   var formdata = $(this).serialize();

    //   $.ajax({
    //     url: "../controller/employeeLogin.php",
    //     type: "POST",
    //     data: {formdata:formdata},
    //     success: function (data){
    //       if (data == 1){
    //         let timeInterval;
    //         swal({
    //           title: '',
    //           html: 'Login success!',
    //           timer: 1500,
    //           onOpen: () => {
    //             swal.showLoading();
    //             timerInterval = setInterval(() => {
    //               swal.getContent().querySelector('strong')
    //               .textContent = swal.getTimerLeft()
    //             }, 100);
    //             window.location.href = "graphs.php";
    //           },
    //           onClose: () => {
    //             clearInterval(timerInterval)
    //           }
    //         })
    //         .then((result) => {
    //           if (
    //             result.dismiss === swal.DismissReason.timer
    //           ) {
    //             console.log('I was closed by the timer')
    //           }
    //         });
    //       }
    //       else if (data == 2){
    //         swal({
    //           type: 'error',
    //           title: 'Oops...',
    //           text: 'Staffs and doctors are only allowed to access the doctor side page.'
    //         });
    //       }
    //       else if (data == 3){
    //         swal({
    //           type: 'error',
    //           title: 'Oops...',
    //           text: 'Password is incorrect.'
    //         });
    //       }
    //       else if (data == 4){
    //         swal({
    //           type: 'error',
    //           title: 'Oops...',
    //           text: 'Account does not exist, please register first.'
    //         });
    //       }
    //     }
    //   });
    // });
  </script>
	</body>
</html>