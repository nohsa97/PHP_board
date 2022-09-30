<?
 session_start();
 $userID = $_SESSION['userID'];
 $userPass = $_SESSION['userPass'];
?>
<script  src = "http://code.jquery.com/jquery-latest.min.js"></script>

<?
    echo  ' 
        <div class="nav">
            <a href="../main/list.php?list_seq=0">UCERT 자유게시판</a>';

    if($userID)
    {
        echo '
            <span class="text-basic"> ',$userID,'님 환영합니다!</span>
            <button class="logout button" type="button" onclick="loginBtn()" data-value="로그아웃">로그아웃</button>
        </div>';
    }
    else
    {
        echo'
            <button class="logout button" type="button" onclick="loginBtn()" data-value="로그인">로그인</button>
        </div>
        ';
    }
?>

