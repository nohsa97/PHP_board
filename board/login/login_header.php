<?php
  session_start();
  if( isset( $_SESSION[ 'username' ] ) ) {
    $jb_login = TRUE;
  }
?>

<div class="nav">
    <a href="login.php">UCERT</a>
</div>