<?php
$conn = mysqli_connect('localhost', 'root', '', 'gt_pay');
if ($conn) {
    // echo "Success";
}else{
  echo 'Error'.mysqli_error();
}