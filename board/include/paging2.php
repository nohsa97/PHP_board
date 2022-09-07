<?
       include_once "./include/dbConnection.php";
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
       echo "<div>";
       echo " < ";
       foreach($board_list as $number){
          
            echo "<a href='list_search.php?board_number=".($number-1)."?search_index=".$search."&search_for=".$ser."'>";
            echo " ".$number." ";
            echo "</a>";
       }
       echo " > <br>";
       echo "</div>";
?>
<!-- <a href='list_test.php?board_number=1'>1</a> -->