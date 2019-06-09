<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" href="../public/assets/blood.ico">
		<link rel="stylesheet" href="../public/bootstrap/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="../public/css/bs-override.css" type="text/css">
		<link rel="stylesheet" href="../public/fa/css/all.min.css" type="text/css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ReFeel - Interview Sheet</title>
		<script src="../public/swal/sweetalert.min.js" type="text/javascript"></script>
		<script src="../public/jquery/jquery-3.3.1.min.js" type="text/javascript"></script>
		<script src="../public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	</head>
	<?php
		include "checkSession.php";
		include "fetchClientAcc.php";
	?>
	<body>
		<!-- Navigation bar -->
		<?php
			include "clientNavBar.php";
		?>
		<h4 id="headTitle" class="display-4 text-center my-sm-4">Interview Sheet</h4>
		<p class="text-center h5 mb-4">
			Status: 
			<span id="spnStatus"></span>
		</p>
		<div class="container mb-4">
			<form id="frmIntSheet" method="POST">
				<?php
					include "fetchIntSheetQuestions.php";
					include "fetchIntSheetPrompts.php";
				?>
			</form>
			<!--button type='submit' id='btnEmpty'>Truncate Records</button-->
		</div>
	</body>
	<script>
		$(document).ready(function()	{
			var intsheetanswers = $(this).serialize();
			// console.log(intsheetanswers);
			$.ajax	({
				url: "fetchIntSheetAnswers.php",
				data: {intsheetanswers: intsheetanswers},
				success: function(data)	{
					if(data != '')	{
						//console.log(data);
						var varObj = jQuery.parseJSON(data);
						console.log(varObj);
						var varObjLng = varObj.length;
						
						console.log(varObj);
						
						for(x=0; x<varObjLng; x++)	{							
							$("input[type='radio'][name='txtYn" + varObj[x].id + "'][value='" + varObj[x].yn + "']").prop('checked', true);
							$("#btnYn" + varObj[x].id + "[value='" + varObj[x].yn + "']").addClass("active");
							
							$("input[type='number'][name='intQua" + varObj[x].id + "']").val(varObj[x].qua);
							
							$("input[type='text'][name='txtStr" + varObj[x].id + "']").val(varObj[x].str);
							
							$("select[name='optDm" + varObj[x].id + "'] option[value='" + varObj[x].dm + "']").prop('selected', true);
							
							$("select[name='optDd" + varObj[x].id + "'] option[value='" + varObj[x].dd + "']").prop('selected', true);
							
							$("select[name='optDy" + varObj[x].id + "'] option[value='" + varObj[x].dy + "']").prop('selected', true);
						}
					}
				}
			});
		});
		
		$("#btnPassed").click(function()	{
			window.location.href = 'genIntSheetAnsPdf.php'
		});

		$("#btnSbmAns").click(function(e)	{
			$("#frmIntSheet").submit(function(e)	{
				e.preventDefault();
				var formdata = $(this).serialize();
				console.log(formdata);
				
				swal({
					title: 'Warning!',
					text: 'The answers you submitted are crucial. Are you sure you want to proceed?',
					icon: 'warning',
					dangerMode: true,
					buttons: ['No', 'Yes'],
				}).then((willRequest) => {
					if(willRequest)	{
						$.ajax	({
							url: "getIntSheetAnswers.php",
							type: "POST",
							data: {formdata:formdata},
							success: function(data)	{
								console.log(data);
								if(data == '1')	{
									swal({
										title: 'Done!',
										text: 'You submitted your medical exam answers. Please wait for the exam results within three(3) days.',
										icon: 'success'
									}).then(() => {
										window.location.href = 'clientIntSheet.php'
									});
								}
							}
						});
					}
				});
			});
		});
		
		$("#btnPlsWait").click(function(e)	{
			swal('Please wait.', 'Your current medical exam is not yet checked. You will be notified in three(3) days. If exceeds, the exam will be expired and try to donate again.', 'info');
		});
		
		$("#btnEmpty").click(function(e)	{
			e.preventDefault();
			var formdata = $(this).serialize();
			// console.log(formdata);
			$.ajax	({
				url:"etc/truncate.php",
				type:"POST",
				data:{formdata:formdata},
				success:function(data)	{
					// console.log(data);
					if(data == '3')	{
						window.location.href = 'clientIntSheet.php'
					}
				}
			});
		});
	</script>
</html>