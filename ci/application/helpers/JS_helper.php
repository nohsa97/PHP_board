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

  function paging_func($setting)
  {
    $paging = array();
    $paging['base_url']    = $setting['base_url'];
    $paging['total_rows']  = $setting['total_rows'];

    $paging['per_page']    = $setting['per_page'];
    $paging['uri_segment'] = $setting['uri_segment'];
    $paging['num_links']   = $setting['num_links'];
                                    
    $paging['full_tag_open']   = '<ul class="pagination" style="justify-content : center !important; " >';
    $paging['full_tag_close']  = '</ul>';
    $paging['num_tag_open']    = '<div class="page-link">';
    $paging['num_tag_close']   = '</div>';
    $paging['cur_tag_open']    = '<b class="page-link"">';
    $paging['cur_tag_close']   = '</b>';
    $paging['next_tag_open']   = '<div class="page-link">';
    $paging['next_tag_close']  = '</div>';
    $paging['prev_tag_open']   = '<div class="page-link">';
    $paging['prev_tag_close']  = '</div>';
    $paging['last_tag_open']   = '<div class="page-link">';
    $paging['last_tag_close']  = '</div>';
    $paging['first_tag_open']  = '<div class="page-link">';
    $paging['first_tag_close'] = '</div>';

    return $paging;
  }
?>
