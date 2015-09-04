<?php include('../include/header.uc.php'); ?>
<?php include('../include/sidebar-admin.uc.php'); ?>
<?php include('../include/mysqli_connect.php'); ?>
<?php include('../include/function.php'); ?>
<?php
  if (isset($_GET['cid']) && filter_var($_GET['cid'],FILTER_VALIDATE_INT,array('min_range'=>1))){
    $cid = $_GET['cid'];
  } else { //Tai dinh huong nguoi dung
    redirect_to('admin/admin.php');
  }

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
      $query = "UPDATE categories SET name='{$cat_name}', position = $position
        WHERE cat_id={$cid} LIMIT 1";
      $result = mysqli_query($conn, $query);
      confirm_query($result, $query);
      if (mysqli_affected_rows($conn) == 1) {
        $message = "<p class='success'>The category was edited successfully.</p>";
      } else {
        $message = "<p class='warning'>Could not edit the category due to a system error</p>";
      }
    }else {
      $message = "<p class='warning'>Please fill all the required field</p>";
    }
  }
?>

<div id="content">
  <?php
    $q = "SELECT name, position FROM categories WHERE cat_id={$cid}";
    $r = mysqli_query($conn, $q);
    confirm_query($r, $q);
    if (mysqli_num_rows($r) == 1) {
      //Neu category ton tai trong db dua vao cid thi se xuat du lieu ra ngoai browser
      list($cat_name, $position) = mysqli_fetch_array($r, MYSQLI_NUM);
    } else {
      //Neu cid ko hop le thi se khong the hien thi category
      $message = "<p class='warning'>The category does not exist.</p>";
    }
  ?>
 <h2>Edit Category: <?php
  if (isset($cat_name)) {
    echo "$cat_name";
  }
 ?></h2>
 <?php
  if(!empty($message)){
    echo $message;
  }
 ?>
  <form id="edit_cat" action="" method="post">
    <fieldset>
      <legend>Edit category</legend>
      <div>
        <label for="category">Category Name: <span class="required">*</span>
          <?php
            if(isset($error) && in_array('category',$error)){
              echo "<p class='warning'>Please fill in the category name</p>";
            }
          ?>
        </label>
        <input type="text" name="category"
          value="<?php if (isset($cat_name)) {echo "$cat_name";} ?>"
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
                if (isset($position) && ($position==$i)){
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
      <input type="submit" name="sm_cat" value="Update Category">
    </p>
  </form>

</div><!--end content-->
<?php include('../include/sidebar-b.uc.php'); ?>
<?php include('../include/footer.uc.php'); ?>
