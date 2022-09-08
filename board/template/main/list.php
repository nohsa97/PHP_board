<?
    include_once "../include/dbConnection.php";
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
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <?
        include_once "../include/header.html";
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
                        $board_number = $_GET['board_number'];
                        $start = $board_number*10;
                        $limit = 10;
                        if($mysqlDB){                          
                            $listnum = getCount_table($mysqlDB, 'board')-($start);
                            $sql = selectSQL_reverse_test($mysqlDB,'board','number',$start,$limit); // dbConnection에 존재하는 함수.
                            $result = mysqli_query($mysqlDB,$sql);
                            while($row=mysqli_fetch_assoc($result)) {  //게시글 보내면서 게시글 번호를 전달하기 
                                echo "
                                    <tr class='content'>
                                        <td class='board_number'>",$listnum,"</td>
                                        <td class='board_subject'>","<a href='../content/content.php?number=",$row['number'],"'>",$row['subject'],"</a>","</td> 
                                        <td class='board_writer'>",$row['writer'],"</td>
                                        <td class='board_writeDate'>",$row['date'],"</dh>
                                    </tr>                                  
                                    ";
                                    $listnum--;
                            }
                        }  
                    mysqli_close($mysqlDB);
                ?>

            

         </table>
        <!-- 페이징 -->
        <? include_once '../include/paging.php'; ?>

            
         
         <input class="button" type="button" value="글쓰기" onclick=goWrite()>        

            <form action="list_search.php" method="get">
                <select name="search_index" id="" style='width:100px;'>
                    <option value="writer">작성자</option>
                    <option value="subject">제목</option>
                </select>
                <input class="search_box" style='width:200px; margin:15px;' type="text" name="search_for" value="" placeholder="검색" >
                <input type="submit" style='width:50px;' value="검색">
            </form>
     
        </div>
   
    </div>    

</body>

<!-- <script src="../../js/basic.js"></script> -->
<script>
    function goWrite() {
           location.href="../content/write.php";
    }            

</script>
</html>