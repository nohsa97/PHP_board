<?
    if (!defined('BASEPATH')) exit ('NO direct script access allowed');
    class Comment extends CI_Controller
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
            $parent_c_seq = $this->input->post('c_seq');
            $b_seq = $this->input->post('b_seq');
            $list_seq = $this->input->post('list_seq');
            $writer = $this->input->post('writer');
            $body = $this->input->post('body');

            $permission = ($this->input->post('permission') ? 1 : 0); //값이 존재한다면 1 아니면 0 


            $hash_pass = $this->input->post('password');
            $hash_pass = hash("sha256", $hash_pass);

            if (!isset($parent_c_seq))  //포스트로 시퀀스가 넘어왔으면 
            {
                $data = array(
                        'c_seq' => null,
                        'b_seq' => $b_seq,
                        'parent_seq' => null,
                        'sort' => 0,
                        'c_depth' => 0,
                        'writer' => $writer,
                        'password' => $hash_pass,
                        'body' => $body,
                        'permission' => $permission
                );
                $this->comment_model->insert_comment($data);
                redirect('/board/get_content?b_seq='.$b_seq.'&list_seq='.$list_seq);
            }

            else
            {

                $parent_comment = $this->comment_model->get_comment($parent_c_seq)[0];

                if ($parent_comment['c_depth'] == 0)
                {
                    $sort =  ($this->comment_model->get_max_sort()[0]['sort']);    
                }
                else
                {
                    $sort = $parent_comment['sort'];
                }


                $data = array(
                    'c_seq' => null,
                    'b_seq' => $b_seq,
                    'parent_seq' => $parent_comment['parent_seq'],
                    'sort' => $sort + 1,
                    'c_depth' => $parent_comment['c_depth'] + 1,
                    'writer' => $writer,
                    'password' => $hash_pass,
                    'body' => $body,
                    'permission' => 0
                );
                $this->comment_model->insert_reply($data, $parent_c_seq);
                redirect('/board/get_content?b_seq='.$b_seq.'&list_seq='.$list_seq);
            }
        }

        public function remove_func()
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
        
        public function update_func()
        {
            $input_pass = $this->input->post("input_pass");
            $input_pass = hash("sha256", $input_pass);
            $c_seq = $this->input->post("c_seq");
            $input_body = $this->input->post("body");

            $pass = $this->comment_model->get_comment($c_seq)[0];

            if($pass['password'] == $input_pass)
            {
                    $input_arr = array(
                            'c_seq' => $c_seq,
                            'password' => $input_pass,
                            'body' => $input_body      
                    );

                    $this->comment_model->update_func($input_arr);
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