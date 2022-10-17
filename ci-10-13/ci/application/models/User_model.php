<?
    class  User_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();    
        }

        public function check($input_arr)
        {
            $result = $this->db->get_where('user', $input_arr)->result_array();  
            return $result;
        }

        public function get_AFK($ID)
        {
            $arr_ID = array(
                'ID' => $ID
            );
            return $this->db->select('AFK')->get_where('user', $arr_ID)->result_array();
        }


        public function insert_user($input_arr)
        {
            $data = array(
                'AFK' => null,
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
            return $this->db->select('ID')->get_where("user", $input_arr)->result_array();
        }
    }

    //sha256 + user_seq 
?>
