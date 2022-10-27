<?
  class  User_model extends CI_Model
  {
    public function __construct()
    {
      parent::__construct();    
      
    }

    public function get_user($Array)
    {
      return $this->db->get_where('user', $Array)->row_array();
    }

    public function insert_user($input_arr)
    {
      $data = array(
        'user_seq'   => null,
        'ID'         => $input_arr['ID'],
        'Password'   => $input_arr['Password'],
        'Name'       => $input_arr['Name'],
        'Email'      => $input_arr['Email'],
        'Permission' => 1,
      );
      $result = $this->db->insert('user', $data);
      $user_seq = $this->db->insert_id();
      $this->db->update("user", array('Password' => $input_arr['Password'].(string)$user_seq), array('ID' => $input_arr['ID']) );
      return $result;
    }

    public function update_user($input_arr)
    {
      $set = $input_arr['set'];
      return $this->db->update('user', array( $set => $input_arr[$set]), array('ID' => $input_arr['ID']));
    }

    public function findPW($input_arr)
    {
      $ID = $this->db->select('ID')->get_where("user", $input_arr)->row_array();
      if (isset($ID)) //값이 존재한다면/
      {
        $ID = $ID['ID'];
      }
      else
      {
        $ID = NULL;
      }
      return $ID;
    }

    public function withdrawal($ID)
    {
      return $this->db->delete('user', $ID);
    }
  }
?>
