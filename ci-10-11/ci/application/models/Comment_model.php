<?
    defined('BASEPATH') OR exit('No');
    class Comment_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();

        }

        public function insert_comment($data)
        {
            $this->db->insert('comment_test', $data);
            return 0;
        }

        public function get_list($b_seq)
        {
            $this->db->select('b.b_seq, c.b_seq, c.c_seq, c.writer, c.body');
            $this->db->from('board as b');
            $this->db->join('comment_test as c', 'b.b_seq = '.$b_seq.' AND b.b_seq = c.b_seq');
            $result = $this->db->get()->result_array();
            return $result;
        }

        public function get_comment($c_seq)
        {
            $result = $this->db->get_where('comment_test', array('c_seq' => $c_seq))->result_array();
            return $result;
        }

        public function remove_comment($input_arr)
        {
           $data =  $this->db->get_where('comment_test', array('c_seq' => $input_arr['c_seq']))->result_array();
           $row = $data[0];
           if ($row['password'] == $input_arr['password'])
           {
            $this->db->where('c_seq', $input_arr['c_seq']);
            $this->db->delete("comment_test");
            return 1;
           }
           
           else
           {
                return 0;
           }
        }


        public function update_act($input_arr)
        {
            $where = array(
                'c_seq' => $input_arr['c_seq']  
              );
              $this->db->update('comment_test', $input_arr, $where);
              return 0;
        }

    }

?>
