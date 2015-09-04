<?php include('../include/header.uc.php'); ?>
<?php include('../include/sidebar-admin.uc.php'); ?>
<?php include('../include/mysqli_connect.php'); ?>
<?php
//<p></p>
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array();
    if(empty($_POST['category'])){
      $error[] = "category";
    }else {
      $cat_name = mysqli_real_escape_string($conn, strip_tags($_POST['category']));
    }
    if(isset($_POST['position']) && filter_var($_POST['position'],FILTER_VALIDATE_INT,array('min_range'=>1))){
      $position = $_POST['position'];
    }else {
      $error[] = "position";
    }
    if(empty($error)){ //Neu khong co loi xay ra thi chen vao CSDL
      $query = "INSERT INTO categories(user_id, name, position) VALUES
      (1, '{$cat_name}', $position);";
      $result = mysqli_query($conn, $query) or
        die("Query {$query}<br />MySQL Error: ".mysqli_error($conn));
        if (mysqli_affected_rows($conn) == 1) {
          $message = "<p class='success'>The category was added successfully.</p>";
        } else {
          $message = "<p class='warning'>Could not added to the database due to a system error</p>";
        }
    }else {
      $message = "<p class='warning'>Please fill all the required field</p>";
    }
  }
?>

<div id="content">
 <h2>Create a category</h2>
 <?php
  if(!empty($message)){
    echo $message;
  }
 ?>
  <form id="add_cat" action="" method="post">
    <fieldset>
      <legend>Add category</legend>
      <div>
        <label for="category">Category Name: <span class="required">*</span>
          <?php
            if(isset($error) && in_array('category',$error)){
              echo "<p class='warning'>Please fill in the category name</p>";
            }
          ?>
        </label>
        <input type="text" name="category"
          value="<?php if(isset($_POST['category'])) echo strip_tags($_POST['category']) ?>"
          id="category" size="20" maxlength="150" tabindex="1">
      </div>
      <div>
        <label for="position">Position: <span class="required">*</span>
          <?php
            if(isset($error) && in_array('position',$error)){
              echo "<p class='warning'>Please pick a position</p>";
            }
          ?>
        </label>
        <select tabindex="2" name="position">
          <?php
            $q = "SELECT count(cat_id) AS 'count' FROM categories";
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
    </fieldset>
    <p>
      <input type="submit" name="sm_cat" value="Add Category">
    </p>
  </form>

</div><!--end content-->
<?php include('../include/sidebar-b.uc.php'); ?>
<?php include('../include/footer.uc.php'); ?>
