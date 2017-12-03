<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('biz/Answerbiz', 'answerbiz');
    }

    private function manager($member) { // {{{
        if(empty($member)) {
            echo json_encode(error_result('로그인 후 이용해 주세요'));
            die;
        }
    } // }}}

    // 질문 상세 & 답글 올리기 폼
    public function view($que_srl) { // {{{
        $member = $this->session->userdata('loginmember');
        if(empty($que_srl)) {
            alertmsg_move('질문이 없습니다.');
            die;
        }
        if(!empty($member) && empty($member['mem_noname'])) {
            redirect('/sign/logout', 'refresh');
            die;
        }
        $data = array();
        $data['member'] = $member;
        $this->load->model('biz/Questionbiz', 'questionbiz');
        $question = array();
        $question = $this->questionbiz->get_question($que_srl);
        if(empty($question)) {
            alertmsg_move('질문이 없습니다.');
            die;
        }
        // 객관식 일경우
        $example = array();
        $correct = array();
        $percent = array();
        $total_percent = 0;
        if($question['choice'] > 0) {
            if(!empty($member)) {
                // 내가 참여한 정보
                $corrects = $this->answerbiz->get_correct($que_srl, $member['mem_srl']);
                foreach($corrects as $k => $v) {
                    $correct[$v['exam_srl']] = $v;
                }
            }
            // 객관식 보기 정보
            $example = $this->questionbiz->get_example($que_srl);
            // 정답률 정보
            $percents = $this->answerbiz->get_correct_percent($que_srl);
            foreach($percents as $k => $v) {
                $percent[$v['exam_srl']] = $v;
                $total_percent += $v['cnt'];
            }
        }
        $like = array();
        if(!empty($member)) {
            $this->load->model('biz/Likebiz', 'likebiz');
            $likes = $this->likebiz->get_like_info($member['mem_srl'], array($que_srl));
            foreach($likes as $k => $v) {
                $like[$v['que_srl']] = $v['like_srl'];
            }
        }
        $data['question'] = $question;
        $data['example'] = $example;
        $data['correct'] = $correct;
        $data['percent'] = $percent;
        $data['total_percent'] = $total_percent;
        $data['like'] = $like;
        load_view('answer/index', $data);
    } // }}}

    // 답글 올리기
    public function ax_set_answer() { // {{{
        $member = $this->session->userdata('loginmember');
        self::manager($member);

        $que_srl = $this->input->post('question', true);
        $answer = trim(strip_tags($this->input->post('answer', true)));
        if(empty($answer)) {
            echo json_encode(error_result());
            die;
        }
        $chnoname = $this->input->post('chnoname', true);

        $mem_srl = $member['mem_srl'];
        $mem_name = $member['mem_name'];
        $mem_level = $member['level'];
        $mem_picture = $member['mem_picture'];
        if($chnoname === 'Y') {
            $code = '';
            for ($i=1;$i<=8;$i++ ) { // 8자리 난수 발생
                $code .= substr('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', rand(0,61), 1);
            }
            $mem_name = $code;
            $mem_picture = "/static/image/whoareyou.png";
        }
        //$hashtag = hashtag($answer); // 댓글은 해시태그 사용안함
        $hashtag = null;
        $result = $this->answerbiz->answer($answer, $hashtag, $mem_srl, $mem_name, $mem_level, $mem_picture, $que_srl);
        if($result['result'] == 'ok') {
            echo json_encode(ok_result());
            die;
        }
        echo json_encode(error_result());
    } // }}}

    // 정답 맞추기 || 투표하기
    public function ax_set_correct() { // {{{
        $member = $this->session->userdata('loginmember');
        self::manager($member);

        $que_srl = $this->input->post('question', true);
        $exam_srl = $this->input->post('example', true);
        if(empty($que_srl) || empty($exam_srl)) {
            echo json_encode(error_result());
            die;
        }
        $mem_srl = $member['mem_srl'];
        $result = $this->answerbiz->correct($que_srl, $exam_srl, $mem_srl);
        if($result['result'] == 'ok') {
            echo json_encode(ok_result(true, $result['msg']));
            die;
        }
        echo json_encode(error_result());
    } // }}}

    // 답글 가져오기
    public function ax_get_answer() { // {{{
        $member = $this->session->userdata('loginmember');
        $mem_srl = null;
        if(!empty($member)) $mem_srl = $member['mem_srl'];
        $que_srl = $this->input->post('question', true);
        $page = $this->input->post('page', true);
        $result = $this->answerbiz->get_answer_list($page, $que_srl, $mem_srl);
        $list = array();
        //if($mem_srl > 0) {
            foreach($result as $k => $v) {
                //$result[$k]['me'] = ($v['mem_srl'] === $mem_srl)?true:false;
                $v['me'] = (!empty($mem_srl) && $v['mem_srl'] === $mem_srl)?true:false;
                $list[] = $this->load->view('answer/item', $v, true);
            }
        //}
        $lists = array(
            'recordsTotal' => count($result),
            'data' => $list,
        );
        echo json_encode($lists);
    } // }}}

    // 답글 지우기
    public function ax_set_answer_delete() { // {{{
        $member = $this->session->userdata('loginmember');
        self::manager($member);

        $ans_srl = $this->input->post('answer', true);
        if(empty($ans_srl)) {
            echo json_encode(error_result());
            die;
        }
        $result = $this->answerbiz->delete_answer($ans_srl, $member['mem_srl']);
        if($result['result'] == 'ok') {
            echo json_encode(ok_result());
            die;
        }
        echo json_encode(error_result());
    } // }}}

    public function reply() { // {{{
        alertmsg_move('준비중입니다.');
    } // }}}

}
