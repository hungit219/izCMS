<?php
  include('../include/header.uc.php');
  include('../include/mysqli_connect.php');
  include('../include/function.php');
  include('../include/sidebar-a.uc.php');
?>
<div id="content">
  <?php
    if (isset($_GET['cid']) && filter_var($_GET['cid'],
      FILTER_VALIDATE_INT,array('min_range'=>1))){
        $cid = $_GET['cid'];
        $q = "SELECT p.name, p.pages_id, p.content, ";
        $q .= "DATE_FORMAT(p.post_on, '%b %d %y') AS 'date', ";
        $q .= "CONCAT_WS(' ', u.first_name, u.last_name) AS 'fullname', u.user_id ";
        $q .= "FROM pages AS p ";
        $q .= "INNER JOIN users AS u ";
        $q .= "USING(user_id) ";
        $q .= "WHERE p.cat_id={$cid} ";
        $q .= "ORDER BY date ASC LIMIT 0, 10";
        $r = mysqli_query($conn, $q);
        confirm_query($r, $q);
        if (mysqli_num_rows($r) > 0){//Neu co post show ra browser
          while ($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo "
              <div class='post'>
                <h2><a href='single.php?pid={$pages["pages_id"]}'>{$pages['name']}</a></h2>
                <p>".the_excerpt($pages['content'])."...
                  <a href='single.php?pid={$pages["pages_id"]}'>Read more</a></p>
                <p class='meta'><strong>Posted by:</strong>{$pages['fullname']} |
                  <strong>On: </strong>{$pages['date']}</p>
              </div>
              ";
          }
        } else {
          echo "<p>There are currently no post in this category.</p>";
        }
    }
  ?>

</div><!--end content-->
<?php include('../include/sidebar-b.uc.php'); ?>
<?php include('../include/footer.uc.php'); ?>
