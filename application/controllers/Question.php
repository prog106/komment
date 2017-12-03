<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('biz/Questionbiz', 'questionbiz');
    }

    private function manager($member) { // {{{
        if(empty($member)) {
            alertmsg_move('로그인 후 이용해 주세요', '/');
            die;
        }
        if(empty($member['mem_noname'])) {
            redirect('/sign/logout', 'refresh');
            die;
        }
    } // }}}

    // 질문 리스트 & 올리기 폼
    public function index() { // {{{
        $member = $this->session->userdata('loginmember');
        self::manager($member);

        $data = array();
        $data['member'] = $member;
        load_view('question/index', $data);
    } // }}}

    // 질문 리스트
    public function lists() { // {{{
        $member = $this->session->userdata('loginmember');
        self::manager($member);

        $data = array();
        $data['member'] = $member;
        load_view('question/lists', $data);
    } // }}}

    // 질문 올리기
    public function ax_set_question() { // {{{
        $member = $this->session->userdata('loginmember');
        self::manager($member);

        $mem_srl = $member['mem_srl'];
        $mem_name = $member['mem_name'];
        $mem_level = $member['level'];
        $mem_picture = $member['mem_picture'];
        $question_image = $this->input->post('question_image', true);
        $question = trim(strip_tags($this->input->post('question', true)));
        $start = $this->input->post('start', true);
        $nonickname = $this->input->post('nonickname', true);
        // 익명 등록시
        if($nonickname === 'Y') {
            $code = '';
            for ($i=1;$i<=8;$i++ ) { // 8자리 난수 발생
                $code .= substr('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', rand(0,61), 1);
            }
            $mem_name = $code;
            $mem_picture = "/static/image/whoareyou.png";
        }
        $main_start = $this->input->post('main_start', true);
        if(!empty($main_start)) $main_start .= " 00:00:00";
        $main_end = $this->input->post('main_end', true);
        if(!empty($main_end)) $main_end .= " 23:59:59";
        $que_srl = $this->input->post('que_srl', true);
        $tm = $this->input->post('tm', true);
        if(empty($question)) {
            echo json_encode(error_result('질문을 입력하세요.'));
            die;
        }
        $hashtag = hashtag($question);

        $choices = array();
        $corrects = array();
        $vote_count = 0;
        $qform = $this->input->post('qform', true);
        // 객관식
        if($qform === 'choice') {
            $choice = $this->input->post('choice', true);
            $correct = $this->input->post('correct', true);
            $cor = array_count_values($correct);
            if(!empty($cor['Y'])) {
                if($cor['Y'] !== 1) {
                    echo json_encode(error_result('1개의 정답을 선택해 주세요.'));
                    die;
                }
            } else {
                echo json_encode(error_result('1개의 정답을 선택해 주세요.'));
                die;
            }
            $cnt = count($choice);
            for($i=0;$i<$cnt;$i++) {
                if(!empty($choice[$i])) {
                    $choices[] = $choice[$i];
                    $corrects[] = $correct[$i];
                }
            }
            if(count($choices) < 2) {
                echo json_encode(error_result('보기를 2개 이상 입력해 주세요.'));
                die;
            }
        }
        // 투표
        if($qform === 'vote') {
            $vote = $this->input->post('vote', true);
            $vote_count = $this->input->post('vote_count', true);
            $cnt = count($vote);
            for($i=0;$i<$cnt;$i++) {
                if(!empty($vote[$i])) {
                    $choices[] = $vote[$i];
                    $corrects[] = 'C';
                }
            }
        }

        if(!empty($que_srl) && $que_srl > 0) {
            if($member['level'] === 'manager') {
                $result = $this->questionbiz->update_question($que_srl, $question, $hashtag, $mem_srl, $question_image, $start, $main_start, $main_end);
            } else {
                $result = $this->questionbiz->update_question($que_srl, $question, $hashtag, $mem_srl, $question_image);
            }
        } else {
            if($member['level'] === 'manager') {
                $result = $this->questionbiz->save_question($question, $hashtag, $mem_srl, $mem_name, $mem_level, $mem_picture, $tm, $choices, $corrects, $vote_count, $question_image, $main_start, $main_end, $start, $tm);
            } else {
                $result = $this->questionbiz->save_question($question, $hashtag, $mem_srl, $mem_name, $mem_level, $mem_picture, $tm, $choices, $corrects, $vote_count, $question_image);
            }
        }
        if($result['result'] == 'ok') {
            echo json_encode(ok_result());
            die;
        } else {
            echo json_encode(error_result($result['msg']));
        }
    } // }}}

    // 질문 지우기
    public function ax_set_question_del() { // {{{
        $member = $this->session->userdata('loginmember');
        self::manager($member);

        $que_srl = $this->input->post('que', true);
        if(!empty($que_srl) && $que_srl > 0) {
            $result = $this->questionbiz->delete_question($que_srl, $member['mem_srl']);
        } else {
            return error_result('잘못된 접근입니다.');
        }
        if($result['result'] == 'ok') {
            echo json_encode(ok_result());
            die;
        } else {
            echo json_encode(error_result($result['msg']));
        }
    } // }}}

    // 질문 가져오기
    public function ax_get_question() { // {{{
        $member = $this->session->userdata('loginmember');
        self::manager($member);

        $page = $this->input->post('page', true);
        $result = $this->questionbiz->get_question_list($page, $member['mem_srl'], null, '20', $member['level']);
        $list = array();
        foreach($result as $k => $v) {
            //$v['question'] = nl2br(strip_tags($v['question']));
            if($member['level'] === 'manager') {
                $list[] = $this->load->view('question/mitem', $v, true);
            } else {
                $list[] = $this->load->view('question/item', $v, true);
            }
        }
        $lists = array(
            'recordsTotal' => count($result),
            'data' => $list,
        );
        echo json_encode($lists);
    } // }}}

}
