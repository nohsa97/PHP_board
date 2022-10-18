<?
    if (!defined('BASEPATH')) exit ('NO direct script access allowed');
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
                redirect('/board_con/content/'.$this->input->post('b_seq').'?list_seq='.$this->input->post('list_seq'));
           
        }

        public function remove_act()
        {

        }
        
        public function update_act()
        {
                
        }

        
    }
?>