<? 
defined('BASEPATH') OR exit('No');

class Api_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();    
  }

  public function save_data($array)
  {
    return $this->db->insert('ucert_openbank_token_info', $array);
  }


}
?>