<?php
require 'connection.php';
if (isset($_POST['pay'])) {
  $amount = mysqli_real_escape_string($conn, $_POST['amount']);
  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $product = mysqli_real_escape_string($conn, $_POST['product']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $api_key = "b5f1ba-bcc7a6-063608-269da2-67b117";
  $merchant_code = "cbed5006a79307aee6cc";
  $order_id = uniqid();
  $return_url = "http://localhost/tests/api/store/index.php";

  $data = json_encode(array(
          "amount"  => $amount,
          "api_key" => $api_key,
          "first_name" => $first_name,
          "last_name" => $last_name,
          "email" => $email,
          "phone" => $phone,
          "merchant_code" => $merchant_code,
          "order_id" => $order_id,
          "product" => $product,
          "description" => $description,
          "return_url" => $return_url
          ));

  $curl = curl_init();


  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://localhost/tests/api/pay.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  
  $result = json_decode($response, true);
  $url_redirect = $result['url'];

  header("Location: $url_redirect");

}