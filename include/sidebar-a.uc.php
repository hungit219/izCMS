<div id="content-container">
    <div id="section-navigation">
     <ul class="navi">
       <?php
       //Cau lenh truy xuat categories
        $q = "SELECT name,cat_id, position FROM categories ORDER BY position ASC";
        $r = mysqli_query($conn,$q);
        confirm_query($q,$r);
        //Lay cats tu database
        while ($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
          echo "<li><a href='index.php?cid={$cats["cat_id"]}'";
          if (isset($_GET['cid']) && $cats['cat_id']==$_GET['cid'] &&
            filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('minrange'=>1))){
              echo "class = 'selected'";
          }
          echo ">".$cats['name']."</a>";
            //Cau lenh truy xuat pages
            $q1 = "SELECT name, pages_id FROM pages WHERE cat_id={$cats['cat_id']} ORDER BY position ASC";
            $r1 = mysqli_query($conn,$q1);
            confirm_query($q1,$r1);
            //Lay pages tu database
            echo "<ul class='pages'>";
            while ($pages = mysqli_fetch_array($r1,MYSQLI_ASSOC)) {
              echo "<li><a href='index.php?pid={$pages["pages_id"]}'";
              if (isset($_GET['pid']) && $pages['pages_id']==$_GET['pid'] &&
                filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('minrange'=>1))){
                  echo "class = 'selected'";
              }
              echo ">".$pages['name']."</a></li>";
            }//End WHILE pages
            echo "</ul>";
          echo "<li>";
        }//End WHILE cats
       ?>
     </ul>
</div><!--end section-navigation-->
