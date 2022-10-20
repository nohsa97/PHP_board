<?
Class Board_search
{
  public function search()
  {
    if (isset($_GET['search_input']))
    {      
      $GLOBALS['search_by'] = $_GET['search_by'];
      $GLOBALS['search_input'] = $_GET['search_input'];
    }
    else
    {
      unset($GLOBALS['search_by'], $GLOBALS['search_input']);
    }
  }
}
?>