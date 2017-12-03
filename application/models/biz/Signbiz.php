<?php
/**
 * @ description : Sign biz
 * @ author : prog106 <prog106@gmail.com>
 */
class Signbiz extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('dao/Signdao', 'signdao');
    }

    // sns 가입 여부 체크
    public function sns_login_member($mem_type, $efs_srl) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_type)) $sql_param['mem_type'] = $mem_type;
        else return $error_result;
        if(!empty($efs_srl)) $sql_param['efs_srl'] = $efs_srl;
        else return $error_result;
        return ok_result($this->signdao->sns_login_member($sql_param));
    } // }}}

    // sns 회원가입
    public function sns_member($mem_type, $efs_srl, $email, $name, $picture=null) { // {{{
        $sns_prm = array();
        $sns_prm = array(
            'mem_type' => $mem_type,
            'efs_srl' => $efs_srl,
        );
        $mem = $this->signdao->sns_login_member($sns_prm);
        $mem_info = array();
        if(!empty($mem)) {
            $name_prm = array();
            $mem_info['mem_srl'] = $mem['mem_srl'];
            $mem_info['level'] = $mem['status'];
            $mem_info['mem_name'] = $mem['mem_name'];
            $mem_info['mem_picture'] = $mem['mem_picture'];
            if($mem['mem_name'] !== $name) {
                $name_prm['mem_name'] = $name;
                $mem_info['mem_name'] = $name;
            }
            if($mem['mem_picture'] !== $picture) {
                $name_prm['mem_picture'] = $picture;
                $mem_info['mem_picture'] = $picture;
            }
            if(!empty($name_prm)) {
                // 이미 가입되어 있으면 정보를 갱신하지 않는다.
                //$this->signdao->sns_update_member($name_prm, $mem['mem_srl']);
            }
        } else {
            $mem_srl = self::save_member($mem_type, $efs_srl, $mem_type.$efs_srl, $mem_type, $mem_type, $name, $email, $picture);
            $mem_info['mem_srl'] = $mem_srl;
            $mem_info['level'] = 'normal';
            $mem_info['mem_name'] = $name;
            $mem_info['mem_picture'] = $picture;
        }
        $result = ok_result($mem_info);
        return $result;
    } // }}}

    // 회원 가입 처리
    public function sign_member($mem_type, $efs_srl, $email1, $email2, $pwd, $name, $email) { // {{{
        try {
            $this->db->trans_begin();

            // 회원 가입 저장
            $result = self::save_member($mem_type, $efs_srl, $email1, $email2, $pwd, $name, $email);
            if($result['result'] === 'error') throw new Exception($result['msg']);
            $step = $result['data'];
            // efs 정보 갱신
            $this->load->model('dao/Emailforsigndao', 'emailforsigndao');
            $efs_prm = array();
            $efs_prm['efs_status'] = 'auth';
            $efs_prm['efs_code'] = '';
            $this->emailforsigndao->update_emailforsign($efs_prm, $efs_srl);

            if($this->db->trans_status() === FALSE) throw new Exception('트랜잭션 오류입니다');

            $this->db->trans_commit();
            return ok_result(true);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            return error_result($msg);
        }
    } // }}}

    // 회원 가입 저장
    public function save_member($mem_type, $efs_srl, $email1, $email2, $pwd, $name, $email, $picture=null) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_type)) $sql_param['mem_type'] = $mem_type;
        else return $error_result;
        if(!empty($efs_srl)) $sql_param['efs_srl'] = $efs_srl;
        else return $error_result;
        if(!empty($email1)) $sql_param['mem_email1'] = $email1;
        else return $error_result;
        if(!empty($email2)) $sql_param['mem_email2'] = $email2;
        else return $error_result;
        if(!empty($pwd)) $sql_param['mem_pwd'] = $pwd;
        else return $error_result;
        if(!empty($name)) $sql_param['mem_name'] = $name;
        else return $error_result;
        if(!empty($email)) $sql_param['mem_email'] = $email;
        else return $error_result;
        if(!empty($picture)) $sql_param['mem_picture'] = $picture;
        $sql_param['create_datetime'] = YMD_HIS;
        return ok_result($this->signdao->save_member($sql_param));
    } // }}}

    // 로그인
    public function login_member($email1, $email2) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        $sql_param['mem_type'] = 'efs';
        if(!empty($email1)) $sql_param['mem_email1'] = $email1;
        else return $error_result;
        if(!empty($email2)) $sql_param['mem_email2'] = $email2;
        else return $error_result;
        return ok_result($this->signdao->login_member($sql_param));
    } // }}}

    // 회원 정보 가져오기
    public function get_member($mem_srl) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        else return $error_result;
        return ok_result($this->signdao->sns_login_member($sql_param));
    } // }}}

    // 회원 정보수정
    public function update_member($mem_srl, $name, $mem_email=null, $picture=null, $mem_noname, $member) { // {{{
        try {
            $this->db->trans_begin();

            $error_msg = '필수값이 누락되었습니다.';
            // 닉네임(mem_name) 이 최근 변경 이력이 있는지 체크
            if($name !== $member['mem_name']) {
                $prm = array();
                $prm['mem_srl'] = $mem_srl;
                $prm['log_type'] = 'mem_name';
                $log = $this->signdao->get_member_log($prm);
                $tm = time() - datetime_to_mktime($log['create_at']);
                if($tm < 604800) {
                    throw new Exception('닉네임을 '.$log['create_at'].' 에 변경하였습니다. 7일 이후 변경이 가능합니다.');
                }
            }
            $sql_param = array();
            if(empty($mem_srl)) return $error_result;
            if(!empty($name)) $sql_param['mem_name'] = $name;
            else throw new Exception($error_msg);
            $sql_param['mem_email'] = $mem_email;
            if(!empty($picture)) $sql_param['mem_picture'] = $picture;
            if(!empty($mem_noname)) $sql_param['mem_noname'] = $mem_noname;
            $result = $this->signdao->sns_update_member($sql_param, $mem_srl);
            if(empty($result)) throw new Exception('업데이트 실패하였습니다.');
            $log_param = array();
            if($name !== $member['mem_name']) {
                $log_param['mem_srl'] = $mem_srl;
                $log_param['log_type'] = 'mem_name';
                $log_param['before'] = $member['mem_name'];
                $log_param['after'] = $name;
                $log_param['ip'] = get_ip();
                $log_param['create_at'] = YMD_HIS;
                $result = $this->signdao->sns_update_member_log($log_param);
                if(empty($result)) throw new Exception('업데이트 실패하였습니다.');
            }
            if($mem_email !== $member['mem_email']) {
                $log_param['mem_srl'] = $mem_srl;
                $log_param['log_type'] = 'mem_email';
                $log_param['before'] = $this->encryption->encrypt($member['mem_email']);
                $log_param['after'] = $mem_email;
                $log_param['ip'] = get_ip();
                $log_param['create_at'] = YMD_HIS;
                $result = $this->signdao->sns_update_member_log($log_param);
                if(empty($result)) throw new Exception('업데이트 실패하였습니다.');
            }
            if(!empty($picture) && $picture !== $member['mem_picture']) {
                $log_param['mem_srl'] = $mem_srl;
                $log_param['log_type'] = 'mem_picture';
                $log_param['before'] = $member['mem_picture'];
                $log_param['after'] = $picture;
                $log_param['ip'] = get_ip();
                $log_param['create_at'] = YMD_HIS;
                $result = $this->signdao->sns_update_member_log($log_param);
                if(empty($result)) throw new Exception('업데이트 실패하였습니다.');
            }
            if($mem_noname !== $member['mem_noname']) {
                $log_param['mem_srl'] = $mem_srl;
                $log_param['log_type'] = 'mem_noname';
                $log_param['before'] = $member['mem_noname'];
                $log_param['after'] = $mem_noname;
                $log_param['ip'] = get_ip();
                $log_param['create_at'] = YMD_HIS;
                $result = $this->signdao->sns_update_member_log($log_param);
                if(empty($result)) throw new Exception('업데이트 실패하였습니다.');
            }

            if($this->db->trans_status() === FALSE) throw new Exception('트랜잭션 오류입니다');

            $this->db->trans_commit();
            return ok_result(true);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $msg = $e->getMessage();
            return error_result($msg);
        }
    } // }}}

    // 닉네임 체크
    public function get_nickname($name) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($name)) $sql_param['mem_name'] = $name;
        else return $error_result;
        return ok_result($this->signdao->sns_login_member($sql_param));
    } // }}}

    // 닉네임 정보
    public function get_member_log($log_type, $mem_srl) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        else return $error_result;
        $sql_param['log_type'] = $log_type;
        return ok_result($this->signdao->get_member_log($sql_param));
    } // }}}

    // 닉네임 변경 이력
    public function get_member_log_list($log_type, $mem_srl) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        else return $error_result;
        $sql_param['log_type'] = $log_type;
        return ok_result($this->signdao->get_member_log_list($sql_param));
    } // }}}

    // 개인의 질문 참여 통계
    public function get_member_correct_info($mem_srl) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        else return $error_result;
        return ok_result($this->signdao->get_member_correct_info($sql_param));
    } // }}}

    // 개인의 질문 참여 점수(point) 가져오기
    public function get_member_correct_point($mem_srl) { // {{{
        $error_result = error_result('필수값이 누락되었습니다.');
        $sql_param = array();
        if(!empty($mem_srl)) $sql_param['mem_srl'] = $mem_srl;
        else return $error_result;
        return ok_result($this->signdao->get_member_correct_point($sql_param));
    } // }}}

}
