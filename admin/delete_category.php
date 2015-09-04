<?php include('../include/header.uc.php'); ?>
<?php include('../include/sidebar-admin.uc.php'); ?>
<?php include('../include/mysqli_connect.php'); ?>
<?php include('../include/function.php'); ?>
<div id="content">
	<?php
		if (isset($_GET['cid']) && isset($_GET['cname']) &&
		filter_var($_GET['cid'],FILTER_VALIDATE_INT,array('min_range'=>1))) {
			$cid = $_GET['cid'];
			$cname = $_GET['cname'];
			//Neu cid va cname ton tai thi se xoa category khoi db
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if (isset($_POST['delete']) && ($_POST['delete']=='yes')) {
					$q = "DELETE FROM categories WHERE cat_id={$cid} LIMIT 1";
					$r = mysqli_query($conn, $q);
					confirm_query($r, $q);
					if (mysqli_affected_rows($conn)==1){
						//Bao cho nguoi dung biet xoa thanh cong
						$message = "<p class='success'>The category was deleted successfully.</p>";
					} else {
						$message = "<p class='warning'>The category was not deleted due to a system error.</p>";
					}
				} else { // Neu nguoi dung khong muon xoa
					$message = "<p class='warning'>I thought so too! shouldn't be deleted.</p>";
				}
			}
		} else {//Neu id hoac name khong ton tai thi tai dinh huong nguoi dung
			redirect_to('admin/view_category.php');
		}
	?>
	<h2>Delete Categories: <?php
   if (isset($cname)) {
     echo htmlentities($cname, ENT_COMPAT, 'utf-8');
   }
  ?>
	</h2>
  <form action="" method="post">
  	<fieldset>
  		<legend>Delete Category</legend>
			<label for="delete">Are you sure?</label>
			<div>
				<input type="radio" name="delete" value="no" checked="checked">No</input>
				<input type="radio" name="delete" value="yes">Yes</input>
			</div>
			<div><input type="submit" name="sm_delete" value="Delete Category"
				onclick="return confirm('Are you sure?');"></div>
			<?php
				if (!empty($message)) {
					echo $message;
				}
			?>
  	</fieldset>
  </form>
</div><!--end content-->
<?php include('../include/footer.uc.php'); ?>
