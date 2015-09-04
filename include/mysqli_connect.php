<?php
  //connect to database
  $conn = mysqli_connect('localhost', 'root', '', 'izcms');

  if (!$conn){
    trigger_error("Could not connect to DB", mysqli_connect_error());
  }else {
    mysqli_set_charset($conn, 'utf-8');
  }
?>
