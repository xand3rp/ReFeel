<?php
	include("../connections.php");
	
	// fetch numbers that will be used to compare to dates
	/*$fetch_bloodstatus = mysqli_query($connections, " SELECT * FROM tblpreservatives WHERE intPreservativeId = 1 ");
	while($row = mysqli_fetch_assoc($fetch_bloodstatus)){
		$bloodbaglifespan = $row["intPreservativeLifespan"];
		$freshbloodbag = $row["intPreservativeFreshPercentage"];
		$mediumbloodbag = $row["intPreservativeNeutralPercentage"];
		$criticalbloodbag = $row["intPreservativeCriticalPercentage"];
	}
	settype($bloodbaglifespan, "int");
	settype($freshbloodbag, "int");
	settype($mediumbloodbag, "int");
	settype($criticalbloodbag, "int");

	$fresh_percentage = $freshbloodbag / 100;
	$medium_percentage = $mediumbloodbag / 100;
	$critical_percentage = $criticalbloodbag / 100;

	$fresh_lifespan = $bloodbaglifespan * $fresh_percentage;
	settype($fresh_lifespan, "int");
	$medium_lifespan = $bloodbaglifespan * $medium_percentage;
	settype($medium_lifespan, "int");
	$critical_lifespan = $bloodbaglifespan * $critical_percentage;
	settype($critical_lifespan, "int");*/

	$fetch_expiredbloodbags = mysqli_query($connections, "
		SELECT *
		FROM tblbloodbag tbb
		JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
		JOIN tblstorage ts ON tbb.intStorageId = ts.intStorageId
		JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId
		JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
		JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
		WHERE stfIsBloodBagExpired = 'Yes'
		AND stfIsBloodBagDiscarded = 'No'
		AND DATEDIFF(NOW(), dtmDateStored) > tp.intPreservativeLifespan
	");

	if(mysqli_num_rows($fetch_expiredbloodbags) > 0 ){
		$output = "
			<table class='table table-bordered table-hover text-center'>
				<tr class='bg-danger text-white'>
					<td>Serial Number</td>
					<td>Action</td>
				</tr>
		";
		while($row = mysqli_fetch_assoc($fetch_expiredbloodbags))	{
			$serialno = $row["strBloodBagSerialNo"];
			$fetch_expiredbb = mysqli_query($connections, "
				SELECT *
				FROM tblbloodbag tbb
				JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId
				JOIN tblstorage ts ON tbb.intStorageId = ts.intStorageId
				JOIN tblstoragetype tst ON ts.intStorageTypeId = tst.intStorageTypeId
				JOIN tblbloodvolume tbv ON tbb.intBloodVolumeId = tbv.intBloodVolumeId
				JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
				WHERE stfIsBloodBagExpired = 'Yes'
				AND stfIsBloodBagDiscarded = 'No'
				OR DATEDIFF(NOW(), dtmDateStored) > tp.intPreservativeLifespan
				AND strBloodBagSerialNo = '$serialno'
			");
			if(mysqli_num_rows($fetch_expiredbb) > 0)	{
				$output .= "
					<tr>
						<td class='pt-3'>$serialno</td>
						<td>
							<button type='button' class='btn btn-outline-danger btn-sm btn_discard' data-id=$serialno>
								<i class='fas fa-sm fa-archive mr-1'></i>
								Discard
							</button>
						</td>
					</tr>
				";
			}
		}
		$output .= "</table>";
		echo $output;
	}
	else if (mysqli_num_rows($fetch_expiredbloodbags) == 0)	{
		echo "
			<div class='text-center'>
				<i class='fas fa-box fa-5x'></i>
				<h5 class='p-2'>
					No expired blood bags.
				</h5>
			</div>
		";
	}
?>
<script type="text/javascript">
	$(document).on("click",".btn_discard",function(){
		var serialno = $(this).attr("data-id");
		swal({
			title: "Discard blood bag",
			text: "This bag will be discarded due to its long period outside the storage",
			icon: "info",
			buttons: true,
		})
		.then((willApprove) => {
			if (willApprove) {
				$.ajax({
					method: "POST",
					url: "../controller/blood/discardBloodBag.php",
					data: "serialno=" + serialno,
					success: function (data) {
						// swal("Success!","Blood bag is now discarded.","success");
						swal({
							title: '',
							text: 'Blood bag discarded successfully!',
							icon: 'success',
							buttons: {text: 'Okay'}
						})
						.then((willApprove) => {
							if (willApprove) {
								location.reload();
							}
						});
					}
				});
			}
			else {
				swal("","No action done");
			}
		});
	});
</script>