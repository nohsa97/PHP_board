<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  function alert($VAR) //얼랏으로만
  {
    echo "
    <script>
        alert('$VAR');
    </script>";
  }

  function location_href($VAR)
  {
    echo "
    <script>
        location.href = '$VAR';
    </script>";
  }

  function history_back()
  {
    echo "
    <script>
        history.back();
    </script>";
  }
  function history_go($VAR)
  {
    echo "
    <script>
        history.go($VAR);
    </script>";
  }
?>
