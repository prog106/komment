<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
    }

    // 최신 
	public function recent() { // {{{
        $member = $this->session->userdata('loginmember');
        /*if(empty($this->input->cookie('nologin')) && empty($member)) {
            redirect('/sign/login', 'refresh');
            die;
        }*/
        $page = $this->input->get('per_page', true);
        $page = (!empty($page))?$page:"1";
        $types = 'recent'; 
        $limit = 20;
        $this->load->model('biz/Questionbiz', 'questionbiz');
        $all = $this->questionbiz->get_question_list_all();
        $result = $this->questionbiz->get_question_list($page, null, $types, $limit);

        $lists = array();
        $item = array();
        if(!empty($result)) {
            if(!empty($member) && $member['mem_srl'] > 0) {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                    $item[] = $this->load->view('lists/item', $v, true);
                }
            } else {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                    $item[] = $this->load->view('lists/item', $v, true);
                }
            }
        }
        $config['base_url'] = '/lists/recent/';
        $config['total_rows'] = $all['count'];
        $config['per_page'] = $limit; 
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        
        $data = array();
        $data['member'] = $member;
        $data['result'] = $result;
        $data['paging'] = $this->pagination->create_links();
        load_view('lists/recent', $data);
    } // }}}

    // 최신 
	public function ax_get_lists() { // {{{
        $member = $this->session->userdata('loginmember');
        /*if(empty($this->input->cookie('nologin')) && empty($member)) {
            echo json_encode(error_result());
            die;
        }*/
        $page = $this->input->post('page', true);
        $types = $this->input->post('tp', true);
        $this->load->model('biz/Questionbiz', 'questionbiz');
        if($types === 'like') {
            $result = $this->questionbiz->get_question_close_list($page, null);
        } else {
            $result = $this->questionbiz->get_question_list($page, null, $types);
        }
        $like = array();
        $lists = array();
        $item = array();
        if(!empty($result)) {
            if(!empty($member) && $member['mem_srl'] > 0) {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                    $item[] = $this->load->view('lists/item', $v, true);
                }
                /*$this->load->model('biz/Likebiz', 'likebiz');
                $likes = $this->likebiz->get_like_info($member['mem_srl'], $que_srls);
                foreach($likes as $k => $v) {
                    $like[$v['que_srl']] = $v['like_srl'];
                }*/
            } else {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                    $item[] = $this->load->view('lists/item', $v, true);
                }
            }
        }
        $lists = array(
            'recordsTotal' => count($result),
            'data' => $item,
        );
        echo json_encode($lists);
    } // }}}

    // 인기
	public function respond() { // {{{
        $member = $this->session->userdata('loginmember');
        /*if(empty($this->input->cookie('nologin')) && empty($member)) {
            redirect('/sign/login', 'refresh');
            die;
        }*/
        $page = $this->input->get('per_page', true);
        $weekstart = $this->input->get('weekstart', true);
        $weekend = $this->input->get('weekend', true);
        if(empty($weekstart)) {
            $weekstart = date('Y-m-d', strtotime(date('w')." day ago"));
            $weekend = date('Y-m-d');
        }
        $page = (!empty($page))?$page:"1";
        $types = 'best';
        $limit = 20; 
        $this->load->model('biz/Questionbiz', 'questionbiz');
        $results = $this->questionbiz->get_question_list(1, null, $types, 5, $member['mem_level'], $weekstart, $weekend);
        $like = array();
        if(!empty($result)) {
            if(!empty($member) && $member['mem_srl'] > 0) {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                }
                //$this->load->model('biz/Likebiz', 'likebiz');
                //$likes = $this->likebiz->get_like_info($member['mem_srl'], $que_srls);
                //foreach($likes as $k => $v) {
                //    $like[$v['que_srl']] = $v['like_srl'];
                //}
            }
        }
        $types = 'respond';
        $all = $this->questionbiz->get_question_list_all($member['mem_level'], $weekstart, $weekend);
        $result = $this->questionbiz->get_question_list($page, null, $types, $limit, $member['mem_level'], $weekstart, $weekend);

        $lists = array();
        $item = array();
        if(!empty($result)) {
            if(!empty($member) && $member['mem_srl'] > 0) {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                    $item[] = $this->load->view('lists/item', $v, true);
                }
            } else {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                    $item[] = $this->load->view('lists/item', $v, true);
                }
            }
        }
        $config['base_url'] = '/lists/respond?weekstart='.$weekstart.'&weekend='.$weekend;
        $config['total_rows'] = $all['count'];
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data = array();
        $data['member'] = $member;
        $data['list'] = $results;
        $data['like'] = $like;
        $data['result'] = $result;
        $data['week'] = array('s' => $weekstart, 'e' => $weekend);
        $data['paging'] = $this->pagination->create_links();
        load_view('lists/respond', $data);
    } // }}}

    // 곧 종료 
	public function close() { // {{{
        $member = $this->session->userdata('loginmember');
        /*if(empty($this->input->cookie('nologin')) && empty($member)) {
            redirect('/sign/login', 'refresh');
            die;
        }*/
        $page = $this->input->get('per_page', true);
        $page = (!empty($page))?$page:"1";
        $limit = 20;
        $this->load->model('biz/Questionbiz', 'questionbiz');
        $all = $this->questionbiz->get_question_close_list_all();
        $result = $this->questionbiz->get_question_close_list($page, null, $limit);

        $lists = array();
        $item = array();
        if(!empty($result)) {
            if(!empty($member) && $member['mem_srl'] > 0) {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                    $item[] = $this->load->view('lists/item', $v, true);
                }
            } else {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                    $item[] = $this->load->view('lists/item', $v, true);
                }
            }
        }
        $config['base_url'] = '/lists/close/';
        $config['total_rows'] = $all['count'];
        $config['per_page'] = $limit; 
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        
        $data = array();
        $data['member'] = $member;
        $data['result'] = $result;
        $data['paging'] = $this->pagination->create_links();
        load_view('lists/close', $data);
    } // }}}

}
