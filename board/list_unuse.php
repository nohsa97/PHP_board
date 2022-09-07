<?
    include_once "./include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if(!$mysqlDB) {
        echo "<script>alert('DB연결 실패');</script>";
        exit;
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?
        include_once "./include/header.html";
    ?>


    <div class="board_list">
        <div class="subject">
         <table>
            <tr>        
                <th class="board_number">번호</th>
                <th class="board_subject">제목</th>
                <th class="board_writer">작성자</th>
                <th class="board_writeDate">작성일자</th>
            </tr>                      
                <?                                    
                        $sql = selectSQL_reverse($mysqlDB,'board','number'); // dbConnection에 존재하는 함수.
                        $result = mysqli_query($mysqlDB,$sql);
                        if($result){
                            $listnum = getCount_table($mysqlDB, 'board');
                            $paging_num = 1;
                            while($row=mysqli_fetch_assoc($result)) {  //게시글 보내면서 게시글 번호를 전달하기 
                                echo "
                                    <tr class='content'>
                                        <td class='board_number'>",$listnum,"</td>
                                        <td class='board_subject'>","<a href='content.php?number=",$row['number'],"'>",$row['subject'],"</a>","</td> 
                                        <td class='board_writer'>",$row['writer'],"</td>
                                        <td class='board_writeDate'>",$row['date'],"</dh>
                                    </tr>                                  
                                    ";
                                    $listnum--;
                                    $paging_num++;
                            }
                        }  
                    mysqli_close($mysqlDB);
                ?>

            

         </table>
         <!-- 글쓰기 페이지로 이동 -->
         <? include_once './include/paging.php';?>
         <input class="button" type="button" value="글쓰기" onclick=goWrite()>
        </div>
       
    </div>    

</body>

<script src="js/basic.js"></script>
</html>