<?php

        class Board_con extends CI_Controller 
        {

                public function __construct()
                {
                        parent::__construct();
                        $this->load->model('board_model');
                        $this->load->model('comment_model');
                        $this->load->helper("url");
                        $this->load->helper("JS");
                        $this->load->library("pagination");
                }
                
                public function index()
                {
                        $max = $this->board_model->get_MAX();

                        $config = array();
                        $config['base_url'] = "/board_con";
                        $config['total_rows'] = $max;
                        $config['per_page'] = 5;
                        $config['uri_segment'] = 2;
                        $config['num_links'] = 3;

                                                
                        $config['full_tag_open'] = '<ul class="pagination" style="justify-content : center !important; " >';
                        $config['full_tag_close'] = '</ul>';
                        $config['num_tag_open'] = '<div class="page-link">';
                        $config['num_tag_close'] = '</div>';
                        $config['cur_tag_open'] = '<b class="page-link"">';
                        $config['cur_tag_close'] = '</b>';
                        $config['next_tag_open'] = '<div class="page-link">';
                        $config['next_tag_close'] = '</div>';
                        $config['prev_tag_open'] = '<div class="page-link">';
                        $config['prev_tag_close'] = '</div>';
                        $config['last_tag_open'] = '<div class="page-link">';
                        $config['last_tag_close'] = '</div>';
                        $config['first_tag_open'] = '<div class="page-link">';
                        $config['first_tag_close'] = '</div>';
                        
                        $this->pagination->initialize($config);
                        
                        $page = ( $this->uri->segment(2) ? $this->uri->segment(2) : 0 );
                        $data["links"] = $this->pagination->create_links();
                        $data['lists'] = $this->board_model->get_lists($config["per_page"], $page);
                        $data['page'] = $page;
                        //페이징 라이브러리 사용
                        

                        
                        
                        $this->load->view('/templates/header'); 
                        $this->load->view("/templates/board/list", $data);
                        $this->load->view('/templates/footer'); 
                }

                public function content()
                {
                        $b_seq = $this->uri->segment(3);
                        $this->board_model->visited_update($b_seq);
                        
                        $result_b = $this->board_model->get_content($b_seq);
                        $result_c = $this->comment_model->get_list($b_seq);
                        $data = array(
                                'result' => $result_b,
                                'comments' => $result_c
                        );

                        $this->load->view('/templates/header'); 
                        $this->load->view('/templates/board/content', $data);
                        $this->load->view('/templates/footer'); 
                }

           
                public function write() //글작성 페이지 
                {
                        $b_seq = $this->uri->segment(3);

                        if ( $b_seq != 0 )
                        {
                                $result_b = $this->board_model->get_content($b_seq)[0];
                                $data = array(
                                        'b_seq' => $result_b['b_seq'],
                                        'subject' => $result_b['subject'],
                                        'writer' => $result_b['writer'],
                                        'password' => $result_b['password'],
                                        'body' => $result_b['body']
                                );
                                $this->load->view('/templates/header'); 
                                $this->load->view('/templates/board/b_write', $data); 
                                $this->load->view('/templates/footer');   
                        }
                        else
                        {
                                $this->load->view('/templates/header'); 
                                $this->load->view('/templates/board/b_write'); 
                                $this->load->view('/templates/footer');   
                        }
                      
                }
                
                public function write_action()
                {
                        $b_seq = $this->input->post('b_seq'); //게시글 번호가 넘어옴

                        $inputPass_hash = $this->input->post('userPass');
                        $inputPass_hash = hash("sha256", $inputPass_hash);
                       
                        $data = array(
                                'b_seq' => null,
                                'subject' => $this->input->post('subject'),
                                'writer' => $this->input->post('userID'),
                                'Password' => $inputPass_hash,
                                'body' => $this->input->post('body'),
                                'visited' => 0,
                                'permission' => 0
                        );

                        if (isset($b_seq)) // 게시글 번호가 정의된 경우 -> 수정
                        {
                                $data['b_seq'] = $b_seq;
                                $this->board_model->update_board($data);
                        }

                        else 
                        {
                                $this->board_model->insert_board($data);
                        }
                        
                        redirect('../board_con');
                }


                public function remove_act()
                {       
                        $input_pass = $this->input->post("input_pass");
                        $input_pass = hash("sha256", $input_pass);
                        
                        $b_seq = $this->input->post("b_seq");
                        
                        $input_arr = array(
                                'b_seq' => $b_seq,
                                'password' => $input_pass      
                        );
                        echo $this->board_model->remove_board($input_arr);

                }

                public function check()
                {
                       
                        $input_pass = $this->input->post("input_pass");
                        $input_pass = hash("sha256", $input_pass);
                        
                        $b_seq = $this->input->post("b_seq");
                        
                        $result = $this->board_model->get_content($b_seq)[0];
                        
                        if($result['password'] == $input_pass)
                        {
                                echo 1;
                        }
                        else
                        {
                                echo "비밀번호가 다릅니다.";
                        }
                }
        }

?>