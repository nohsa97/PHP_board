<? 
    defined('BASEPATH') OR exit('No');

    class Board_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();    
        }
        

        public function get_lists($limit, $start)
        {
            $this->db->select('b_seq, subject, writer, date, visited');
            $this->db->order_by('b_seq', 'DESC');
            $result = $this->db->get('board', $limit, $start)->result_array();
            return $result;
        }

        public function get_MAX()
        {
            $max = $this->db->count_all('board');
            return $max;

        }

        public function get_content($b_seq)
        {
            $result = $this->db->get_where('board', array('b_seq' => $b_seq))->result_array();
            return $result;
        }

        public function get_comment($b_seq)
        {
            $this->db->select('b.b_seq, c.b_seq, c.c_seq, c.writer, c.body');
            $this->db->from('board as b');
            $this->db->join('comment_test as c','b.b_seq = '.$b_seq.' AND b.b_seq = c.b_seq');
            $result = $this->db->get()->result_array();
            return $result;
        }

        public function insert_board($array)
        {
            $this->db->insert('board', $array);
            return 0;
        }

        public function remove_board($input_arr)
        {
           $data =  $this->db->get_where('board', array('b_seq' => $input_arr['b_seq']))->result_array();
           $row = $data[0];
           if ($row['password'] == $input_arr['password'])
           {
            $this->db->where('b_seq', $input_arr['b_seq']);
            $this->db->delete("board");
            return 1;
           }
           
           else
           {
                return 0;
           }
            
        }

    }

?>