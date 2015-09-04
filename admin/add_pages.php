<?php include('../include/header.uc.php'); ?>
<?php include('../include/sidebar-admin.uc.php'); ?>
<?php include('../include/mysqli_connect.php'); ?>
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();
    if(empty($_POST['page_name'])){
      $errors[] = 'page_name';
    } else {
      $page_name = mysqli_real_escape_string($conn, strip_tags($_POST['page_name']));
    }
    if(isset($_POST['category']) && filter_var($_POST['category'],FILTER_VALIDATE_INT,array('min_range'=>1))){
      $cat_id = $_POST['category'];
    }else {
      $errors[] = "category";
    }
    if(isset($_POST['position']) && filter_var($_POST['position'],FILTER_VALIDATE_INT,array('min_range'=>1))){
      $position = $_POST['position'];
    }else {
      $errors[] = "position";
    }

    if(empty($_POST['content'])){
      $errors[] = "content";
    } else {
      $content = mysqli_real_escape_string($conn,$_POST['content']);
    }

    if(empty($errors)){
      $q = "INSERT INTO pages (user_id, cat_id, name, content, position, post_on)
        VALUES (1, {$cat_id}, '{$page_name}', '{$content}', $position, NOW())";
      $r = mysqli_query($conn, $q)
        or die("Query {$query}<br />MySQL Error: ".mysqli_error($conn));
      if (mysqli_affected_rows($conn) == 1){
        $message = "<p class='success'>The page was added successfully.</p>";
      } else {
        $message = "<p class='warning'>The page could not be added due to a
          system error.</p>";
      }
    } else {
      $message = "<p class='warning'>Please fill in all the required fields.</p>";
    }
  }
?>

<div id="content">
 <h2>Create a page</h2>
 <?php
  if(!empty($message)){
    echo $message;
  }
 ?>

 <form id="login" action="" method="post">
   <fieldset>
     <legend>Add a Page</legend>
     <div>
       <label for="page">Page Name: <span class="required">*</span>
         <?php
          if(isset($errors) && in_array('page_name', $errors)){
            echo "<p class='warning'>Please fill in the page name</p>";
          }
         ?>
       </label>
       <input type="text" name="page_name" id="page_name" size="20"
        maxlength="150" tabindex="1" value="<?php
          if(isset($_POST['page_name'])){
            echo strip_tags($_POST['page_name']);
          }
        ?>">
     </div>
     <div>
       <label for="category">All Category: <span class="required">*</span>
         <?php
          if(isset($errors) && in_array('category', $errors)){
            echo "<p class='warning'>Please pick a category</p>";
          }
         ?>
       </label>
       <select tabindex="2" name="category">
         <?php
           $q = "SELECT cat_id, name FROM categories ORDER BY position ASC";
           $r = mysqli_query($conn,$q)
             or die("Query {$q}<br />MySQL Error: ".mysqli_error($conn));
           if(mysqli_num_rows($r) > 0){
             while($cats = mysqli_fetch_array($r, MYSQLI_NUM)){
               echo "<option value='{$cats[0]}' ";
               if(isset($_POST['category']) && ($_POST['category'] == $cats[0])){
                 echo "selected ='selected'";
               }
               echo ">".$cats[1]."</option>";
             }

           }
         ?>
       </select>
     </div>
     <div>
       <label for="position">Position: <span class="required">*</span>
         <?php
          if(isset($errors) && in_array('position', $errors)){
            echo "<p class='warning'>Please pick a position.</p>";
          }
         ?>
       </label>
       <select tabindex="2" name="position">
         <?php
           $q = "SELECT count(pages_id) AS 'count' FROM pages";
           $r = mysqli_query($conn,$q)
             or die("Query {$q}<br />MySQL Error: ".mysqli_error($conn));
           if(mysqli_num_rows($r) == 1){
             list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
             for ($i=1; $i <= $num + 1; $i++) {
               echo "<option value='{$i}' ";
               if (isset($_POST['position']) && $_POST['position']==$i){
                 echo "selected='selected'";
               }
               echo ">".$i."</option>";
             }
           }
         ?>
       </select>
     </div>
     <div>
       <label for="page-content">Page Content: <span class="required">*</span>
         <?php
          if(isset($errors) && in_array('content', $errors)){
            echo "<p class='warning'>Please fill in the content</p>";
          }
         ?>
       </label>
       <textarea name="content" rows="20" cols="50"></textarea>
     </div>
   </fieldset>
   <p>
     <input type="submit" name="sm_cat" value="Add Category">
   </p>
 </form>

</div><!--end content-->
<?php include('../include/sidebar-b.uc.php'); ?>
<?php include('../include/footer.uc.php'); ?>
