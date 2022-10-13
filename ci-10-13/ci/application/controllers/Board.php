<?php
    if (!defined('BASEPATH')) exit ('NO direct script access allowed');

        class Board extends CI_Controller 
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
                        $max_board = $this->board_model->get_count();


                        unset($_SESSION['search_index'], $_SESSION['search_for']);
                        //기본 페이지로 복귀 => unset

                        $paging = array();
                        $paging['base_url'] = "/board";
                        $paging['total_rows'] = $max_board;
                        $paging['per_page'] = 7;
                        $paging['uri_segment'] = 2;
                        $paging['num_links'] = 3;
                                                                        
                        $paging['full_tag_open'] = '<ul class="pagination" style="justify-content : center !important; " >';
                        $paging['full_tag_close'] = '</ul>';
                        $paging['num_tag_open'] = '<div class="page-link">';
                        $paging['num_tag_close'] = '</div>';
                        $paging['cur_tag_open'] = '<b class="page-link"">';
                        $paging['cur_tag_close'] = '</b>';
                        $paging['next_tag_open'] = '<div class="page-link">';
                        $paging['next_tag_close'] = '</div>';
                        $paging['prev_tag_open'] = '<div class="page-link">';
                        $paging['prev_tag_close'] = '</div>';
                        $paging['last_tag_open'] = '<div class="page-link">';
                        $paging['last_tag_close'] = '</div>';
                        $paging['first_tag_open'] = '<div class="page-link">';
                        $paging['first_tag_close'] = '</div>';
                        
                        $this->pagination->initialize($paging);
                        
                        $page = ( $this->uri->segment(2) ? $this->uri->segment(2) : 0 );
                        $_SESSION['list_seq'] = $page;
                        $data["links"] = $this->pagination->create_links();
                        $data['lists'] = $this->board_model->get_lists($paging["per_page"], $page);
                        $data['MAX'] = $max_board - $page;
                        $data['page'] = $page;
                        
                        //페이징 라이브러리 사용 paging 사용은 넘버링/ 
                        

                        
                        
                        $this->load->view('/templates/header'); 
                        $this->load->view("/templates/board/list", $data);
                        $this->load->view('/templates/footer'); 
                }

                public function search()
                {
                       if( !( $this->input->post('search_index') == NULL ) ) //찾는 값이 존재할 경우 => NULL이 아닐경우. 
                       {
                                $_SESSION['search_index'] = $this->input->post('search_index');
                                $_SESSION['search_for'] = $this->input->post('search_for');
                       }
                       
                        $max_board = $this->board_model->get_count_search($this->session->search_index, $this->session->search_for);

                        $paging = array();
                        $paging['base_url'] = "/board/search";
                        $paging['total_rows'] = $max_board;
                        $paging['per_page'] = 3;
                        $paging['uri_segment'] = 3;
                        $paging['num_links'] = 3;

                                                
                        $paging['full_tag_open'] = '<ul class="pagination" style="justify-content : center !important; " >';
                        $paging['full_tag_close'] = '</ul>';
                        $paging['num_tag_open'] = '<div class="page-link">';
                        $paging['num_tag_close'] = '</div>';
                        $paging['cur_tag_open'] = '<b class="page-link"">';
                        $paging['cur_tag_close'] = '</b>';
                        $paging['next_tag_open'] = '<div class="page-link">';
                        $paging['next_tag_close'] = '</div>';
                        $paging['prev_tag_open'] = '<div class="page-link">';
                        $paging['prev_tag_close'] = '</div>';
                        $paging['last_tag_open'] = '<div class="page-link">';
                        $paging['last_tag_close'] = '</div>';
                        $paging['first_tag_open'] = '<div class="page-link">';
                        $paging['first_tag_close'] = '</div>';
                        
                        $this->pagination->initialize($paging);
                        
                        
                        $page = ( $this->uri->segment(3) ? $this->uri->segment(3) : 0 );
                        $_SESSION['list_seq'] = $page;
                        $data["links"] = $this->pagination->create_links();
                        $data['lists'] = $this->board_model->get_content_search($this->session->search_index, $this->session->search_for, $paging["per_page"], $page);
                        $data['page'] = $page;
                        $data['MAX'] = $max_board - $page;
                        $data['search'] = array(
                                'search_index' => $this->session->search_index,
                                'search_for' => $this->session->search_for
                        );

                        $this->load->view('/templates/header'); 
                        $this->load->view('/templates/board/list', $data); 
                        $this->load->view('/templates/footer');  
                }

                public function content()
                {
                        $b_seq = $this->input->get('b_seq');
                        $this->board_model->visited_update($b_seq);
                        
                        
                        $result_b = $this->board_model->get_content($b_seq);
                        $result_c = $this->comment_model->get_list($b_seq);
                        $data = array(
                                'result' => $result_b,
                                'comments' => $result_c,
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
                                'permission' => $this->input->post('permission')
                        );

                        if (isset($b_seq)) // 게시글 번호가 정의된 경우 -> 수정
                        {
                                $result = $this->board_model->get_content($b_seq)[0]; //데이터값 가져오기

                                $data['b_seq'] = $b_seq;
                                $data['visited'] = $result['visited'];
                                $this->board_model->update_board($data);
                        }

                        else 
                        {
                               $b_seq = $this->board_model->insert_board($data);
                        }
                        
                        redirect('../board/content?b_seq='.$b_seq.'&list_seq=0');
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
                        //성공했을 경우 1을, 실패는 0
                }

                public function check() //수정하기전 체크하는 함수 -> 위에 제거함수는 직접 제거하는 것임.
                {
                       
                        $input_pass = $this->input->post("input_pass");
                        $input_pass = hash("sha256", $input_pass);
                        
                        $b_seq = $this->input->post("b_seq");
                        
                        $result = $this->board_model->get_content($b_seq)[0]; //값이 하나뿐일테니
                        
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