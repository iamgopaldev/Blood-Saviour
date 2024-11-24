<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: '.BASE_URL.URL_LOGOUT);
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_bloodrequests WHERE request_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: '.BASE_URL.URL_LOGOUT);
		exit;
	} else {
		// Preventing one user deleting another user's data through url
		foreach ($result as $row) {
			$agent_id = $row['agent_id'];
		}
		if($agent_id != $_SESSION['agent']['agent_id']) {
			header('location: '.BASE_URL.URL_LOGOUT);
			exit;
		}
	}
}
// If agent is logged in, but admin make him inactive, then force logout this user.
$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=? AND agent_access=?");
$statement->execute(array($_SESSION['agent']['agent_id'],0));
$total = $statement->rowCount();
if($total) {
	header('location: '.BASE_URL.URL_LOGOUT);
	exit;
}
?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;
	if(empty($_POST['name'])) {
		$valid = 0;
		$error_message .= 'Name can not be empty.\n';
	}
	if(empty($_POST['blood_group_id'])) {
		$valid = 0;
		$error_message .= 'You must have to select a blood group.\n';
	}
    if(empty($_POST['phone'])) {
		$valid = 0;
		$error_message .= 'Phone can not be empty.\n';
	}
	if(empty($_POST['address'])) {
		$valid = 0;
		$error_message .= 'Address can not be empty.\n';
	}
	
    if($valid == 1) {    	
	    	$statement = $pdo->prepare("UPDATE tbl_bloodrequests SET 
	    						name=?,
	        					blood_group_id=?,
	        					phone=?,
	        					address=?,
	        					quantity=?,
	        					status=?
	    						WHERE request_id=?
	    					");

	    	$statement->execute(array(
	    						$_POST['name'],
	        					$_POST['blood_group_id'],
	        					$_POST['phone'],
	        					$_POST['address'],
                                $_POST['quantity'],
	        					0,
	        					$_REQUEST['id']
	    					));
        
        $success_message .= "Request is Updated successfully. But our admin will approve this update manually. So please wait for that.";
		
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_bloodrequests WHERE request_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$name = $row['name'];
	$blood_group_id = $row['blood_group_id'];
    $quantity = $row['quantity'];
	$phone = $row['phone'];
	$address = $row['address'];
	$agent_id = $row['agent_id'];
}
?>


<div class="dashboard-area bg-area">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-12">
				<div class="option-board">
					<?php require_once('dashboard-menu.php'); ?>
				</div>
			</div>
			<div class="col-md-9 col-sm-12">
				<div class="detail-dashboard">

					<h1>Edit Blood Request Information</h1>
					<?php
					if($error_message != '') {
						echo "<script>alert('".$error_message."')</script>";
					}
					if($success_message != '') {
						echo "<script>alert('".$success_message."')</script>";
					}
					?>
					<div style="margin-bottom: 20px;">* = Required Fields</div>
					<div class="add-car-area">
						<div class="row">
							<div class="information-form">
                            <form action="" method="post" enctype="multipart/form-data">
									<div class="form-row">
                                    <div class="form-group col-md-6 col-sm-6">
											<label for="">Name *</label>
											<input autocomplete="off" type="text" class="form-control" name="name" value="<?php echo $name;?>">
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Blood Group *</label>
											<select data-placeholder="Choose a blood group" class="form-control chosen-select" name="blood_group_id">
												<?php
												$statement = $pdo->prepare("SELECT * FROM tbl_blood_group");
												$statement->execute();
												$result = $statement->fetchAll(PDO::FETCH_ASSOC);
												foreach ($result as $row) {
													?>
													<option></option>
													<option value="<?php echo $row['blood_group_id']; ?>" <?php if($row['blood_group_id'] == $blood_group_id) {echo 'selected';} ?>><?php echo $row['blood_group_name']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Quantity (in Ltrs) *</label>
											<input autocomplete="off" type="text" class="form-control" name="quantity" value="<?php echo $quantity;?>">
										</div>
                                        <div class="form-group col-md-6 col-sm-6">
											<label for="">Phone *</label>
											<input autocomplete="off" type="text" class="form-control" name="phone" value="<?php echo $phone;?>">
										</div>
									</div>	 	
									<div class="form-group col-md-12">
										<label for="">Address *</label>
										<textarea class="form-control" name="address"><?php echo $address; ?></textarea>
										<button type="submit" class="btn btn-primary" name="form1">Save Changes</button>
									</div>

								</form>

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>


<?php require_once('footer.php'); ?>