<?php include('../include/header.uc.php'); ?>
<?php include('../include/sidebar-admin.uc.php'); ?>
<?php include('../include/mysqli_connect.php'); ?>
<?php include('../include/function.php'); ?>
<div id="content">
	<?php
		if (isset($_GET['pid']) && isset($_GET['pname']) &&
		filter_var($_GET['pid'],FILTER_VALIDATE_INT,array('min_range'=>1))) {
			$pid = $_GET['pid'];
			$pname = $_GET['pname'];
			//Neu cid va cname ton tai thi se xoa category khoi db
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if (isset($_POST['delete']) && ($_POST['delete']=='yes')) {
					$q = "DELETE FROM pages WHERE pages_id={$pid} LIMIT 1";
					$r = mysqli_query($conn, $q);
					confirm_query($r, $q);
					if (mysqli_affected_rows($conn)==1){
						//Bao cho nguoi dung biet xoa thanh cong
						$message = "<p class='success'>The page was deleted successfully.</p>";
					} else {
						$message = "<p class='warning'>The page was not deleted due to a system error.</p>";
					}
				} else { // Neu nguoi dung khong muon xoa
					$message = "<p class='warning'>I thought so too! shouldn't be deleted.</p>";
				}
			}
		} else {//Neu id hoac name khong ton tai thi tai dinh huong nguoi dung
			redirect_to('admin/view_pages.php');
		}
	?>
	<h2>Delete Pages: <?php
   if (isset($pname)) {
     echo htmlentities($pname, ENT_COMPAT, 'utf-8');
   }
  ?>
	</h2>
  <form action="" method="post">
  	<fieldset>
  		<legend>Delete Pages</legend>
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
