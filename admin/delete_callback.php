 <?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	$statement = $pdo->prepare("SELECT * FROM tbl_callbacks WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	$statement = $pdo->prepare("SELECT * FROM tbl_callbacks WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	$statement = $pdo->prepare("DELETE FROM tbl_callbacks WHERE id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: callbacks.php');
?>
