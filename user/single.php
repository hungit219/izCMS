<?php
include('../include/mysqli_connect.php');
include('../include/function.php');
$pid = validate_id($_GET['pid']);
if ($pid != NULL) {
    $q = "SELECT p.name, p.pages_id, p.content, ";
    $q .= "DATE_FORMAT(p.post_on, '%b %d %y') AS 'date', ";
    $q .= "CONCAT_WS(' ', u.first_name, u.last_name) AS 'fullname', u.user_id ";
    $q .= "FROM pages AS p ";
    $q .= "INNER JOIN users AS u ";
    $q .= "USING(user_id) ";
    $q .= "WHERE p.pages_id={$pid} ";
    $q .= "ORDER BY date ASC LIMIT 1";
    $r = mysqli_query($conn, $q);
    confirm_query($r, $q);
    $posts = array();
    if (mysqli_num_rows($r) > 0) {//Neu co post show ra browser
        $pages = mysqli_fetch_array($r, MYSQLI_ASSOC);
        $title = $pages['name'];
        $posts[] = array('name' => $pages['name'], 'content' => $pages['content'],
            'author' => $pages['fullname'], 'post_on' => $pages['date'], 'aid' => $pages['user_id']
        );
    } else {
        echo "<p>There are currently no post in this category.</p>";
    }
} else {
    redirect_to();
}
include('../include/header.uc.php');
include('../include/sidebar-a.uc.php');
?>
<div id="content">
    <?php
    foreach ($posts as $post) {
        echo "
        <div class='post'>
          <h2>{$post['name']}</h2>
          <p>" . the_content($post['content']) . "</p>
          <p class='meta'><strong>Posted by:</strong><a href='author.php?aid={$post["aid"]}'>{$post['author']}</a> |
            <strong>On: </strong>{$post['post_on']}</p>
        </div>
        ";
    }
    ?>
    <?php include('../include/comment_form.php'); ?>
</div><!--end content-->
<?php include('../include/sidebar-b.uc.php'); ?>
<?php include('../include/footer.uc.php'); ?>
