<?
   echo '
        <form action="list_search.php" method="get">
            <select name="search_index" id="" style="width:100px;">
                <option value="writer">작성자</option>
                <option value="subject">제목</option>
            </select>
            
            <input class="search_box" style="width:200px; margin:15px;"type="text" name="search_for" value="" placeholder="검색" >
            <input type="submit" style="width:50px;" value="검색">
        </form>
'   
;  

?>