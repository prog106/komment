<?php
/**
 * @ description : Question biz
 * @ author : prog106 <prog106@gmail.com>
 */
class Questionbiz extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('dao/Questiondao', 'questiondao');
    }

    // 질문 저장
    public function save_question($question, $hashtag, $mem_srl, $mem_name, $mem_level, $mem_picture, $tm, $choices, $corrects, $vote_count, $question_image=null, $main_start=null, $main_end=null, $start=null) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        else return $error_result;
        $info = self::get_question_recent($mem_srl, date('Y-m-d'));
        if($mem_level !== 'manager' && $info['cnt'] >= 3) {
            return error_result('질문은 하루에 3개까지 등록 가능합니다.');
        }

        if(!empty($mem_name)) $sql_param['mem_name'] = $mem_name;
        else return $error_result;
        if(!empty($mem_level)) $sql_param['mem_level'] = $mem_level;
        else return $error_result;
        if(!empty($mem_picture)) $sql_param['mem_picture'] = $mem_picture;
        $this->load->model('biz/Signbiz', 'signbiz');
        $point = $this->signbiz->get_member_correct_point($mem_srl);
        $sql_param['mem_point'] = $point['data']['point'];
        if(!empty($question_image)) $sql_param['question_image'] = $question_image;
        if(!empty($question)) $sql_param['question'] = $question;
        else return $error_result;
        if(!empty($choices)) $sql_param['choice'] = count($choices);
        if(!empty($vote_count)) $sql_param['vote_count'] = $vote_count;
        $sql_param['hashtag'] = $hashtag;
        if(!empty($start)) $sql_param['start'] = $start;
        else $sql_param['start'] = date('Y-m-d');
        if(!empty($main_start)) $sql_param['main_start'] = $main_start;
        if(!empty($main_end)) $sql_param['main_end'] = $main_end;
        if(!empty($tm)) $sql_param['end_time'] = date('Y-m-d H:i:s', time() + ($tm * 60 * 60));
        else return $error_result;
        $sql_param['create_at'] = YMD_HIS;
        try {
            $this->db->trans_begin();
            $que_srl = $this->questiondao->save_question($sql_param);
            if(empty($que_srl)) throw new Exception('등록에 실패하였습니다.');
            if(!empty($choices)) {
                $ex_param = array();
                foreach($choices as $k => $v) {
                    $ex_param['que_srl'] = $que_srl;
                    $ex_param['example'] = $v;
                    $ex_param['answer'] = $corrects[$k];
                    $ex_param['create_at'] = YMD_HIS;
                    $ex_srl = $this->questiondao->save_example($ex_param);
                    if(empty($ex_srl)) throw new Exception('등록에 실패하였습니다');
                }
            }
            $this->db->trans_commit();
            return ok_result(true);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            return error_result($msg);
        }
    } // }}}

    // 질문 업데이트
    public function update_question($que_srl, $question, $hashtag, $mem_srl, $question_image=null, $start=null, $main_start=null, $main_end=null) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(empty($que_srl)) return $error_result;
        if(!empty($question_image)) $sql_param['question_image'] = $question_image;
        if(!empty($question)) $sql_param['question'] = $question;
        else return $error_result;
        $sql_param['hashtag'] = $hashtag;
        if(empty($mem_srl)) return $error_result;
        if(!empty($start)) $sql_param['start'] = $start;
        if(!empty($main_start)) $sql_param['main_start'] = $main_start;
        if(!empty($main_end)) $sql_param['main_end'] = $main_end;
        $info = self::get_question($que_srl);
        if(empty($info)) return error_result('질문이 존재하지 않습니다.');
        if($info['mem_srl'] !== $mem_srl) return error_result('잘못된 접근입니다.');
        return ok_result($this->questiondao->update_question($sql_param, $que_srl));
    } // }}}

    // 질문 지우기
    public function delete_question($que_srl, $mem_srl) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(empty($que_srl)) return $error_result;
        if(empty($mem_srl)) return $error_result;
        $info = self::get_question($que_srl);
        if($info['mem_srl'] !== $mem_srl) return error_result('잘못된 접근입니다.');
        $sql_param['status'] = 'delete';
        return ok_result($this->questiondao->update_question($sql_param, $que_srl));
    } // }}}

    // 전체 질문 카운터 가져오기 
    public function get_question_list_all($mem_level='normal', $ws=null, $we=null) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        $sql_param['status'] = 'use';
        $sql_param['end_time >= '] = YMD_HIS;
        $sql_param['start <= '] = date('Y-m-d');
        if(!empty($ws) && !empty($we)) {
            $sql_param['create_at >= '] = $ws." 00:00:00";
            $sql_param['create_at <= '] = $we." 23:59:59";
        }
        return $this->questiondao->get_question_list_all($sql_param);
    } // }}}

    // 전체 질문 가져오기 페이징
    public function get_question_list($page=1, $mem_srl=null, $order=null, $limit=20, $mem_level='normal', $ws=null, $we=null) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        $sql_param['status'] = 'use';
        $sql_param['start <= '] = date('Y-m-d');
        if($order === 'respond' || $order === 'best') {
            $sql_param['create_at >= '] = $ws." 00:00:00";
            $sql_param['create_at <= '] = $we." 23:59:59";
        }
        $paging = ($page-1)*$limit;
        return $this->questiondao->get_question_list($sql_param, $paging, $limit, $order);
    } // }}}

    // 마감 임박한 질문 카운터 가져오기
    public function get_question_close_list_all($mem_level='normal') { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        $sql_param['status'] = 'use';
        $sql_param['start <= '] = date('Y-m-d');
        $sql_param['end_time <= '] = date('Y-m-d H:i:s', strtotime('+15 day'));//YMD_HIS;
        $sql_param['end_time >= '] = YMD_HIS;
        return $this->questiondao->get_question_list_all($sql_param);
    } // }}}

    // 마감 임박한 질문 가져오기
    public function get_question_close_list($page=1, $mem_srl=null, $limit=20, $mem_level='normal') { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        $sql_param['status'] = 'use';
        $sql_param['start <= '] = date('Y-m-d');
        $sql_param['end_time <= '] = date('Y-m-d H:i:s', strtotime('+7 day'));//YMD_HIS;
        $sql_param['end_time >= '] = YMD_HIS;
        $paging = ($page-1)*$limit;
        return $this->questiondao->get_question_close_list($sql_param, $paging, $limit);
    } // }}}

    // 메인 노출 질문 가져오기
    public function get_main_question_list() { // {{{
        $sql_param = array();
        //$sql_param['mem_level'] = 'manager';
        $sql_param['status'] = 'use';
        $sql_param['start <= '] = date('Y-m-d');
        $sql_param['NOW() BETWEEN main_start AND main_end'] = null; 
        return $this->questiondao->get_main_question_list($sql_param);
    } // }}}

    // 질문 가져오기
    public function get_question($que_srl) { // {{{
        if(empty($que_srl)) return error_result();
        return $this->questiondao->get_question($que_srl);
    } // }}}

    // 오늘 질문 갯수 가져오기
    public function get_question_recent($mem_srl, $start) { // {{{
        if(empty($mem_srl)) return error_result();
        if(empty($start)) return error_result();
        return $this->questiondao->get_question_recent($mem_srl, $start);
    } // }}}

    // 보기 가져오기
    public function get_example($que_srl) { // {{{
        if(empty($que_srl)) return error_result();
        return $this->questiondao->get_example($que_srl);
    } // }}}

}
