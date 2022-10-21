<?
  class  User_model extends CI_Model
  {
    public function __construct()
    {
      parent::__construct();    
    }

    public function get_user($Array) //유저 정보 모든걸 가져옴 
    {
      return $this->db->get_where('user', $Array)->row_array();
    }

    public function get_user_Seq($ID)
    {
      $arr_ID = array(
        'ID' => $ID
      );
      return $this->db->select('user_seq')->get_where('user', $arr_ID)->row_array()['user_seq'];
    }


    public function insert_user($input_arr)
    {
      $data = array(
        'user_seq' => null,
        'ID' =>  $input_arr['ID'],
        'Password' =>  $input_arr['Password'],
        'Name' =>  $input_arr['Name'],
        'Email' =>  $input_arr['Email'],
        'Permission' =>  1,
      );
      $result = $this->db->insert('user', $data);
      $user_seq = $this->db->insert_id();
      $this->db->update("user", array('Password' => $input_arr['Password'].(string)$user_seq), array('ID' => $input_arr['ID']) );
      return $result;
    }

    public function update_user($input_arr)
    {
      return $this->db->update('user', array('Password' => $input_arr['Password']), array('ID' => $input_arr['ID']));
    }

    public function findPW($input_arr)
    {
      return $this->db->select('ID')->get_where("user", $input_arr)->row_array()['ID'];//row 
    }
  }
?>
