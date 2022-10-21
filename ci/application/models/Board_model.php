<? 
defined('BASEPATH') OR exit('No');

class Board_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();    
  }


  public function get_board_list($limit, $start)
  {
    $this->db->select('b_seq, subject, writer, date, visited, permission, comment_count');
    $this->db->order_by('b_seq', 'DESC');
    $result = $this->db->get('board', $limit, $start)->result_array();
    return $result;
  }

  public function get_board_count()
  {
    return $this->db->count_all('board');
  }

  public function get_content_search($limit, $start)
  {
    return $this->db->like($GLOBALS['search_by'], $GLOBALS['search_input'])->order_by('b_seq', 'DESC')->get('board', $limit, $start)->result_array();
  }


  public function get_count_search($search_by, $search_input)
  {
    $this->db->from('board');
    $this->db->like($search_by, $search_input);
    $max = $this->db->count_all_results();
    return $max;
  }

  public function get_content($b_seq)
  {
    return $this->db->get_where('board', array('b_seq' => $b_seq))->row_array();
  }


  public function get_content_count_comment($b_seq, $count)
  {
    $this->db->update('board', array('comment_count' => $count),  array('b_seq' => $b_seq));
    return $this->db->get_where('board', array('b_seq' => $b_seq))->row_array();
  }

  public function visited_update($b_seq)
  {
    $result = $this->db->get_where('board', array('b_seq' => $b_seq))->row_array();

    $data = array(
      'visited' => $result['visited'] + 1  
    );

    $where = array(
      'b_seq' => $b_seq
    );
    $this->db->update('board', $data, $where);
    return 0;
  }


  public function insert_board($array)
  {
    $this->db->insert('board', $array);
    return $this->db->insert_id();
  }


  public function remove_board($b_seq)
  {
    return $this->db->delete('board', array('b_seq' => $b_seq));
  }


  public function update_board($array)
  {
    $where = array(
    'b_seq' => $array['b_seq']  
    );
    $this->db->update('board', $array, $where);
    return 1;
  }


  public function pre_next_content($b_seq)
  {
    $pre  = $this->db->query("SELECT b_seq, subject FROM board WHERE b_seq < $b_seq ORDER BY b_seq DESC LIMIT 1;")->row_array();
    $next = $this->db->query("SELECT b_seq, subject FROM board WHERE b_seq > $b_seq ORDER BY b_seq ASC LIMIT 1;")->row_array();
    $result = array(
      'pre'  => $pre,
      'next' => $next
    );
    return $result;
  }

  public function pre_next_content_search($b_seq, $input_array)
  {
    $search_by    = $input_array['search_by'];
    $search_input = $input_array['search_input'];
    $pre  = $this->db->query("SELECT b_seq, subject FROM board WHERE $search_by LIKE '%$search_input%' AND b_seq < $b_seq ORDER BY b_seq DESC LIMIT 1;")->row_array();
    $next = $this->db->query("SELECT b_seq, subject FROM board WHERE $search_by LIKE '%$search_input%' AND b_seq > $b_seq ORDER BY b_seq ASC LIMIT 1;")->row_array();
    $result = array(
      'pre'  => $pre,
      'next' => $next
    );
    return $result;
  }

}

?>