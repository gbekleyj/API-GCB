
<?php

//REGISTRATION 

require 'includes/connection.php';
$message = "";
if (isset($_POST["submit"])) {
    $full_name = $_POST["fname"] . ' ' . $_POST["lname"];
    $full_name = mysqli_real_escape_string($conn, $full_name);
    $email     = mysqli_real_escape_string($conn, $_POST["email"]);
    $company   = mysqli_real_escape_string($conn, $_POST["company"]);
    $phone     = mysqli_real_escape_string($conn, $_POST["phone"]);
    $password  = mysqli_real_escape_string($conn, $_POST["password"]);


    $sql=mysqli_query($conn, "SELECT * FROM `merchants` WHERE `email_address` = '$email' ");

    if(mysqli_num_rows($sql) > 1){

        $message = "<div class='alert alert-danger alert-dismissible' style='width:auto;'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong></strong>Company Exists!
                 </div>
                 ";

     }else{

           if (strlen($password) < 6) {

              $message = "<div class='alert alert-danger alert-dismissible' style='width:auto;'>
                          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                          <strong></strong>Password is short! 6 Charcaters minimum.
                       </div>
                       ";

          } else {

              $new_pass  = password_hash($password, PASSWORD_DEFAULT);
              $api_key = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
              $merchant_code = bin2hex(openssl_random_pseudo_bytes(10));

              
              $query = mysqli_query($conn, "INSERT INTO `merchants` (`full_name`, `company_name`, `email_address`, `password`, `phone`, `api_key`, `merchant_code`) 
                                            VALUES 
                                            ('$full_name', '$company', '$email', '$new_pass', '$phone', '$api_key', '$merchant_code')");
              
              if ($query) {
                  
                  $message = "<div class='alert alert-success alert-dismissible' style='width:auto;'>
                          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                          <strong>Registered!</strong> Redirecting to Login.
                       </div>
                       ";
                  header('Refresh:3, ./login.php');
                  
              } else {
                  
                  $message = "<div class='alert alert-danger alert-dismissible' style='width:auto;'>
                          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                          <strong></strong>Error Registering. Pleasr Try Again.
                       </div>
                       ";
                  
              }
              
          }

      }
    
    
    
    
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form action="" method="POST">
          <?php echo $message; ?>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="text" name="fname" id="firstName" class="form-control" placeholder="First name" required="required" autofocus="autofocus">
                  <label for="firstName">First name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="text" name="lname" id="lastName" class="form-control" placeholder="Last name" required="required">
                  <label for="lastName">Last name</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required="required">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" name="company"  class="form-control" placeholder="Company Name" required="required">
              <label for="inputEmail">Company Name</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="required">
                  <label for="inputPassword">Password</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="text" name="phone" class="form-control" placeholder="Phone Number" required="required">
                  <label for="confirmPassword">Phone Number</label>
                </div>
              </div>
            </div>
          </div>
          <input class="btn btn-primary btn-block" name="submit" type="submit" value="Register" />
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>