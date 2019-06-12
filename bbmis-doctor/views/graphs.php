<?php 
	include "../controller/fetchEmpAcc.php";
	
	//Remaining blood bag count - Fetching Counts with loop
	$fetch_bloodtypes = mysqli_query($connections, "
		SELECT DISTINCT(stfBloodType) AS 'Blood Type'
		FROM tblbloodtype
		WHERE stfBloodTypeStatus = 'Active'
		AND stfBloodType != 'Undefined'
	");
	$arr_bloodtypes = array();
	while($row_bloodtypes = mysqli_fetch_assoc($fetch_bloodtypes))	{		
		array_push($arr_bloodtypes, $row_bloodtypes['Blood Type']);
	}
	
	$countbloodtypes = mysqli_num_rows($fetch_bloodtypes);
	
	$arr_rembloodbags = array();
	
	for($x=0; $x<$countbloodtypes; $x++)	{
		$fetch_countofbloodbagtype = mysqli_query($connections, "
			SELECT COUNT(tbb.intBloodBagId) AS 'bloodbagcount'
			FROM tblbloodtype tbt
			JOIN tblbloodbag tbb ON tbt.intBloodTypeId = tbb.intBloodTypeId
			JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
			WHERE tbt.intBloodTypeId IN	(
				SELECT intBloodTypeId
				FROM tblbloodtype
				WHERE stfBloodType = '$arr_bloodtypes[$x]')
			AND stfIsBloodBagExpired = 'No'
			AND stfIsBloodBagDiscarded = 'No'
			AND tbt.stfBloodType = '$arr_bloodtypes[$x]'
			AND TIMESTAMPDIFF(DAY, dtmDateStored, NOW()) <= tp.intPreservativeLifespan"
		);
		$row_countbloodbagtype = mysqli_fetch_assoc($fetch_countofbloodbagtype);
		array_push($arr_rembloodbags, $row_countbloodbagtype['bloodbagcount']);
	}
	//end - see Line 276/279
	
	//wastage report
	$fetch_totalbloodbags = mysqli_query($connections, "
		SELECT COUNT(*) AS 'total_remainingbloodbags'
		FROM tblbloodbag tbb
		JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
		WHERE stfIsBloodBagExpired = 'No'
		AND stfIsBloodBagDiscarded = 'No'
		AND TIMESTAMPDIFF(DAY, dtmDateStored, NOW()) <= tp.intPreservativeLifespan
	");
	$row_totalbloodbags = mysqli_fetch_assoc($fetch_totalbloodbags);
	$total_bloodbags = $row_totalbloodbags["total_remainingbloodbags"];
	
	$fetch_wastedbloodbags = mysqli_query($connections, "
		SELECT COUNT(*) AS 'Wasted Blood Bags'
		FROM tblbloodbag tbb
		JOIN tblpreservatives tp ON tbb.intPreservativeId = tp.intPreservativeId
		WHERE stfIsBloodBagExpired = 'Yes'
		AND stfTransfusionSuccess = 'No'
	");
	$row_wastedbloodbags = mysqli_fetch_assoc($fetch_wastedbloodbags);
	$wasted_bloodbags = $row_wastedbloodbags["Wasted Blood Bags"];
	
	//Donors per Blood Type - loop
	$arr_donorcountperbloodtype = array();
	for($x=0; $x<$countbloodtypes; $x++)	{
		$fetch_donorcounttype = mysqli_query($connections, "
			SELECT bt.stfBloodType, COUNT(c.intClientId) AS 'Donor Count'
			FROM tblbloodtype bt
			JOIN tblclient c ON bt.intBloodTypeId = c.intBloodTypeId
			WHERE c.stfClientType = 'Donor'
			AND stfBloodType = '$arr_bloodtypes[$x]'
			AND c.intClientId IN (
				SELECT d.intClientId
					FROM tbldonation d
			)
		");
		$row_countdonortype = mysqli_fetch_assoc($fetch_donorcounttype);
		array_push($arr_donorcountperbloodtype, $row_countdonortype['Donor Count']);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="../../public/assets/blood.ico">
  <link rel="stylesheet" href="../../public/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/main.css">
  <link rel="stylesheet" href="../../public/css/all.css">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ReFeel - Graphs</title>
</head>
<body>
  <?php include "components/loader.php"; ?>
  <div class="wrapper">
		<?php include "components/sidebar.php"; ?>
    <main class="mainpanel">
      <?php include "components/header.php"; ?>
      <div class="page-title">
        <h3 class="p-2">Graphs</h3>
      </div>
      <section class="content">
        <div class="container-fluid">
					<div class="content-container">
						<div class="row text-center align-self-center mx-4 py-4"> <!-- Row 1 -->
							<div class="w-50 p-2">
								<h4>Remaining Blood Bags</h4>
								<canvas id="bloodbagcountperbloodtype"></canvas>
							</div>
							<div class="w-50 p-2">
								<h4>Blood Bag Wastages</h4>
								<canvas id="wastage"></canvas>
							</div>							
						</div>						
						<div class="row text-center align-self-center mx-4 py-4"> <!-- Row 2 -->
							<div class="w-50 p-2">
								<h4>Donors per Blood Type</h4>
                <canvas id="donorcountperbloodtype"></canvas>
							</div>						
						</div>						
					</div>
        </div>
      </section>
    </main>
  </div>
  <?php include "components/core-script.php"; ?>
  <script src="../../public/js/notification.js"></script>
  <script src="../../public/js/Chart.bundle.js"></script>
  <script>

		//random chart's rgb for fun
		function getRandomInt(max) {
			return Math.floor(Math.random() * Math.floor(max));
		}
		
    $('#home').addClass('active');
    $('#graphs').addClass('active');
    $('.loader').hide();

    // check_expiringbloodbags();

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

    // function check_expiringbloodbags(){
    //   $.ajax({
    //     type: "POST",
    //     url: "blood-related/check_expiringbloodbags.php",
    //     complete: function(){
    //       setTimeout(check_expiringbloodbags, 60000);
    //     }
    //   });
    // }


    var chart_bloodbagcountperbloodtype = document.getElementById("bloodbagcountperbloodtype").getContext('2d');
    var ch_bloodbagcountperbloodtype = new Chart(chart_bloodbagcountperbloodtype, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($arr_bloodtypes);?>,
        datasets: [{
          // label: '# of Remaining Blood Bags',
          data: <?php echo json_encode($arr_rembloodbags);?>,
          backgroundColor: [
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)"
						
						// 'rgba(255, 99, 132, 0.2)',
            // 'rgba(54, 162, 235, 0.2)',
            // 'rgba(255, 206, 86, 0.2)',
            // 'rgba(75, 192, 192, 0.2)'
          ],
          borderColor: [
            // 'rgba(255, 99, 132, 1)',
            // 'rgba(54, 162, 235, 1)',
            // 'rgba(255, 206, 86, 1)',
            // 'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true,
							callback: function (value) { if (Number.isInteger(value)) { return value; } },
              stepSize: <?php
								echo ceil(array_sum($arr_rembloodbags)/count($arr_rembloodbags));
							?>,
              suggestedMin: 0,
              suggestedMax: <?php echo array_sum($arr_rembloodbags) ?>
            },
						scaleLabel: {
							display: true,
							labelString: 'Remaining blood bags'
						}
          }],
					xAxes: [{
            scaleLabel: {
							display: true,
							labelString: 'Blood types'
						}
          }]
        },
				legend: {
					display: false
				},
				tooltips: {
					callbacks: {
						label: function(tooltipItem) {
							return tooltipItem.yLabel;
						}
					}
				}
      }
    });

    var chart_wastage = document.getElementById("wastage").getContext('2d');
    var ch_wastage = new Chart(chart_wastage, {
      type: 'pie',
      data: {
        labels: ["Remaining", "Wasted"],
        datasets: [{
          label: 'Wastage',
          data: [ <?php echo json_encode($total_bloodbags) ?>, <?php echo json_encode($wasted_bloodbags) ?> ],
          backgroundColor: [
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)"
						
						// 'rgba(255, 99, 132, 0.2)',
            // 'rgba(54, 162, 235, 0.2)',
            // 'rgba(255, 206, 86, 0.2)',
            // 'rgba(75, 192, 192, 0.2)'						
          ],
          borderColor: [
            // 'rgba(255, 99, 132, 1)',
            // 'rgba(54, 162, 235, 1)',
            // 'rgba(255, 206, 86, 1)',
            // 'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      }
    });

    var chart_donorcountperbloodtype = document.getElementById("donorcountperbloodtype").getContext('2d');
    var ch_wastage = new Chart(chart_donorcountperbloodtype, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($arr_bloodtypes);?>,
        datasets: [{
          // label: '# of Donors',
          data: <?php echo json_encode($arr_donorcountperbloodtype);?>,
          backgroundColor: [
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)",
            "rgba("+getRandomInt(256)+","+getRandomInt(256)+","+getRandomInt(256)+",0.5)"
						
						// 'rgba(255, 99, 132, 0.35)',
            // 'rgba(54, 162, 235, 0.35)',
            // 'rgba(255, 206, 86, 0.35)',
            // 'rgba(75, 192, 192, 0.35)'
          ],
          // borderColor: [
            // 'rgba(255, 99, 132, 0)',
            // 'rgba(54, 162, 235, 0)',
            // 'rgba(255, 206, 86, 0)',
            // 'rgba(75, 192, 192, 0)'
          // ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true,
							callback: function (value) { if (Number.isInteger(value)) { return value; } },
              stepSize: <?php
								echo ceil(array_sum($arr_donorcountperbloodtype)/count($arr_donorcountperbloodtype));
							?>,
							suggestedMin: 0,
              suggestedMax: <?php echo array_sum($arr_donorcountperbloodtype) ?>
            },
						scaleLabel: {
							display: true,
							labelString: 'Donor count'
						}
          }],
					xAxes: [{
            scaleLabel: {
							display: true,
							labelString: 'Blood types'
						}
          }]
        },
				legend: {
					display: false
				},
				tooltips: {
					callbacks: {
						label: function(tooltipItem) {
							return tooltipItem.yLabel;
						}
					}
				}
      }
    });
  </script>
</body>
</html>