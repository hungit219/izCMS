<?php
  //connect to database
  $conn = mysqli_connect('localhost', 'root', '', 'izcms');

  if (!$conn){
    trigger_error("Could not connect to DB", mysqli_connect_error());
  }else {
    mysqli_set_charset($conn, 'utf-8');
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Testing</title>
  </head>
  <body>
    <?php
      $q = "SELECT count(cat_id) AS 'count' FROM categories";
      $r = mysqli_query($conn,$q)
        or die("Query {$q}<br />MySQL Error: ".mysqli_error($conn));
      if(mysqli_num_rows($r) == 1){
        list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
        for ($i=1; $i <= $num; $i++) {
          echo "<option value='{$i}'>".$i."</option>";
        }
      }
    ?>
  </body>
</html>
