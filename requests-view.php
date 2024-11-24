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

					<h1>View All Requests</h1>

					<table id="example" class="display" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Serial</th>
								<th>Name</th>
								<th>Blood Group</th>
								<th>Qunatity</th>
								<th>Phone</th>
								<th>Address</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$statement = $pdo->prepare("SELECT
                                                        t1.request_id,
														t1.name,
														t1.blood_group_id,
														t1.phone,
														t1.address,
														t1.status,
														t1.quantity,

														t3.blood_group_id,
														t3.blood_group_name


														FROM tbl_bloodrequests t1

														JOIN tbl_blood_group t3
														ON t1.blood_group_id = t3.blood_group_id


														WHERE t1.agent_id=?");
							$statement->execute(array($_SESSION['agent']['agent_id']));
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);			
							foreach ($result as $row) {
								$i++;
								?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['blood_group_name']; ?></td>
										<td><?php echo $row['quantity']; ?> Ltrs</td>
										<td><?php echo $row['phone']; ?></td>
										<td><?php echo $row['address']; ?></td>
										<td>
											<?php if($row['status'] == 0): ?>
											Pending
											<?php else: ?>
											Approved
											<?php endif; ?>
										</td>
										<td>
											<?php if($row['status']==0):?>
												<a href="<?php echo BASE_URL.URL_REQUEST_EDIT.$row['request_id']; ?>" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:3px;">Edit</a><br>
											<a onclick="return confirmDelete();" href="<?php echo BASE_URL.URL_REQUEST_DELETE.$row['request_id']; ?>" class="btn btn-danger btn-xs" style="width:100%;margin-bottom:3px;">Delete</a>
											<?php endif;?>
										</td>
									</tr>
								<?php
							}
							?>
							
							
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>
