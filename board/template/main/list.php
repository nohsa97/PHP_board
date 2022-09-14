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
                    include_once 'list_form.php';
                ?>  

         </table>
        <!-- 페이징 -->
        <? include_once '../include/paging.php'; ?>   
         
         <input class="button" type="button" value="글쓰기" onclick=goWrite()>        

         <!-- 검색폼 -->
        <? include_once 'list_bottom.php' ?>
     
        </div>
   
    </div>    

</body>

<script>
    function goWrite() {
           location.href="../content/write.php";
    }            

</script>
</html>