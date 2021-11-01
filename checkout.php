<?php
session_start();
require '../includes/connection.php';
$date = date('Y-m-d h:i:s');




// process auth
if (isset($_GET['auth'])) {
	$auth = mysqli_real_escape_string($conn, $_GET['auth']);
	$check_auth_validity = mysqli_query($conn, "SELECT * FROM `transactions` WHERE `auth` = '$auth'");
	if (mysqli_num_rows($check_auth_validity) == 0) {
		header("Content-Type:application/json");
		response(400, "bad request: auth not found", NULL);
	}else{
		$check_payment_status = mysqli_query($conn, "SELECT * FROM `transactions` WHERE `auth` = '$auth' AND `status` = 'Pending Payment'");
		if (mysqli_num_rows($check_payment_status) == 0) {
			header("Content-Type:application/json");
			response(400, "bad request: session already completed", NULL);
		}else{
			// select transaction details
			$transaction_details = mysqli_query($conn, "SELECT * FROM `transactions` WHERE `auth` = '$auth'");
			$row_td = mysqli_fetch_assoc($transaction_details);
			// select merchant name
			$merchant_name = mysqli_query($conn, "SELECT `company_name` FROM `merchants` WHERE `merchant_code` = '".$row_td['merchant_code']."'");
			$row_mn = mysqli_fetch_assoc($merchant_name);

			// PAYMENT PROCESS
			if (isset($_POST['pay'])) {
				$card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
				$expiry = mysqli_real_escape_string($conn, $_POST['expiry']);
				$cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
				$country = mysqli_real_escape_string($conn, $_POST['country']);
				if (empty($card_number) && empty($expiry)) {
					$_SESSION['type'] = "danger";
					$_SESSION['alert'] = "Enter Card Number";
				}elseif ($card_number != 4000100020003000 && $expiry != 0323 && $cvv != 901) {
					$_SESSION['type'] = "danger";
					 $_SESSION['alert'] = "Payment Declined! Incorrect card details";
				}else{
					$_SESSION['type'] = "success";
					$_SESSION['alert'] = "Payment accepted: Redirecting...";
					$update_payment = mysqli_query($conn, "UPDATE `transactions` SET `status` = 'Payment Successful', 
																					`card_number` = '".substr($card_number, 0, 6)."', 
																					`expiry` = '$expiry', 
																					`date_updated` = '$date',
																					`country` = '$country' 
																					 WHERE 
																					`transactions`.`id` = '".$row_td['id']."'");

					if ($update_payment) {
						$_SESSION['shop_alert'] = "ok";
						header('Refresh:3, '.$row_td["return_url"].'?message=success');
					}
				}
			}
			// END PAYMENT PROCESS

			// IF PAYMENT IS CANCELLED
			if (isset($_POST['cancel'])) {
				// update payment status to cancelled
				$update_status = mysqli_query($conn, "UPDATE `transactions` SET `status` = 'Payment Cancelled', `date_updated` = '$date' WHERE `transactions`.`id` = '".$row_td['id']."'");
				if ($update_status) {
					header('Location:'.$row_td["return_url"]).'?message=cancelled';
				}
				
			}
			// END PAYMENT CANCELLATION


			
			require_once 'paymentpage.php';
		}
	}

}else{
	header("Content-Type:application/json");
	response(400, "bad request", NULL);
}
?>