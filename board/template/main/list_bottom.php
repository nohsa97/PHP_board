<?
    $search_idx = $_GET['search_index'];
    $search_for = $_GET['search_for'];



    if( $search_idx == 'writer' ){ //작성자만 있는 경우
        echo '  
        <form action="list_search.php" method="get">
            <select name="search_index" id="" style="width:100px;">
                <option value="writer" selected>작성자</option>
                <option value="subject">제목</option>
            </select>';
    }
    else if( $search_idx == 'subject'){ // 제목만 있는경우
        echo '
        <form action="list_search.php" method="get">
            <select name="search_index" id="" style="width:100px;">
                <option value="writer">작성자</option>
                <option value="subject" selected>제목</option>
            </select>';
    }

    else{ //기본
        echo '
        <form action="list_search.php?list_seq=0" method="get">
            <select name="search_index" id="" style="width:100px;">
                <option value="writer">작성자</option>
                <option value="subject">제목</option>
            </select>';
    }
    echo '  
            <input class="search_box" style="width:200px; margin:15px;"type="search" name="search_for" value="',$search_for,'" placeholder="검색">
            <input type="submit" style="width:50px;" value="검색">
            <input type="hidden" name="b_seq" value="0">
            <input type="hidden" name="list_seq" value="0">
        </form>
'   
;  

?>