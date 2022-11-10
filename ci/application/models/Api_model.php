<? 
defined('BASEPATH') OR exit('No');

class Api_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();    
  }

  public function insert_auth($array)
  {
    $this->db->insert('ucert_openbank_agreement_log', $array);
    return $this->db->insert_id(); // 얘를 보내는 이유는 이후 다시 user_seq_no를 수정하기 위해서 보냅니다.
  }

  public function save_token($array, $seq)
  {
    $this->db->update("ucert_openbank_agreement_log", array("user_seq_no" => $array['user_seq_no']), array("seq" => $seq));  // seq_no를 다시 설정합니다. 토큰 설정시 발급되기 때문입니다.
    return $this->db->insert('ucert_openbank_token_info', $array);
  }

  public function refreshing_token($array)
  {
    return $this->db->insert('ucert_openbank_token_info', $array);
  }

  public function get_token_info()
  {
    return $this->db->order_by('seq', 'DESC')->get('ucert_openbank_token_info', 1)->row_array();
  }

  public function get_account_list()
  {
    return $this->db->get('ucert_openbank_account_list')->result_array();
  }
  
  public function save_account($array)
  {
    return $this->db->insert('ucert_openbank_account_list', $array);
  }

  public function check_fintech_num($fintech_num)
  {
    return $this->db->where(array('fintech_use_num' => $fintech_num))->get('ucert_openbank_account_list')->row_array();
  }

  public function save_transaction_list($array)
  {
    return $this->db->insert('ucert_openbank_transaction_list', $array);
  }

  public function get_transaction_list($fintech) //마스킹된 계좌번호까지 넘기기
  {
    $this->db->select('trans.*, account.fintech_use_num, account.account_alias, account.account_num_masked');
    $this->db->from('ucert_openbank_transaction_list as trans');
    $this->db->join('ucert_openbank_account_list as account', 'trans.fintech_use_num = account.fintech_use_num');
    $this->db->where('trans.fintech_use_num',$fintech);
    $this->db->limit(5);
    return $this->db->get()->result_array();
  }
  
}
?>