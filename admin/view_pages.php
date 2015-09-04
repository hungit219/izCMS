<?php include('../include/header.uc.php'); ?>
<?php include('../include/sidebar-admin.uc.php'); ?>
<?php include('../include/mysqli_connect.php'); ?>
<?php include('../include/function.php'); ?>
<div id="content">
	<h2>Manage Pages</h2>
    <table>
    	<thead>
    		<tr>
    			<th><a href="view_pages.php?sort=page">Pages</a></th>
    			<th><a href="view_pages.php?sort=on">Posted on</th>
    			<th><a href="view_pages.php?sort=by">Posted by</th>
          <th>Content</th>
          <th>Edit</th>
          <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
        <?php
          //Sap xep theo thu thu table head
          if(isset($_GET['sort'])){
            switch ($_GET['sort']) {
              case 'page':
                $order_by = 'name';
                break;
              case 'on':
                $order_by = 'date';
                break;
              case 'by':
                $order_by = 'fullname';
                break;
              default:
                $order_by = 'date';
                break;
            }
          } else {
            $order_by = 'date';
          }

          //Truy xuat db de hien thi categories
          $q = "SELECT p.pages_id, p.name, DATE_FORMAT(p.post_on,'%b %d %Y') AS 'date',
                  CONCAT_WS(' ', first_name, last_name) AS fullname, p.content,
                  CONCAT_WS(' ',first_name, last_name) as 'fullname'
                FROM pages as p
                JOIN users as u USING(user_id)
                ORDER BY {$order_by} ASC";
          $r = mysqli_query($conn, $q);
            confirm_query($r, $q);
          if (mysqli_num_rows($r)>0){  //Neu co page thi hien thi page ra browser
            while ($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
							$content = the_excerpt($pages['content']);
              echo "
                <tr>
                    <td>{$pages['name']}</td>
                    <td>{$pages['date']}</td>
                    <td>{$pages['fullname']}</td>
                    <td>{$content}</td>
                    <td><a class='edit' href='edit_page.php?pid={$pages["pages_id"]}'>Edit</a></td>
                    <td><a class='delete' href='delete_page.php?pid={$pages["pages_id"]}&pname={$pages["name"]}'>Delete</a></td>
                </tr>
              ";
            }
        } else {  //Neu khong co page thi bao loi hoac bao user tao page
          $message = "<p class='warning'>There is currently no page to display.<br />
            Please create a page first.</p>";
        }
        ?>
    	</tbody>
    </table>
</div><!--end content-->
<?php include('../include/sidebar-b.uc.php'); ?>
<?php include('../include/footer.uc.php'); ?>
