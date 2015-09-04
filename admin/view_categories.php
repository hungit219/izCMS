<?php include('../include/header.uc.php'); ?>
<?php include('../include/sidebar-admin.uc.php'); ?>
<?php include('../include/mysqli_connect.php'); ?>
<?php include('../include/function.php'); ?>
<div id="content">
	<h2>Manage Categories</h2>
    <table>
    	<thead>
    		<tr>
    			<th><a href="view_categories.php?sort=cat">Categories</a></th>
    			<th><a href="view_categories.php?sort=pos">Position</th>
    			<th><a href="view_categories.php?sort=by">Posted by</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
        <?php
          //Sap xep theo thu thu table head
          if(isset($_GET['sort'])){
            switch ($_GET['sort']) {
              case 'cat':
                $order_by = 'name';
                break;
              case 'pos':
                $order_by = 'position';
                break;
              case 'by':
                $order_by = 'fullname';
                break;
              default:
                $order_by = 'position';
                break;
            }
          } else {
            $order_by = 'position';
          }

          //Truy xuat db de hien thi categories
          $q = "SELECT c.cat_id, c.name, c.position, c.user_id,
                    CONCAT_WS(' ',first_name, last_name) as 'fullname'
                  FROM categories as c
                  JOIN users as u USING(user_id)
                  ORDER BY {$order_by} ASC";
          $r = mysqli_query($conn, $q);
            confirm_query($r, $q);
          while ($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo "
              <tr>
                  <td>{$cats['name']}</td>
                  <td>{$cats['position']}</td>
                  <td>{$cats['fullname']}</td>
                  <td><a class='edit' href='edit_category.php?cid={$cats["cat_id"]}'>Edit</a></td>
                  <td><a class='delete' href='delete_category.php?cid={$cats["cat_id"]}&cname={$cats["name"]}'>Delete</a></td>
              </tr>
            ";
          }
        ?>
    	</tbody>
    </table>
</div><!--end content-->
<?php include('../include/sidebar-b.uc.php'); ?>
<?php include('../include/footer.uc.php'); ?>
