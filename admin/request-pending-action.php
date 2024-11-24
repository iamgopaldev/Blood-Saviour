<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_bloodrequests WHERE request_id=?");
	$statement->execute(array($_REQUEST['id']));	
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$blood_group_id = $row['blood_group_id'];
        $quantity = $row['quantity'];
	}
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_blood_group  WHERE blood_group_id=?");
    $statement->execute(array($blood_group_id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
		$stock = $row['stock'];
	}
    if($stock>=$quantity){
        $statement = $pdo->prepare("UPDATE tbl_bloodrequests SET status=?  WHERE request_id=?");
	    $statement->execute(array(1,$_REQUEST['id']));
	    $statement = $pdo->prepare("UPDATE tbl_blood_group SET stock=stock-?  WHERE blood_group_id=?");
	    $statement->execute(array($quantity,$blood_group_id));
    }else{
        $_SESSION['stock_error']=true;
    }

	header('location: request-pending.php');
?>
