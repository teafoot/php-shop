<?php require_once('header.php'); ?>

<?php
	if (!isset($_REQUEST['id'])) {
		header('location: logout.php');
		exit;
	} else {
		// Check the id is valid or not
		$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
		$statement->execute(array($_REQUEST['id']));
		$total = $statement->rowCount();
		if ($total == 0) {
			header('location: logout.php');
			exit;
		} else {
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$cust_status = $row['cust_status'];
			}
		}
	}
?>

<?php
	if ($cust_status == 0) {$final_status = 1;} else {$final_status = 0;}
	$statement = $pdo->prepare("UPDATE tbl_customer SET cust_status=? WHERE cust_id=?");
	$statement->execute(array($final_status, $_REQUEST['id']));

	header('location: customer.php');
?>