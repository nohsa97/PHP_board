<?
    $list_seq = $_GET['list_seq'];
    $b_seq = $_GET['b_seq'];


    $result = bottom_func($mysqlDB, 'board', 'b_seq', $b_seq, 0);
    $row = mysqli_fetch_assoc( $result );  // 이전게시글

    $result = bottom_func($mysqlDB, 'board', 'b_seq', $b_seq, 1);
    $row2 = mysqli_fetch_assoc( $result );  // 다음게시글


    //검색해서 왔을경우.
    $search_idx = $_GET['search_index'];
    $search_for = $_GET['search_for'];

    if( $row == "" )
    {
        echo "
            <div class='content_bottom'>
                <p>이전 게시글 <a href='content.php?b_seq=",$row2['b_seq'],"&list_seq=",$list_seq,"&search_index=",$search_idx,"&search_for=",$search_for,"'>",$row2['subject'],"</a> </p>
            </div>
            ";
    }

    else if ( $row2 == '' ) 
    {
        echo "
            <div class='content_bottom'>
                다음 게시글 <a href='content.php?b_seq=",$row['b_seq'],"&list_seq=",$list_seq,"&search_index=",$search_idx,"&search_for=",$search_for,"'>",$row['subject'],"</a> 
            </div>
            ";
    }
    
    else 
    {
        echo 
        "
        <div class='content_bottom'>
            다음 게시글 <a href='content.php?b_seq=",$row['b_seq'],"&list_seq=",$list_seq,"&search_index=",$search_idx,"&search_for=",$search_for,"''>",$row['subject'],"</a> 
            ";                    
        echo"
            <p>이전 게시글 <a href='content.php?b_seq=",$row2['b_seq'],"&list_seq=",$list_seq,"&search_index=",$search_idx,"&search_for=",$search_for,"'>",$row2['subject'],"</a> </p>
        </div>
        ";
    }
?>