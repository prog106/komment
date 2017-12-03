<?php
/**
 * @ description : Answer dao
 * @ author : prog106 <prog106@gmail.com>
 */
class Answerdao extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    // 답글 저장
    public function save_answer($sql_param) { // {{{
        $this->db->set($sql_param);
        $this->db->insert('answer');
        return $this->db->insert_id();
    } // }}}

    // 정답 여부 저장
    public function save_correct($sql_param) { // {{{
        $sql = "INSERT INTO corrects (que_srl, mem_srl, exam_srl, create_at, correct, correct_total) ";
        if(!empty($sql_param['correct_total'])) {
            $sql .= " SELECT '".$sql_param['que_srl']."', '".$sql_param['mem_srl']."', '".$sql_param['exam_srl']."', '".$sql_param['create_at']."', '".$sql_param['correct']."', correct_total + 1 FROM corrects WHERE mem_srl = '".$sql_param['mem_srl']."' ORDER BY cor_srl DESC LIMIT 1";
        } else {
            $sql .= " SELECT '".$sql_param['que_srl']."', '".$sql_param['mem_srl']."', '".$sql_param['exam_srl']."', '".$sql_param['create_at']."', '".$sql_param['correct']."', correct_total FROM corrects WHERE mem_srl = '".$sql_param['mem_srl']."' ORDER BY cor_srl DESC LIMIT 1";
        }
        $this->db->query($sql, $sql_param);
        return $this->db->insert_id();
    } // }}}

    // 답글 리스트
    public function get_answer_list($sql_param, $paging, $limit, $mem_srl) { // {{{
        if(!empty($mem_srl)) {
            $this->db->select('A.*, LA.ans_srl AS la_srl');
        } else {
            $this->db->select('A.*');
        }
        $this->db->from('answer A');
        $this->db->join('members M', 'M.mem_srl = A.mem_srl');
        if(!empty($mem_srl)) {
            $this->db->join('likes_answer LA', 'A.ans_srl = LA.ans_srl AND LA.likes = \'like\' AND LA.mem_srl = '.$mem_srl, 'left');
        }
        $this->db->where($sql_param);
        $this->db->order_by('A.ans_srl ASC');
        $this->db->limit($limit, $paging);
        $result = $this->db->get();
        return $result->result_array();
    } // }}}

    // 답글 업데이트
    public function update_answer($sql_param, $que_srl) { // {{{
        $this->db->set($sql_param);
        $this->db->where('que_srl', $que_srl);
        $this->db->update('answer');
        return $this->db->affected_rows();
    } // }}}

    // 답글 업데이트 - 삭제
    public function update_answer_info($sql_param, $ans_srl) { // {{{
        $this->db->set($sql_param);
        $this->db->where('ans_srl', $ans_srl);
        $this->db->update('answer');
        return $this->db->affected_rows();
    } // }}}

    // 답글 가져오기
    public function get_answer_info($sql_param) { // {{{
        $this->db->where($sql_param);
        $result = $this->db->get('answer');
        return $result->row_array();
    } // }}}

    // 정답 정보 가져오기
    public function get_correct($sql_param) { // {{{
        $this->db->where($sql_param);
        $result = $this->db->get('corrects');
        return $result->result_array();
    } // }}}

    // 정답 || 투표 참여 정보 가져오기
    public function get_correct_percent($sql_param) { // {{{
        $sql = "SELECT exam_srl, correct, COUNT(*) as cnt FROM corrects WHERE que_srl = ? AND status = 'use' GROUP BY exam_srl, correct";
        $result = $this->db->query($sql, $sql_param);
        return $result->result_array();
    } // }}}

}
