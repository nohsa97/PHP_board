<tr>        
                <th class="board_number">번호</th>
                <th class="board_subject">제목</th>
                <th class="board_writer">작성자</th>
                <th class="board_writeDate">작성일자</th>
</tr> 

<?
    $search_idx = $_GET['search_index'];
    $search_for = $_GET['search_for'];
    $board_number = $_GET['board_number'];
    

    $start = $board_number * 10;
    $limit = 10;

    if( $mysqlDB && !$search_for ){   //검색값이 존재하지 않을떄                        
        $listnum = getCount_table( $mysqlDB, 'board') - ( $start );
        
        $sql = selectSQL_reverse( $mysqlDB,'board', 'number', $start, $limit, false ); // dbConnection에 존재하는 함수.
        $result = mysqli_query( $mysqlDB , $sql );

        while( $row = mysqli_fetch_assoc( $result )) {  //게시글 보내면서 게시글 번호를 전달하기 
            echo "
                <tr class='content'>
                    <td class='board_number'>",$listnum,"</td>
                    <td class='board_subject'>","<a href='../content/content.php?number=",$row['number'],"&board_number=",$board_number,"'>",$row['subject'],"</a>","</td> 
                    <td class='board_writer'>",$row['writer'],"</td>
                    <td class='board_writeDate'>",$row['date'],"</dh>
                </tr>                                  
                ";
                $listnum--;
        }
}
else if( $mysqlDB && $search_for ){        //검색값이 존재할때
    $sql = selectSQL_option( $mysqlDB, 'board', $search_idx, $search_for, $start, false); //

    $result = mysqli_query( $mysqlDB, $sql );

        while( $row = mysqli_fetch_assoc( $result ) ) {  //게시글 보내면서 게시글 번호를 전달하기 
                    echo "
                        <tr class='content'>
                            <td class='board_number'>",$row['number'],"</td>
                            <td class='board_subject'>","<a href='../content/content.php?number=",$row['number'],"&board_number=",$board_number,"&search_index=",$search_idx,"&search_for=",$search_for,"'>",$row['subject'],"</a>","</td> 
                            <td class='board_writer'>",$row['writer'],"</td>
                            <td class='board_writeDate'>",$row['date'],"</dh>
                        </tr>                                  
                        ";
            }
}  

?>
