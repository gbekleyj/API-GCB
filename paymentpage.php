<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Deposit Page</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="#">Merchant : <?php echo $row_mn['company_name']; ?></a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    

  </nav>

  <div id="wrapper">

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Deposit Amt :
            <a href="#"> <?php echo $row_td['product'];?></a>
          </li>
          <li class="breadcrumb-item active"><?php echo $row_td['description'];?></li>
        </ol>

        <!-- Page Content -->
        <h2>Amount: GH₵ <?php echo $row_td['amount'];?></h2>
        <hr>

      </div>
      <!-- /.container-fluid -->
      <form action="" method="POST">

      <div class="container">
        <?php if(isset($_SESSION['alert'])){ 
            echo "<div class='alert alert-".$_SESSION['type']." alert-dismissible' style='width:auto;'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong></strong>".$_SESSION['alert']."
                 </div>";
           }?>  
      	<p><b>User Details</b></p>
      	<div class="row">
      		<div class="col-md-3">
      			<label>First Name</label>
      			<input type="text" class="form-control" name="first_name" value="<?php echo $row_td['first_name'];?>" readonly>
      		</div>
      		<div class="col-md-3">
      			<label>Last Name</label>
      			<input type="text" class="form-control" name="last_name" value="<?php echo $row_td['last_name'];?>" readonly>
      		</div>
      		<div class="col-md-3">
      			<label>Email</label>
      			<input type="text" class="form-control" name="email" value="<?php echo $row_td['email'];?>" readonly>
      		</div>
      		<div class="col-md-3">
      			<label>Phone Number</label>
      			<input type="text" class="form-control" name="phone" value="<?php echo $row_td['phone'];?>" readonly>
      		</div>
      	</div>
      	<hr>
      	<p><b>Payment Details</b></p>
      	<div class="row">
      		<div class="col-md-4">
      			<label>Card Number (4000100020003000)</label>
      			<input type="text" min="16" maxlength="16" minlength="16" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX" name="card_number" required> 
      		</div>
      		<div class="col-md-2">
      			<label>Exp (MM/YY) - (0323)</label>
      			<input type="text" class="form-control" maxlength="4" minlength="4" name="expiry" placeholder="MMYY" required>
      		</div>
      		<div class="col-md-2">
      			<label>CVV (901)</label>
      			<input type="text" class="form-control" name="cvv" maxlength="4" minlength="3" placeholder="***" required>
      		</div>
      		<div class="col-md-4">
      			<label>Country</label>
      			<select name="country" class="form-control">
      				<option value="GH">Ghana</option>
      			</select>
      		</div>
      	</div>
      	<hr>
      	<div class="row">
      		<div class="col-md-6">
      			<a class="btn btn-danger" href="javascript:void()" data-toggle="modal" data-target="#cancel"> Cancel Payment</a>
      		</div>
      		<div class="col-md-6">
      			<input type="submit" name="pay" value="Pay Now" class="btn btn-primary btn-block"/>
      		</div>
      	</div>
      </div>
  	  </form>
      <!-- Sticky Footer -->
      <footer class="sticky-footer" style="width: 100%">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright 2021</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sure you want to cancel the payment?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Yes, Cancel" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
          <form action="" method="POST">
          	<input type="hidden" name="cancel">
          	<button class="btn btn-danger" >Yes, Cancel</button>
          </form>
          
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin.min.js"></script>

</body>

</html>
<?php session_destroy();?>