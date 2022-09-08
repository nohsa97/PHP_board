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
                        $search = $_GET['search_for'];
                        $ser =$_GET['search_index'];
                        // echo $ser;
                        // exit;
                        $board_number = $_GET['board_number'];
                        $start = $board_number*10;
                        $limit = 10;
                        if($mysqlDB){
                            $sql = selectSQL_option($mysqlDB,'board',$ser,$search,1);

                            $result = mysqli_query($mysqlDB,$sql);
                  
                            while($row=mysqli_fetch_assoc($result)) {  //게시글 보내면서 게시글 번호를 전달하기 
                                        echo "
                                            <tr class='content'>
                                                <td class='board_number'>",$row['number'],"</td>
                                                <td class='board_subject'>","<a href='../content/content.php?number=",$row['number'],"'>",$row['subject'],"</a>","</td> 
                                                <td class='board_writer'>",$row['writer'],"</td>
                                                <td class='board_writeDate'>",$row['date'],"</dh>
                                            </tr>                                  
                                            ";
                                    }
                        }
                    mysqli_close($mysqlDB);
                ?>

            

         </table>
         <!-- 글쓰기 페이지로 이동 -->
         <?
                include_once "../include/dbConnection.php";
                $mysqlDB = mysqlConnect();
                if (!$mysqlDB) {
                    echo "DB Connect Failed";
                    exit;
                }

                
                $board_MAX = 10;
                $search = $_GET['search_for'];
                $ser =$_GET['search_index'];
                $listnum = selectSQL_option($mysqlDB,'board',$ser,$search,2);
                $listnum =(int)($listnum/10);

                $board_list = array();
                $board_number=0;

                for($i=0;$i<=$listnum;$i++) {
                    $board_list[$i] = $i+1;
                }
                $current = $_GET['board_number'];
                echo "<div>";
                echo " < ";
                foreach($board_list as $number){
                    if($current==($number-1)){
                        echo " ".$number." ";
                    }
                    else {
                        echo "<a href='list.php?board_number=".($number-1)."'>";
                        echo " ".$number." ";
                        echo "</a>";
                    }
                       
                }
                
                echo " > <br>";
                echo "</div>";
            ?>
         
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

<script>
    function goWrite() {
           location.href="../content/write.php";
    }            

</script>
</html>