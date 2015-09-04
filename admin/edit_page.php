<?php include('../include/header.uc.php'); ?>
<?php include('../include/sidebar-admin.uc.php'); ?>
<?php include('../include/mysqli_connect.php'); ?>
<?php include('../include/function.php'); ?>
<?php
  //Kiem tra gia tri cua bien pid tu GET
  if (isset($_GET['pid']) && filter_var($_GET['pid'],
    FILTER_VALIDATE_INT,array('min_range'=>1))) {
    $pid = $_GET['pid'];
    //Neu pageId ton tai thi xu ly form
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
        $q = "UPDATE pages SET ";
        $q .= " name='{$page_name}', ";
        $q .= " cat_id={$cat_id}, ";
        $q .= " position={$position}, ";
        $q .= " content='{$content}', ";
        $q .= " user_id=1, ";
        $q .= " post_on=NOW() ";
        $q .= " WHERE pages_id={$pid} LIMIT 1";
        $r = mysqli_query($conn, $q);
        confirm_query($r, $q);

        if (mysqli_affected_rows($conn) == 1){
          $message = "<p class='success'>The page was edited successfully.</p>";
        } else {
          $message = "<p class='warning'>The page could not be edited due to a
            system error.</p>";
        }
      } else {
        $message = "<p class='warning'>Please fill in all the required fields.</p>";
      }
    }
  } else { // Neu page id ko ton tai thi redirect user ve trang nguoi dung
    redirect_to('admin/view_pages.php');
  }
?>

<div id="content">
  <?php
    //Chon pages trong db de show ra browser
    $q = "SELECT * FROM pages WHERE pages_id={$pid}";
    $r = mysqli_query($conn, $q);
    confirm_query($r, $q);
    if (mysqli_num_rows($r)==1 ){//Neu co page tra ve thi...
      $pages = mysqli_fetch_array($r, MYSQLI_ASSOC);
    } else {//Neu ko co page tra ve
      $message = "<p class='warning'>The page does not exist</p>";
    }
  ?>
 <h2>Edit Page <?php if(isset($pages['name'])) echo $pages['name']; ?></h2>
 <?php
  if(!empty($message)){
    echo $message;
  }
 ?>

 <form id="pages_edit_form" action="" method="post">
   <fieldset>
     <legend>Edit Page</legend>
     <div>
       <label for="page">Page Name: <span class="required">*</span>
         <?php
          if(isset($errors) && in_array('page_name', $errors)){
            echo "<p class='warning'>Please fill in the page name</p>";
          }
         ?>
       </label>
       <input type="text" name="page_name" id="page_name" size="20"
          maxlength="150" tabindex="1"
          value="<?php if(isset($pages['name'])) echo $pages['name']; ?>">
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
           $r = mysqli_query($conn,$q);
           if(mysqli_num_rows($r) > 0){
             while($cats = mysqli_fetch_array($r, MYSQLI_NUM)){
               echo "<option value='{$cats[0]}' ";
               if(isset($pages['cat_id']) && ($pages['cat_id'] == $cats[0])){
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
           $r = mysqli_query($conn,$q);
           confirm_query($r, $q);

           if(mysqli_num_rows($r) == 1){
             list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
             for ($i=1; $i <= $num + 1; $i++) {
               echo "<option value='{$i}' ";
               if (isset($pages['position']) && $pages['position']==$i){
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
       <textarea name="content" rows="20" cols="50">
        <?php
          if(isset($pages['content'])){
            echo htmlentities($pages['content'], ENT_COMPAT, 'utf-8');
          }
       ?>
     </textarea>
     </div>
   </fieldset>
   <p>
     <input type="submit" name="sm_pages" value="Add Save Changes">
   </p>
 </form>

</div><!--end content-->
<?php include('../include/sidebar-b.uc.php'); ?>
<?php include('../include/footer.uc.php'); ?>
