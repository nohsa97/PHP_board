<?
 session_start();
 $userID = $_SESSION['userID'];
 $userPass = $_SESSION['userPass'];
?>
<script  src = "http://code.jquery.com/jquery-latest.min.js"></script>

<?
    if( $userID ) {
        echo  ' 
            <div class="nav">
                <a href="../main/list.php?board_number=0">UCERT 자유게시판</a>
                <span class="text-basic"> ',$userID,'님 환영합니다!</span>
                <input class="logout button" type="button" value="로그아웃">
            </div>
        ';
        echo '
        <script>
            $(".logout").on("click",function(){
            if (!confirm("로그아웃 하시겠습니까?")) {
                    // 취소(아니오) 버튼 클릭 시 이벤트
                } else {
                    alert("로그아웃 되었습니다.");
                    location.href = "../../login/login.php";
                }
            });
        </script>
        ';
    }
      
    else {
        echo '
            <div class="nav">
                <a href="../main/list.php?board_number=0">UCERT 자유게시판</a>
                <input class="logout button" type="button" value="로그인">
            </div>
        ';

        echo '
        <script>
            $(".logout").on("click",function(){
            if (!confirm("로그인 하시겠습니까?")) {
                    // 취소(아니오) 버튼 클릭 시 이벤트
                } else {
                    location.href = "../../login/login.php";
                }
            });
        </script>
        ';

    }

?>