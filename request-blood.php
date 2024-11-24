<?php require_once('header.php'); ?>

<?php
// Check if the agent is logged in or not
if(!isset($_SESSION['agent'])) {
	header('location: '.BASE_URL.URL_LOGOUT);
	exit;
} else {
	// If agent is logged in, but admin make him inactive, then force logout this user.
	$statement = $pdo->prepare("SELECT * FROM tbl_agent WHERE agent_id=? AND agent_access=?");
	$statement->execute(array($_SESSION['agent']['agent_id'],0));
	$total = $statement->rowCount();
	if($total) {
		header('location: '.BASE_URL.URL_LOGOUT);
		exit;
	}
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

    	$final_name1 = array();       
        

	    // Adding data into the tbl_car table
        $statement = $pdo->prepare("
        					INSERT INTO tbl_bloodrequests (
        					name,
        					blood_group_id,
        					quantity,
        					address,
        					phone,
                            agent_id
        					) 

        					VALUES 
        					(?,?,?,?,?,?)");
        $statement->execute(array(
        					$_POST['name'],
        					$_POST['blood_group_id'],
        					$_POST['quantity'],
        					$_POST['address'],
        					$_POST['phone'],
        					$_SESSION['agent']['agent_id']
        				));

        $success_message .= "Request Sent successfully. You can collect blood after getting approved by admin.";

        unset($_POST['name']);
        unset($_POST['blood_group_id']);
        unset($_POST['phone']);
        unset($_POST['qunatity']);
        unset($_POST['address']);
		
    }
}
?>


<div class="dashboard-area bg-area" style="background-color:#ffefff;">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-12">
				<div class="option-board">
					<?php require_once('dashboard-menu.php'); ?>
				</div>
			</div>
			<div class="col-md-9 col-sm-12">
				<div class="detail-dashboard">

					<h1>Request For Blood</h1>

					
					
                    <?php
                    $allowed = 1;
                    ?>
					<?php
					if($error_message != '') {
						echo "<script>alert('".$error_message."')</script>";
					}
					if($success_message != '') {
						echo "<script>alert('".$success_message."')</script>";
					}
					?>
					<?php if($allowed == 0): ?>
					<div class="error">You can only add donor after making a payment. <a href="<?php echo BASE_URL; ?>payment.php" style="color:red;text-decoration:underline;">Go here</a> to make a payment.</div>
					<?php else: ?>
					<div style="margin-bottom: 20px;">* = Required Fields</div>
					<div class="add-car-area">
						<div class="row">
							<div class="information-form">
								<form action="" method="post" enctype="multipart/form-data">
									<div class="form-row">
                                    <div class="form-group col-md-6 col-sm-6">
											<label for="">Name *</label>
											<input autocomplete="off" type="text" class="form-control" name="name" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} ?>">
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
													<option value="<?php echo $row['blood_group_id']; ?>"><?php echo $row['blood_group_name']; ?></option>
													<?php
												}
												?>
											</select>
										</div>
										<div class="form-group col-md-6 col-sm-6">
											<label for="">Quantity (in Ltrs) *</label>
											<input autocomplete="off" type="text" class="form-control" name="quantity" value="<?php if(isset($_POST['quantity'])) {echo $_POST['quantity'];} ?>">
										</div>
                                        <div class="form-group col-md-6 col-sm-6">
											<label for="">Phone *</label>
											<input autocomplete="off" type="text" class="form-control" name="phone" value="<?php if(isset($_POST['phone'])) {echo $_POST['phone'];} ?>">
										</div>
									</div>	 	
									<div class="form-group col-md-12">
										<label for="">Address *</label>
										<textarea class="form-control" name="address"><?php if(isset($_POST['address'])) {echo $_POST['address'];} ?></textarea>
										<button type="submit" class="btn btn-primary" name="form1">Request Blood</button>
									</div>

								</form>

							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>


<?php require_once('footer.php'); ?>
