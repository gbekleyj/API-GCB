<?php 
session_start();
require ('includes/connection.php'); 
if (isset($_SESSION['logged_in'])) {
    header('Location: ./index.php');
}


$message = "";

if(isset($_POST['submit'])){
  $email = ($_POST['email']);
  $password = ($_POST['password']);
  
  $sql = mysqli_query($conn, "SELECT * FROM  `merchants` WHERE `email_address` = '$email'");
  $numRows = mysqli_num_rows($sql);
  
  if($numRows  == 1){
    $row = mysqli_fetch_assoc($sql);
    if(password_verify($password,$row['password'])){


        $message="<div class='alert alert-success alert-dismissible' style='width:auto;'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong></strong>Logged In!
                  </div>"; 

        $_SESSION['logged_in'] = $row['id'];
        $_SESSION['access_code'] = $row['merchant_code'];

        header("Refresh:0.5, ./index.php");

        
        
    }else
    {
       $message="<div class='alert alert-danger alert-dismissible' style='width:auto;'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong></strong>Incorrect Email or Password
                 </div>";

  }
 }else{
      $message="<div class='alert alert-danger alert-dismissible' style='width:auto;'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong></strong>Incorrect Email or Password
                 </div>";
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

  <title>API Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <?php echo $message; ?>
        <form action="" method="POST">
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
              <label for="inputEmail">Email address (gbekleyj@gmail.com)</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="required">
              <label for="inputPassword">Password (1234567890)</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <center>Register <a href="./register">here</a></center>
            </div>
          </div>
          <input type="submit" class="btn btn-primary btn-block" name="submit" value="Login" />
        </form>
        
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
