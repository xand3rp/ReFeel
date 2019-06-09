<div class="sidebar">
  <div class="logo">
    <img src="../../public/assets/logo-w-x.png" class="mx-auto" style="max-width: 100%; width: 65%;  ">
  </div>
  <div class="navigation-wrapper">
    <div class="usr ">
      <div class="usrimg">
        <img src="../../public/img/<?php echo $varImg ?>" style="max-width: 100%; height: 3rem; width: 3rem; border-radius: 5rem;">
      </div>
      <div class="usrinfo">
        <p style="font-weight: 600; color: #212121;"><?php echo $varFname . ' ' . $varLname; ?><br><span style="font-weight: 300;"><?php echo $varRole; ?></span></p>
      </div>
    </div>
    <div class="pl-1 pr-1">
      <hr style="margin: 0">
    </div>
    <ul class="nav custom-nav">
      <li class="custom-nav-item nav-item">
        <a href="" id="home" class="nav-link" data-toggle="collapse" data-target="#home-tabs" aria-controls="home-tabs" aria-expanded="false">
					<div class="d-inline-flex text-center">
						<div style="width: 30px;"><i class="fas fa-home"></i></div>
						<span>Home</span>
					</div>
        </a>
        <div class="collapse show" id="home-tabs">
          <ul class="nav d-block pl-4">
            <li class="nav-item">
              <a href="graphs.php" id="graphs" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-chart-line mr-1"></i></div>
									<span>Graphs</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="donor-list.php" id="donor-list" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-list mr-1"></i></div>
									<span>Donor List</span>
								</div>
							</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="custom-nav-item nav-item">
        <a href="" id="maintenance" class="nav-link" data-toggle="collapse" data-target="#maintenance-tabs" aria-controls="maintenance-tabs" aria-expanded="false">
					<div class="d-inline-flex text-center">
						<div style="width: 30px;"><i class="fas fa-cogs"></i></div>
						<span>Maintenance</span>
					</div>
        </a>
        <div class="collapse show" id="maintenance-tabs">
          <ul class="nav d-block pl-4">
            <li class="nav-item">
              <a href="donor.php" id="donor" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-user-cog mr-1"></i></div>
									<span>Donor</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="blood-type.php" id="blood-type" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-heartbeat mr-1"></i></div>
									<span>Blood Type</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="blood-component.php" id="blood-component" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><img src="../../public/glyphicon/si-glyph-blood-bag.svg" class="mx-auto" style="width: 23px;"></div>
									<span>Blood Component</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="preservative.php" id="preservative" class="nav-link">
								<div class="d-inline-flex text-center">
									<!--<div style="width: 30px;"><i class="fas fa-pills mr-1"></i></div>-->
									<div style="width: 30px;"><i class="fas fa-vial mr-1"></i></div>
									<span>Preservative</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="disease.php" id="disease" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><img src="../../public/glyphicon/si-glyph-heart-delete.svg" style="width:17px; margin-right: .25rem !important;"></div>
									<span>Disease</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="donor-edit-requests.php" id="donor-edit-requests" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><img src="../../public/glyphicon/si-glyph-document-checked.svg" style="width: 17px; margin-right: .25rem !important;"></div>
									<span>Donor Edit Requests</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="survey.php" id="survey" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-file-alt mr-1"></i></div>
									<span>Survey</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="survey-category.php" id="survey-category" class="nav-link">
								<div class="d-inline-flex text-center">
									<!--<div style="width: 30px;"><i class="far fa-file-alt mr-1"></i></div>-->
									<div style="width: 30px;"><i class="fa fa-bars mr-1"></i></div>
									<span>Survey Category</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="storage.php" id="storage" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-box-open mr-1"></i></div>
									<span>Storage</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="staff.php" id="staff" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-user-md mr-1"></i></div>
									<span>Staff</span>
								</div>
							</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="custom-nav-item nav-item">
        <a href="" id="transaction" class="nav-link" data-toggle="collapse" data-target="#transaction-tabs" aria-controls="transaction-tabs" aria-expanded="false">
					<div class="d-inline-flex text-center">
						<div style="width: 30px;"><i class="fas fa-stethoscope"></i></div>
						<span>Transaction</span>
					</div>
        </a>
        <div class="collapse show" id="transaction-tabs">
          <ul class="nav d-block pl-4">
            <li class="nav-item">
              <a href="donor-records.php" id="donor-records" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-file-medical-alt mr-1"></i></div>
									<span>Donor Records</span>
								</div>
							</a>
            </li>
            <li class="nav-item">
              <a href="blood-inventory.php" id="blood-inventory" class="nav-link">
								<div class="d-inline-flex text-center">
									<div style="width: 30px;"><i class="fas fa-first-aid mr-1"></i></div>
									<span>Blood Inventory</span>
								</div>
							</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="custom-nav-item nav-item">
        <a href="reports.php" id="reports" class="nav-link">
          <div class="d-inline-flex text-center">
						<div style="width: 30px;"><i class="fas fa-file-medical"></i></div>
						<span>Reports</span>
					</div>
        </a>
      </li>
    </ul>
  </div>
</div>