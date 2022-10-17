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
            $parent_seq = $this->db->insert_id();
            $update_data = array(
                'parent_seq' => $parent_seq  
              );
            $where = array(
                'c_seq' => $parent_seq
            );
            $this->db->update('comment_test', $update_data, $where);

            return 0;
        }

        public function insert_reply($data, $parent_seq)
        {
            $old_sort = $data['sort'] - 1;
            $this->db->query('UPDATE comment_test SET baby = 1 WHERE c_seq = '.$parent_seq.' ;'); //빼도됨
            $this->db->query('UPDATE comment_test SET sort = sort + 1 WHERE sort > '.$old_sort.' ;');
            $this->db->insert('comment_test', $data);
            return 0;
        }


        public function get_list($b_seq) //댓글 출력 
        {
            $this->db->select('b.b_seq, c.b_seq, c.c_seq, c.writer, c.body, c.c_depth, c.baby, c.permission');
            $this->db->order_by('parent_seq', 'ASC');
            $this->db->order_by('sort', 'ASC');
            $this->db->order_by('c_depth', 'ASC');
            $this->db->order_by('c_seq', 'ASC');
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


        public function get_max_sort() //최대값 가져오기 - > 이를 통하여 대댓글 구현
        {
            $this->db->select_max('sort');
            return $this->db->get('comment_test')->result_array();
        }

        public function remove_comment($input_arr)
        {
           $data =  $this->db->get_where('comment_test', array('c_seq' => $input_arr['c_seq']))->result_array();
           $row = $data[0];
           if ( ($row['password'] == $input_arr['password']) && ($row['c_depth'] == 0) )
           {
            $this->db->where('parent_seq', $input_arr['c_seq']);
            $this->db->delete("comment_test");
            return 1;
           }
           
           else if ($row['password'] == $input_arr['password'])
           {
                $result = $this->db->query('select MIN(sort) from comment_test where parent_seq = '.$row['parent_seq'].' and sort>='.$row['sort'].' AND baby = 0;');
                $result = $result->result_array()[0]['MIN(sort)'];
                $sort = $row['sort'] - 1;
                $this->db->query('delete from comment_Test where parent_seq = '.$row['parent_seq'].' and sort >= '.$row['sort'].' and sort <= '.$result.';'); // 자기 솔트부터 자기 아래 없는 솔트까지 다 삭제
                $this->db->query("UPDATE comment_test SET baby = 0 WHERE parent_seq = ".$row['parent_seq']." AND sort = ".$sort." ; "); // 바로 윗 댓글 댓글쓰기 활성화 
                return 1;
           }
           else //비번 틀렸으면 여기
           {
                return 0;
           }
        }


        public function update_func($input_arr)
        {
            $where = array(
                'c_seq' => $input_arr['c_seq']  
              );
              $this->db->update('comment_test', $input_arr, $where);
              return 0;
        }

    }

?>
