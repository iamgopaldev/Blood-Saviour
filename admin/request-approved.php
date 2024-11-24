
<?php require_once('header.php'); ?>
<?php
if($_SESSION['stock_error']==true){
    echo '<script>alert("There is no Enough Stock!")</script>';
    $_SESSION['stock_error']=false;
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>View All Approved Requests</h1>
	</div>
	<div class="content-header-right">
		<a href="request-pending.php" class="btn btn-primary btn-sm">Pending Requests</a>
	</div>
</section>


<section class="content">

  <div class="row">
    <div class="col-md-12">

      <div class="box box-info">
        
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped">
			<thead>
			    <tr>
			        <th>Serial</th>
                    <th>Name</th>
                    <th>Blood Group</th>
                    <th>Qunatity</th>
                    <th>Phone</th>
                    <th>Address</th>
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
                                            t1.quantity,
                                            t1.agent_id,
                                            t1.status,

                                            t3.blood_group_id,
                                            t3.blood_group_name


                                            FROM tbl_bloodrequests t1

                                            JOIN tbl_blood_group t3
                                            ON t1.blood_group_id = t3.blood_group_id


                                            WHERE t1.status=1");
                $statement->execute();
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
                        </tr>
                    <?php
                }
                ?>
                
                
            </tbody>
            
          </table>
        </div>
      </div>
  
</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="confirm-approve" tabindex="-2" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">Approval Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to approve this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Approve</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>