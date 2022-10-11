<?
    class Comment_con extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('comment_model');
            $this->load->helper("url");
            $this->load->helper("JS");
        }

        public function comment_write()
        {
                $hash_pass = $this->input->post('password');
                $hash_pass = hash("sha256", $hash_pass);
            
                $data = array(
                        'c_seq' => null,
                        'b_seq' => $this->input->post('b_seq'),
                        'parent_seq' => null,
                        'sort' => 1,
                        'c_depth' => 0,
                        'writer' => $this->input->post('writer'),
                        'password' => $hash_pass,
                        'body' => $this->input->post('body'),
                        'permission' => 0
                );
                $this->comment_model->insert_comment($data);
                alerting("asd");
                redirect('/board_con/content/'.$this->input->post('b_seq').'?list_seq='.$this->input->post('list_seq'));
        }

        public function remove_act()
        {       
                $input_pass = $this->input->post("input_pass");
                $input_pass = hash("sha256", $input_pass);
                $c_seq = $this->input->post("c_seq");
                
                $input_arr = array(
                        'c_seq' => $c_seq,
                        'password' => $input_pass      
                );
                echo $this->comment_model->remove_comment($input_arr);

        }

        public function update_act()
        {
                $input_pass = $this->input->post("input_pass");
                $input_pass = hash("sha256", $input_pass);
                $c_seq = $this->input->post("c_seq");
                $input_body = $this->input->post("body");

                $pass = $this->comment_model->get_comment($c_seq)[0];

                if( $pass['password'] == $input_pass)
                {
                        $input_arr = array(
                                'c_seq' => $c_seq,
                                'password' => $input_pass,
                                'body' => $input_body      
                        );

                        $this->comment_model->update_act($input_arr);
                        echo "댓글을 수정하였습니다.";
                }

                else 
                {
                        echo "비밀번호가 틀립니다.";
                }
                exit;

        }
    }
?>