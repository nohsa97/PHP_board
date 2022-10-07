<?
    class  User_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();    
        }

        public function check_user($input_arr)
        {
            $result = $this->db->get_where('user',$input_arr)->result_array();
            
            return $result;
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
            return $result;
        }
    }
?>