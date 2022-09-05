<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="nav">
        UCERT 자유게시판 
    </div>


    <div class="board_list">
        <div class="subject">
         <table>
            <tr>
                
                <th class="board_number">번호</th>
                <th class="board_subject">제목</th>
                <th class="board_writer">작성자</th>
                <th class="board_writeDate">작성일자</th>
            </tr>

              
            
                <?php 
                    $mysqlDB = new mysqli('localhost', 'root', 'clzls123', 'test_board');
                    if ($mysqli->connect_errno)
                    {
                        echo 'mysql error';
                    }
                    else //db에 저장된 내용들이 있다면 해당 내용을 출력합니다. 
                    {
                    
                        $sql = "select * FROM board";
                        $result = mysqli_query($mysqlDB,$sql);
                        if($result){
                            $listnum = 1;
                            while($row=mysqli_fetch_assoc($result)) {  //게시글 보내면서 게시글 번호를 전달하기 
                                echo "
                                    
                                    <tr class='content'>
                                        <td class='board_number'>",$listnum,"</td>
                                        <td class='board_subject'>","<a href='content.php?number=",$row['number'],"'>",$row['subject'],"</a>","</td> 
                                        <td class='board_writer'>",$row['writer'],"</td>
                                        <td class='board_writeDate'>",$row['date'],"</dh>
                                    </tr>
                                   
                                    ";
                                    $listnum++;
                            }
                        }

                    }
                
                    mysqli_close($mysqlDB);
                ?>

            

         </table>
         <!-- 글쓰기 페이지로 이동 -->
         <input class="button" type="button" value="글쓰기" onclick=goWrite()>
        </div>
       

        <script>
            function goWrite() {
                       location.href="write.php";
                    }            
        </script>
    </div>    

</body>
</html>