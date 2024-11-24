
<?php
ob_start();
session_start();
include("admin/config.php");
include("admin/functions.php");
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

if(!isset($_REQUEST['id'])) {
	header('location: index.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_donor WHERE donor_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: index.php');
		exit;
	}
}
?>
<?php							
foreach ($result as $row) {
	$name = $row['name'];
	$description = $row['description'];
	$profession = $row['profession'];
	$education = $row['education'];
	$gender = $row['gender'];
	$date_of_birth = $row['date_of_birth'];
	$religion_id = $row['religion_id'];
	$blood_group_id = $row['blood_group_id'];
	$email = $row['email'];
	$phone = $row['phone'];
	$website = $row['website'];
	$address = $row['address'];
	$city = $row['city'];
	$country = $row['country'];
	$state = $row['state'];
	$zip_code = $row['zip_code'];
	$map = $row['map'];
	$photo = $row['photo'];
	$facebook = $row['facebook'];
	$twitter = $row['twitter'];
	$linkedin = $row['linkedin'];
	$googleplus = $row['googleplus'];
	$pinterest = $row['pinterest'];
	$agent_id = $row['agent_id'];
	$status = $row['status'];
	$don = $row['don'];
}
if( $status == 0 ) {
	header('location: index.php');
	exit;
}else{ 
    if($_SESSION["agent"]["agent_id"] ==$agent_id){
    echo '<div style="width:800px; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
<div style="width:750px; height:550px; padding:20px; text-align:center; border: 5px solid #787878">
       <span style="font-size:50px; font-weight:bold">Certificate of Blood Donation</span>
       <br><br>
       <span style="font-size:25px"><i>This is to certify that</i></span>
       <br><br>
       <span style="font-size:30px"><b>'.$name.'</b></span><br/><br/>
       <span style="font-size:25px"><i>has donated the blood for a good cause</i></span> <br/><br/>
       <span style="font-size:25px"><i>dated</i></span><br>
      <span style="font-size:30px">'.$don.'</span><br><br><br><br><br><br>
      <img src="img/sign.png"/ style="height:50px;width:150px;">
</div>
</div>';
    }else{
    header('location: index.php');
	exit;
    }
}
?>
