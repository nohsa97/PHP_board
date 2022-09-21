<?
    include_once "../include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if (!$mysqlDB) {
        echo "DB Connect Failed";
        exit;
    }

    $board_MAX = 10;
    $board_list = array();
    $board_number = 0;

    $search_idx = $_GET['search_index']; // 찾는 것의 column 
    if(!$search_idx) { // 찾는 값이 없을 경우 (대표적으로 메인페이지)
              
            $listnum = getCount_table( $mysqlDB, 'board');
            if( (int)$listnum % 10 == 0 ){
                $listnum = (int)($listnum / 10);
                $listnum--;
            }
            else{
                $listnum = (int)($listnum / 10);
            }  //10자리 끊기

 
    
            for( $i = 0; $i <= $listnum; $i++) {
                $board_list[$i] = $i + 1;
            }

            $current = $_GET['board_number'];

            echo "<div>";
            echo " < ";
            foreach( $board_list as $number){
                if ($current == ( $number - 1)) {
                    echo "<span class='search_form'> ".$number."</span> ";
                }
                else {
                    echo "<a href='list.php?board_number=".( $number - 1)."' class='search_form'>";
                    echo " ".$number." ";
                    echo "</a>";
                }
                    
            }
            
            echo " > <br>";
            echo "</div>";
    }
    else if( $search_idx ) { //찾는 값이 존재할 경우.
        $search_for = $_GET['search_for']; //찾을것

        $listnum = selectSQL_option( $mysqlDB, 'board', $search_idx, $search_for, null, true);
      
            $listnum = (int)($listnum / 10);

            for( $i = 0; $i <= $listnum; $i++) {
                $board_list[$i] = $i + 1;
            }

            $current = $_GET['board_number'];

            echo "<div>";
            echo " < ";
            foreach( $board_list as $number){
                if( $current == ( $number - 1) ){
                    echo "<span class='search_form'> ".$number."</span> ";
                }
                else {
                    echo "<a href='list_search.php?board_number=".( $number - 1)."&search_index=".$search_idx."&search_for=".$search_for."' class='search_form'>";
                    echo " ".$number." ";
                    echo "</a>";
                }
                    
            }
            
            echo " > <br>";
            echo "</div>";
    }
?>