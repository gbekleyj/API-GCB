<?php
require ('connection.php');

 if(isset($_POST["item_id"]))
 {  
      $output = '';  
      $query = "SELECT * FROM `store_items` WHERE id = '".$_POST["item_id"]."'";
      $result = mysqli_query($conn, $query);
      $output .= '  
      <div class="table-responsive">  
           <table width="100%" class="table table-striped table-bordered table-hover" style="border: 0;" id="dataTables-example1">
                             <thead> ';
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= ' 
                <form method = "POST" action="initiate.php"> 
                <tr>  
                    <td width="10%"><label><b>Item:</b> '.$row["item"].'</label></td>
                     <td width="10%"><label><b>Price:</b> GHC '.$row["amount"].'</label></td>  
                       
                </tr>
                <tr>  
                     <td width="10%"><label><b>Description:</b>  '.$row["description"].'</label></td>  
                     <td width="70%">
                     <label>First Name: <input class="form-control" type="text" name ="first_name" required >
                     </label><label>Last Name: <input  class="form-control"type="text" name ="last_name" required>
                     </label><label>Email: <input class="form-control" type="text" name ="email" required>
                     <label>Phone</label><input class="form-control" type="text" name ="phone" required></label></td>


                      <input type="hidden" name ="amount" value="'.$row["amount"].'"> 
                      <input type="hidden" name ="product" value="'.$row["item"].'"> 
                      <input type="hidden" name ="description" value="'.$row["description"].'"> 
                </tr>
                <tr>  
                     <td width="50%"><input type="submit" name ="pay" value="Buy Now" class="btn btn-success btn-block" ></td>  
                </tr> 
                </form>  
           ';  
      }  
      $output .= ' 
  </thead>
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>