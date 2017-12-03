<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    // 메인
	public function index() { // {{{
        $member = $this->session->userdata('loginmember');
        $nologin = $this->input->cookie('nologin');
        if(empty($nologin) && empty($member)) {
            redirect('/sign/login', 'refresh');
            die;
        }
        if(!empty($member)) {
            redirect('/lists/recent', 'refresh');
            die;
        } else {
            redirect('/lists/recent', 'refresh');
            die;
        }
        $this->load->model('biz/Questionbiz', 'questionbiz');
        $result = $this->questionbiz->get_main_question_list(1);
        $like = array();
        if(!empty($result)) {
            if(!empty($member) && $member['mem_srl'] > 0) {
                $que_srls = array();
                foreach($result as $k => $v) {
                    $que_srls[] = $v['que_srl'];
                }
                $this->load->model('biz/Likebiz', 'likebiz');
                $likes = $this->likebiz->get_like_info($member['mem_srl'], $que_srls);
                foreach($likes as $k => $v) {
                    $like[$v['que_srl']] = $v['like_srl'];
                }
            }
        }
        $data = array();
        $data['member'] = $member;
        $data['list'] = $result;
        $data['like'] = $like;
        load_view('home/index', $data);
    } // }}}

}
