<?
 $sql = "
 SELECT B.number, B.b_number , C.c_number , C.writer , C.body , C.number, C.permission
 FROM comment as B 
 JOIN reply as C
 WHERE B.number = C.c_number AND B.number = ".$row['number']."
 ";
 $result2  = mysqli_query( $mysqlDB, $sql );
 
 while( ( $row = mysqli_fetch_assoc( $result2 ) ) ) 
        access_content( $row, 'reply', $number );
?>