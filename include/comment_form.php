<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $errors = array();
    //Validate name
    if (!empty($_POST['name'])){
        $name = mysqli_real_escape_string($conn, strip_tags($_POST['name']));
    } else {
        $errors[]="name";
    }

    //Validate email
    if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
    } else {
        $errors[]="email";
    }

    //Validate comment
    if (!empty($_POST['comment'])){
        $comment = mysqli_real_escape_string($conn, strip_tags($_POST['comment']));
    } else {
        $errors[]="comment";
    }

    //Validate captcha question
    if (!empty($_POST['captcha']) && trim($_POST['captcha'])!=$_SESSION['q']['answer']){
        $errors[]="captcha";
    }

    //Validete captcha css
    if(!empty($_POST['url'])){
        redirect_to("thankyou.html");
        exit;
    }

    if (empty($errors)){
        //Neu khong co loi xay ra thi them comment vao csdl
        $q = "INSERT INTO comment (pages_id,author,email,comment,comment_date) VALUES ({$pid},'{$name}','{$email}','{$comment}',NOW())";
        $r = mysqli_query($conn, $q);
        confirm_query($q, $r);
        if (mysqli_affected_rows($conn)==1){
            //Success
            $msg = "<p class='success'>Thank you for your comment</p>";
        } else { //No match vas ,ade
            //Neu co loi say ra do nguoi dung nhap thieu thong tin
            $msg = "<p class='warning'>Your comment could not be posted due
                to a system error.</p>";
        }
    }
}
?>

<?php //Hien thi comment tu csdl
    $q = "SELECT author, email, comment, DATE_FORMAT(comment_date,'%b %d %y') as 'date' FROM comment
      WHERE pages_id={$pid} ORDER BY 'date' ASC";
    $r = mysqli_query($conn,$q);
    confirm_query($r,$q);
    if(mysqli_num_rows($r)>0){
        echo "<ol class='disscuss'>";
        while (list($author, $comment, $date)=mysqli_fetch_array($r,MYSQLI_NUM)){
            echo "<li>";
            echo "<p class='author'>{$author}</p>";
            echo "<p class='comment-sec'>{$comment}</p>";
            echo "<p class='date'>{$date}";
            echo "</li>";
        }
        echo "</ol>";
    } else {
        echo "<h2>Be the first to leave a comment.</h2>";
    }
?>

<form id="comment-form" action="" method="post">
    <fieldset>
        <legend>Leave a comment</legend>
        <div>
            <label for="name">Name: <span class="required">*</span>
                <?php
                    if(isset($errors) && in_array('name',$errors)){
                        echo "<span class='warning'>Please enter your name</span>";
                    }
                ?>
            </label>
            <input type="text" name="name" id="name" value="" size="20" maxlength="80" tabindex="1"/>
        </div>
        <div>
            <label for="email">Email: <span class="required">*</span>
                <?php
                if(isset($errors) && in_array('email',$errors)){
                    echo "<span class='warning'>Please enter your email</span>";
                }
                ?>
            </label>
            <input type="text" name="email" id="email" value="" size="20" maxlength="80" tabindex="2"/>
        </div>
        <div>
            <label for="comment">Your Comment: <span class="required">*</span>
                <?php
                if(isset($errors) && in_array('comment',$errors)){
                    echo "<span class='warning'>Please enter your comment</span>";
                }
                ?>
            </label>
            <div id="comment"><textarea name="comment" rows="10" cols="50" tabindex="3"></textarea></div>
        </div>

        <div>
            <label for="captcha">Nhập giá trị số cho câu hỏi sau:<?php
                    echo captcha();
                ?><span class="required">*</span>
                <?php
                if(isset($errors) && in_array('captcha',$errors)){
                    echo "<span class='warning'>Please give a correct answer</span>";
                }
                ?>
            </label>
            <input type="text" name="captcha" id="captcha" value="" size="20" maxlength="5" tabindex="4"/>
        </div>

        <div class="website">
            <label for="webside">Nếu bạn nhìn thấy trường này, thì ĐỪNG điền gì vô hết</label>
            <input type="text" name="url" id="url" value="" size="20" maxlength="20"/>
        </div>
        <?php
        if (isset($msg)){
            echo $msg;
        }
        ?>
    </fieldset>
    <div><input type="submit" name="submit" value="Post Comment"/></div>
</form>