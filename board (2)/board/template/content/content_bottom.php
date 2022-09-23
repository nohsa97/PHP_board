<?
    $board_number = $_GET['board_number'];
    $sql2 = bottom_min( $mysqlDB, 'board', 'number', $number );
    $result = mysqli_query( $mysqlDB, $sql2 );
    $row = mysqli_fetch_assoc( $result );  // 바로 아랫값

    $sql2 = bottom_max( $mysqlDB, 'board', 'number', $number );
    $result = mysqli_query( $mysqlDB, $sql2 );
    $row2 = mysqli_fetch_assoc( $result );  // 바로 윗


    //검색해서 왔을경우.
    $search_idx = $_GET['search_index'];
    $search_for = $_GET['search_for'];

    if( $row == "" )
    {
        echo "
            <div class='content_bottom'>
                <p>이전 게시글 <a href='content.php?number=",$row2['number'],"&board_number=",$board_number,"&search_index=",$search_idx,"&search_for=",$search_for,"'>",$row2['subject'],"</a> </p>
            </div>
            ";
    }

    else if ( $row2 == '' ) 
    {
        echo "
            <div class='content_bottom'>
                다음 게시글 <a href='content.php?number=",$row['number'],"&board_number=",$board_number,"&search_index=",$search_idx,"&search_for=",$search_for,"'>",$row['subject'],"</a> 
            </div>
            ";
    }
    
    else 
    {
        echo 
        "
        <div class='content_bottom'>
            다음 게시글 <a href='content.php?number=",$row['number'],"&board_number=",$board_number,"&search_index=",$search_idx,"&search_for=",$search_for,"''>",$row['subject'],"</a> 
            ";                    
        echo"
            <p>이전 게시글 <a href='content.php?number=",$row2['number'],"&board_number=",$board_number,"&search_index=",$search_idx,"&search_for=",$search_for,"'>",$row2['subject'],"</a> </p>
        </div>
        ";
    }
?>