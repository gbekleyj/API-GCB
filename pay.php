<?php
require 'includes/connection.php';

// ensuring output is json
header("Content-Type:application/json");
//process client request
if (file_get_contents('php://input')) {
	// decode request
	$request_data = json_decode(file_get_contents('php://input'), true);
	// validate request data
	if (empty($request_data['merchant_code'])) {
		response(400, "bad request: merchant_code is required", NULL);
	}elseif (empty($request_data['api_key'])) {
		response(400, "bad request: api_key is required!", NULL);
	}elseif (empty($request_data['amount'])) {
		response(400, "bad request: amount is required", NULL);
	}elseif (empty($request_data['order_id'])) {
		response(400, "bad request: order id is required", NULL);
	}elseif (empty($request_data['return_url'])) {
		response(400, "bad request: return url is required", NULL);
	}elseif (empty($request_data['product'])) {
		response(400, "bad request: product name is required", NULL);
	}elseif (empty($request_data['description'])) {
		response(400, "bad request: description is required", NULL);
	}elseif (empty($request_data['first_name'])) {
		response(400, "bad request: first name is required", NULL);
	}elseif (empty($request_data['last_name'])) {
		response(400, "bad request: last name is required", NULL);
	}elseif (empty($request_data['email'])) {
		response(400, "bad request: email is required", NULL);
	}elseif (empty($request_data['phone'])) {
		response(400, "bad request: phone is required", NULL);
	}else {
		$api_key_check = mysqli_query($conn, "SELECT * FROM `merchants` WHERE `api_key` = '".$request_data['api_key']."' ");
		if(mysqli_num_rows($api_key_check) == 0){
			response(400, "bad request: api key not found", NULL);
		}else{
			$merchant_code_check = mysqli_query($conn, "SELECT * FROM `merchants` WHERE `merchant_code` = '".$request_data['merchant_code']."' ");
			if (mysqli_num_rows($merchant_code_check) == 0) {
				response(400, "bad request: merchant code not found", NULL);
			}else{
				if (!is_numeric($request_data['amount'])) {
					response(400, "bad request: amount must be a number", NULL);
				}else{
					$order_id_check = mysqli_query($conn, "SELECT * FROM `transactions` WHERE `order_id` = '".$request_data['order_id']."' ");
					if (mysqli_num_rows($order_id_check) === 1) {
						response(400, "bad request: duplicate order id", NULL);
					}else{
						// generate system id
						$system_id = uniqid();
						// generate transaction status
						$transaction_status = "Pending Payment";
						// generate special auth code
						$auth = bin2hex(openssl_random_pseudo_bytes(10));
						// save transaction details
						$create_transaction = mysqli_query($conn, "INSERT INTO `transactions` 
																				(`auth`,
																				`status`,
																				`amount`,
																				`first_name`,
																				`last_name`,
																				`email`,
																				`phone`,
																				`merchant_code`,
																				`order_id`,
																				`system_id`,
																				`product`,
																				`description`,
																				`return_url`) 
																				VALUES 
																				('$auth', 
																				'$transaction_status', 
																				'".$request_data['amount']."', 
																				'".$request_data['first_name']."', 
																				'".$request_data['last_name']."', 
																				'".$request_data['email']."', 
																				'".$request_data['phone']."', 
																				'".$request_data['merchant_code']."', 
																				'".$request_data['order_id']."', 
																				'$system_id', 
																				'".$request_data['product']."', 
																				'".$request_data['description']."', 
																				'".$request_data['return_url']."')");

						if ($create_transaction) {
							response(200, "transaction created successfully", "http://localhost/api/paynow/checkout.php?auth=".$auth);
						}else{
							response(400, "bad request: transaction error", NULL);
							echo "Error".mysql_error();
						}
					}
				}
			}
		}

	}
	

}else{

	response(400, "bad request", NULL);
}

?>