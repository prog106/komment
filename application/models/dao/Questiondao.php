<?php
/**
 * @ description : Question dao
 * @ author : prog106 <prog106@gmail.com>
 */
class Questiondao extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    // 질문 저장
    public function save_question($sql_param) { // {{{
        $this->db->set($sql_param);
        $this->db->insert('question');
        return $this->db->insert_id();
    } // }}}

    // 보기 저장
    public function save_example($sql_param) { // {{{
        $this->db->set($sql_param);
        $this->db->insert('example');
        return $this->db->insert_id();
    } // }}}

    // 오늘 질문 갯수 가져오기
    public function get_question_recent($mem_srl, $start) { // {{{
        $this->db->select('count(*) AS cnt');
        $this->db->from('question');
        $this->db->where('mem_srl', $mem_srl);
        $this->db->where('start', $start);
        //$this->db->where('status', 'use');
        $this->db->order_by('que_srl', 'DESC');
        $this->db->limit('1');
        $result = $this->db->get();
        return $result->row_array();
    } // }}}

    // 질문 업데이트
    public function update_question($sql_param, $que_srl) { // {{{
        $this->db->set($sql_param);
        $this->db->where('que_srl', $que_srl);
        $this->db->update('question');
        return $this->db->affected_rows();
    } // }}}

    // 전체 질문 리스트 카운터
    public function get_question_list_all($sql_param) { // {{{
        $this->db->select('count(*) as count');
        $this->db->from('question');
        $this->db->where($sql_param);
        $result = $this->db->get();
        return $result->row_array();
    } // }}}

    // 전체 질문 리스트 페이징
    public function get_question_list($sql_param, $paging, $limit, $order=null) { // {{{
        $this->db->select('*');
        $this->db->from('question');
        $this->db->where($sql_param);
        if($order === 'recent') {
            $this->db->order_by('que_srl DESC');
        } else if($order === 'respond') {
            $this->db->order_by('respond DESC, likes DESC, end_time DESC, que_srl DESC');
        } else if($order === 'best') {
            $this->db->order_by('respond DESC, likes DESC, end_time DESC, que_srl DESC');
        } else {
            //$this->db->order_by('start DESC, likes DESC, respond DESC, que_srl DESC');
            $this->db->order_by('que_srl DESC');
        }
        $this->db->limit($limit, $paging);
        $result = $this->db->get();
        return $result->result_array();
    } // }}}

    // 종료 임박 전체 질문 리스트
    public function get_question_close_list($sql_param, $paging, $limit) { // {{{
        $this->db->select('*');
        $this->db->from('question');
        $this->db->where($sql_param);
        $this->db->order_by('end_time ASC');
        $this->db->limit($limit, $paging);
        $result = $this->db->get();
        return $result->result_array();
    } // }}}

    // 메인 노출 질문 리스트
    public function get_main_question_list($sql_param) { // {{{
        $this->db->select('*');
        $this->db->from('question');
        $this->db->where($sql_param);
        $this->db->order_by('likes DESC, respond DESC, que_srl DESC');
        $result = $this->db->get();
        return $result->result_array();
    } // }}}

    // 답변글 +1 업데이트
    public function update_question_answer($que_srl) { // {{{
        $this->db->set('respond', 'respond+1', false);
        $this->db->where('que_srl', $que_srl);
        $this->db->update('question');
        return $this->db->affected_rows();
    } // }}}

    // 답변글 -1 업데이트
    public function update_question_answer_del($que_srl) { // {{{
        $this->db->set('respond', 'respond-1', false);
        $this->db->where('que_srl', $que_srl);
        $this->db->update('question');
        return $this->db->affected_rows();
    } // }}}

    // 좋아요 +1 업데이트
    public function update_question_like($que_srl) { // {{{
        $this->db->set('likes', 'likes+1', false);
        $this->db->where('que_srl', $que_srl);
        $this->db->update('question');
        return $this->db->affected_rows();
    } // }}}

    // 좋아요 -1 업데이트
    public function update_question_dontlike($que_srl) { // {{{
        $this->db->set('likes', 'likes-1', false);
        $this->db->where('que_srl', $que_srl);
        $this->db->update('question');
        return $this->db->affected_rows();
    } // }}}

    // 질문 가져오기
    public function get_question($que_srl) { // {{{
        $this->db->select('*');
        $this->db->from('question');
        $this->db->where('que_srl', $que_srl);
        $this->db->where('status', 'use');
        $result = $this->db->get();
        return $result->row_array();
    } // }}}

    // 댓글 좋아요 +1 업데이트
    public function update_question_answerlike($ans_srl) { // {{{
        $this->db->set('likes', 'likes+1', false);
        $this->db->where('ans_srl', $ans_srl);
        $this->db->update('answer');
        return $this->db->affected_rows();
    } // }}}

    // 댓글 좋아요 -1 업데이트
    public function update_question_answerdontlike($ans_srl) { // {{{
        $this->db->set('likes', 'likes-1', false);
        $this->db->where('ans_srl', $ans_srl);
        $this->db->update('answer');
        return $this->db->affected_rows();
    } // }}}

    // 보기 가져오기
    public function get_example($que_srl) { // {{{
        $this->db->select('*');
        $this->db->from('example');
        $this->db->where('que_srl', $que_srl);
        $this->db->where('status', 'use');
        $result = $this->db->get();
        return $result->result_array();
    } // }}}

}
