<?
    include_once "../include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if (!$mysqlDB) {
        echo "DB Connect Failed";
        exit;
    }

    $board_MAX = 10;
    $listnum = getCount_table($mysqlDB, 'board');
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