<?
 $sql = "
 SELECT B.comment_number, B.number , C.comment_number , C.writer , C.reply_comment , C.reply_number 
 FROM comment as B 
 JOIN reply as C
 WHERE B.comment_number = C.comment_number AND B.comment_number = ".$row['comment_number']."
 ";

 $result2  = mysqli_query( $mysqlDB, $sql );
 
 while( ( $row = mysqli_fetch_assoc( $result2 ) ) ) {
    access_content( $row, 'reply', $number );
  }
?>