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

<!--Dashboard Start-->
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
					<h1 style="color:red">Blood Saviour Every Drop Matters</h1>

					<h1 style="color:red">Hi, <?php echo $_SESSION['agent']['agent_name']; ?></h1>

					<h3 style="color:red">Welcome to your dashboard.</h3>


<h4 style="margin-top:30px;"><strong>Statistics</strong></h4>
					<div class="row">
						<div class="col-md-4 col-sm-12 col-xs-12">
							<table class="table table-bordered">
								<tr>
									<td>Blood Group</td>
									<td>Available Stock</td>
								</tr>
								
								<?php
						
						$statement = $pdo->prepare("SELECT * FROM tbl_blood_group");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $row) {
							echo '<tr><td>'.$row['blood_group_name'].'</td>
							<td>'.$row['stock'].' Ltrs</td></tr>';
						}
										
					
					?>
							</table>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>
