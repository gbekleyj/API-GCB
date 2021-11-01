<?php
session_start();
require 'connection.php';
$query = mysqli_query($conn, "SELECT * FROM `store_items` ORDER by `id` DESC");
?>
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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <style>
    .block {
//  display: block;
  //position: relative;
  //width: 295px;
  //border-radius: 5px;
  background: #fff;
  box-shadow: 0 1px 2px rgba(0, 0, 0, .2);
}

.product {
  display: block;
  position: relative;
}

.product img {
  width: 100%;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

.info {
  display: block;
  position: relative;
  padding: 20px;
}

.details {
  border-top: 1px solid #e5e5e5;
  padding: 18px 20px;
}

.buttons {
  display: block;
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  background: rgba(255, 255, 255, .5);
  opacity: 0;
  -webkit-transition: opacity .25s ease-in;
  -ms-transition: opacity .25s ease-in;
  -moz-transition: opacity .25s ease-in;
  -o-transition: opacity .25s ease-in;
  transition: opacity .25s ease-in;
}

.product:hover .buttons, .product:hover a {
  opacity: 1;
}

.buttons a {
  display: block;
  position: absolute;
  left: 50px;
  width: 155px;
  border-radius: 2px;
  //padding: 15px 10px 15px 65px;
  //font-family: Helvetica, sans-serif;
  
  text-transform: uppercase;
  color: #fff;
  text-decoration: none;
  opacity: 0;
}

a.buy {
  top: 20%;
}


.info::after {
  display: block;
  position: absolute;
  top: -8px;
  left: 23px;
  content: "";
  width: 15px;
  height: 15px;
  background: #fff;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
}

.info h4 {
  position: relative;
  padding: 0 0 20px 0;
  margin: 0 0 20px 0;
  font-family: "Open Sans", sans-serif;
  font-weight: 700;
  font-size: 19px;
  line-height: 25px;
  color: #372f2b;
  letter-spacing: -1px;
}

.info h4::after {
  display: block;
  position: absolute;
  bottom: 0px;
  content: "";
  width: 40px;
  height: 2px;
  background: #3b86c4;
}

.info .description {
  display: block;
  padding-bottom: 20px;
  font-family: "Open Sans", sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: #5f5f5f;
}

.info .price {
  font-family: "Open Sans", Helvetica, Arial, sans-serif;
  font-size: 24px;
  font-weight: 700;
  color: #372f2b;
  line-height: 26px;
}


  </style>

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="#">GCB BANK DEPOSIT </a>

  </nav>

  <div id="wrapper">

    <div id="content-wrapper">

      <div class="container-fluid">

      </div>
      <!-- /.container-fluid -->

      <div class="container">
        <?php if (isset($_GET['message']) == 'success')
          echo "<div class='alert alert-success alert-dismissible' style='width:auto;'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Hurray!</strong> Your Payment was successful! Thanks for the purchase
                  </div>";
        ?>
        <div class="row">
          <?php
            while ($result = $query->fetch_assoc()){
               ?> 
               <div class="col-md-3">
                <div class="block span3">
                  <div class="product">
                    <img src="<?php echo $result['image']?>">
                  </div>
                
                  <div class="info">
                    <h4><?php echo $result['item']?></h4>
                    <span class="description">
                      <?php echo $result['description']?>
                    </span>
                    <span class="price">₵ <?php echo $result['amount']?></span>
                    <a class="btn btn-success pull-right view_data float-right" href="javascript:void(0)" id="<?php echo $result['id']?>">DEPOSIT</a>
                  </div>
                </div>
                </div>
      <?php } ?>
          
            
        </div>
      </div>
      
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

  <!-- Product Modal-->
  <div class="modal fade" id="buymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Product Summary</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form method="Post" action="initiate.php">
          <div class="modal-body" id="item_data"></div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <script>
    $(document).on('click', '.view_data', function(){
           var item_id = $(this).attr("id");
           if(item_id != '')
           {  
                $.ajax({  
                     url:"item_details.php", 
                     method:"POST",  
                     data:{item_id:item_id},
                     success:function(data){  
                          $('#item_data').html(data);
                          $('#buymodal').modal('show');  
                     }, 
                });  
           }            
      });
</script>

</body>

</html>