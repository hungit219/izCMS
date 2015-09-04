<?php
//Xac dinh hang so cho dia chi tuyet doi
define("BASE_URL", 'http://localhost/demo/');

//Kiem tra xem ket qua tra ve co dung khong?
function confirm_query($result, $query)
{
    global $conn;
    if (!$result) {
        die("Query {$query}<br />MySQL Error: " . mysqli_error($conn));
    }
}

//Tai dinh huong nguoi dung
function redirect_to($page = 'user/index.php')
{
    $url = BASE_URL . $page;
    header("Location: {$url}");
    exit();
}

function the_excerpt($text)
{
    $sanitized = htmlentities($text, ENT_COMPAT, 'utf-8');
    if (strlen($sanitized) > 400) {
        $cut_str = substr($sanitized, 0, 400);
        $words = substr($sanitized, 0, strrpos($cut_str, ' '));
        return $words;
    } else {
        return $sanitized;
    }
}

function validate_id($id)
{
    if (isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $val_id = $id;
        return $val_id;
    } else {
        return NULL;
    }
}

function the_content($text)
{
    $sanitized = htmlentities($text, ENT_COMPAT, 'utf-8');
    return str_replace(array("\r\n", "\n"), array("<p>", "</p>"), $sanitized);
}

function captcha(){
    $qna = array(
        1 => array('question'=>'1 + 1 = ', 'answer'=>2),
        2 => array('question'=>'3 - 2 = ', 'answer'=>1),
        3 => array('question'=>'3 * 5 = ', 'answer'=>15),
        4 => array('question'=>'6 / 2 = ', 'answer'=>3),
        5 => array('question'=>'nang bach tuyet va ... chu lun', 'answer'=>7),
        6 => array('question'=>'alibaba va ... ten cuop', 'answer'=>40),
        7 => array('question'=>'an mot qua khe tra ... cuc vang', 'answer'=>1),
        8 => array('question'=>'may tui ... gang, mang di ma dung', 'answer'=>3)
        );
    $random_key = array_rand($qna);
    $_SESSION['q'] = $qna[$random_key];
    return $question = $qna[$random_key]['question'];
}

?>








