<link rel="stylesheet" href="../../css/style.css">

<?
    include_once '../include/dbConnection.php';
    include_once '../include/session.php';
?>

<?
$list_seq = $_GET['list_seq'];
$b_seq = $_GET['b_seq'];
$c_seq = $_GET['c_seq'];


    if(!$userID) 
    { //세션에 로그인아디가 없을경우
        echo '
        <form class="comment_input" action="comment_action.php" method="post"> 
                    <input type="text" name="writer" required  class="write_name" placeholder="작성자">
                    <input type="password" name="password" required class="write_name" placeholder="비밀번호">
                    <input class="button" type="submit" value="댓글쓰기">
                    <input type="hidden" name="type" value="reply_write">
                    <input type="hidden" name="list_seq" value="',$list_seq,'">
                    <input type="hidden" name="b_seq" value="',$b_seq,'">
                    <input type="hidden" name="c_seq" value="',$c_seq,'">
                    <p><input type="text" name="body" required size="50px" class="write_subject" placeholder="댓글 입력해주세요."></p>
        </form>
        ';
    }
    else 
    {
        echo '
        <form class="comment_input user" action="comment_action.php" method="post"> 
                    <p class="write_name">',$userID,'</p>
                    <input class="button" type="submit" value="댓글쓰기" style="margin-top : 0px !important;">
                    <input type="hidden" name="type" value="reply_write">

                    <input type="hidden" name="writer" value="',$userID,'">
                    <input type="hidden" name="list_seq" value="',$list_seq,'">
                    <input type="hidden" name="b_seq" value="',$b_seq,'">
                    <input type="hidden" name="c_seq" value="',$c_seq,'">
                    <p><input type="text" name="body" required size="50px" class="write_subject" placeholder="댓글 입력해주세요."></p>
        </form>
        ';
    }
?>


<!-- 700 *  180 -->