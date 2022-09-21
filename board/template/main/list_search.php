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
        include_once "../include/header.php";
    ?>


    <div class="board_list">
        <div class="subject">
         <table>                  
                <?                              
                    include_once 'list_form.php';
                ?>
         </table>
         
              <? include_once 'paging.php'; ?>   
         
         <input class = "button" type = "button" value = "글쓰기" onclick = goWrite()>

         <!-- 검색폼 -->
         <? include_once 'list_bottom.php' ?>
     

         
        </div>

       
    </div>    

</body>
   <script src = "../../js/basic.js"> </script>            

</html>