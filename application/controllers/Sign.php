<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct() {
        parent::__construct();
        $this->load->library(array('common','encryption', 'SnsLogin'));
        $this->load->helper('url');
        $this->load->model('biz/Emailforsignbiz', 'emailforsignbiz');
        $this->efs_hour = "2"; // 인증 가능 시간
        $this->efs_url = "http://komment.co.kr/sign/auth/";
    }

    // 회원가입 절차 1단계
    public function sign() { // {{{
        load_view('sign/sign');
	} // }}}

    // 회원가입 절차 2단계
    public function auth() { // {{{
        $efs_code = $this->input->get('efs_code', true);
        $result = $this->emailforsignbiz->get_emailforsign(null, null, null, $efs_code);
        // step 전달 받은 이메일 주소 처리
        if($result['result'] != 'ok') alertmsg_move('유효한 경로가 아닙니다.', '/');
        $step = (!empty($result['data']))?$result['data'][0]:array();
        if(empty($step)) alertmsg_move('유효한 경로가 아닙니다.', '/');
        if($step['efs_status'] === 'auth') alertmsg_move('인증된 URL 입니다.', '/');
        if($step['start_datetime'] > YMD_HIS || $step['end_datetime'] < YMD_HIS) alertmsg_move('인증 기간이 만료된 URL 입니다.', '/');
        $email1 = $this->encryption->decrypt($step['email1']);
        $email2 = $step['email2'];
        $data = array();
        $data['email1'] = $email1;
        $data['email2'] = $email2;
        $data['end'] = $step['end_datetime'];
        $data['efs_srl'] = $step['efs_srl'];
        load_view('sign/signform', $data);
    } // }}}

    // 로그인
    public function login() { // {{{
        $member = $this->session->userdata('loginmember');
        if(!empty($member)) redirect('/', 'refresh');
        $data = array();
        $data['sign'] = true;
        $url = $this->input->get('url');
        $data['url'] = $url;
        load_view('sign/login', $data);
    } // }}}

    // 이메일 회원가입 efs
    public function ax_set_emailforsign() { // {{{
        $email1 = $this->input->post('email1', true);
        $email2 = $this->input->post('email2', true);
        $this->load->helper('email');
        if(valid_email($email1."@".$email2)) {
            // email1 암호화 + efs_code 생성 + start & end
            $email1 = $this->encryption->encrypt($email1);
            $efs_code = $this->encryption->encrypt($email1);
            $start_datetime = YMD_HIS;
            $end_datetime = date('Y-m-d H:i:s', strtotime('+ '.$this->efs_hour.' hour'));
            $result = $this->emailforsignbiz->check_emailforsign($email1, $email2, $efs_code, $start_datetime, $end_datetime);
            if($result['result'] === 'ok') {
                // 이메일 발송
                $url = $this->efs_url."?efs_code=".urlencode($efs_code);
                $result['url'] = $url;
                //debug_log($url);
            }
        } else {
            $result = array('result' => 'notemail', 'msg' => '이메일 주소를 다시 확인해 주세요');
        }
        echo json_encode($result);
    } // }}}

    // facebook 회원가입 & 로그인
    public function facebooklogin() { // {{{
        $member = $this->session->userdata('loginmember');
        $url = $this->input->get('url', true);
        if(!empty($member)) {
            redirect('/', 'refresh');
            //close_reload();
            die;
        }

        $this->load->library('facebook'); // Automatically picks appId and secret from config
        $user = $this->facebook->getUser();
        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me?fields=name,email,picture');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }else {
        }

        if ($user) {
            $this->load->model('biz/Signbiz', 'signbiz');
            $result = $this->signbiz->sns_login_member('facebook', $data['user_profile']['id']);
            if($result['result'] === 'ok') {
                $mem = $result['data'];
                // 가입이 안되어 있으면 가입 처리
                if(empty($mem)) {
                    self::save_sign('facebook', $data['user_profile']['id'], $data['user_profile']['email'], $data['user_profile']['name'], $data['user_profile']['picture']['data']['url'], 0); 
                    redirect('/sign/joins', 'refresh');
                    //close_reload('/sign/joins');
                    die;
                // 가입이 되어 있으면 로그인 처리
                } else {
                    if(in_array($mem['status'], array('normal', 'manager'))) {
                        self::save_login($mem['mem_srl'], $this->encryption->decrypt($mem['mem_email']), $mem['mem_name'], $mem['status'], $mem['mem_noname'], $mem['mem_picture']);
                        $url = (!empty($url))?$url:"/";
                        redirect($url, 'refresh');
                        //close_reload();
                        die;
                    } else {
                        alertmsg_move('로그인을 할 수 없는 정보입니다.');
                    }
                }
            } else {
                alertmsg_move('로그인에 문제가 있습니다. 잠시후 다시 시도해 주세요.');
            }
            die;
            /*// 회원가입 시킨다. facebook id, email, picture 
            $mem = $this->signbiz->sns_member('facebook', $data['user_profile']['id'], $this->encryption->encrypt($data['user_profile']['email']), $data['user_profile']['name'], $data['user_profile']['picture']['data']['url']);
            if(!empty($mem) && $mem['result'] === 'ok') {
                $mem_srl = $mem['data']['mem_srl'];
                $level = $mem['data']['level'];
                $picture = $mem['data']['mem_picture'];
                self::save_sign($mem_srl, $data['user_profile']['email'], $data['user_profile']['name'], $level, $picture);
                close_reload();
            } else {
                alertmsg_move('로그인을 실패하였습니다.');
            }
            die;
            $data['logout_url'] = site_url('sign/logout'); // Logs off application*/
        } else {
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>응답하라</title>
    <script src=\"/static/js/jquery-1.11.3.min.js\"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel=\"stylesheet\" href=\"/static/css/bootstrap.min.css\">

    <!-- Optional theme -->
    <link rel=\"stylesheet\" href=\"/static/css/bootstrap-theme.min.css\">

    <!-- Latest compiled and minified JavaScript -->
    <script src=\"/static/js/bootstrap.min.js\"></script>
</head>
<body>
<div class=\"col-xs-12 col-sm-12 progress-container\">
    <div class=\"progress progress-striped active\">
        <div class=\"progress-bar progress-bar-success\" style=\"width:0%\"></div>
    </div>
</div>
<h5>Facebook 접속중입니다... 잠시만 기다려 주세요...</h5>
<script>
function timeout() {
    setTimeout(function () {
        $(\".progress-bar\").animate({
            width: \"+=5%\"
        }, \"slow\");
        timeout();
    }, 800);
}
timeout();
</script>
</body>
</html>";
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => 'http://komment.co.kr/sign/facebooklogin?url='.$url, 
                'scope' => array('user_birthday,public_profile,email'), // permissions here
            ));
            redirect($data['login_url'], 'refresh');
        }
    } // }}}

    // 카카오 회원가입 & 로그인
    public function kakaologin() { // {{{
        $member = $this->session->userdata('loginmember');
        if(!empty($member)) {
            redirect('/', 'refresh');
            //close_reload();
            die;
        }
        if (isset($_GET['code'])) {

            require_once realpath(dirname(__FILE__).'/../libraries/SNS_OAuth/').'/kakao_oauth.php';

            $url = "https://kauth.kakao.com/oauth/token";
            
            $param = "grant_type=authorization_code";
            $param .= "&client_id=".$kakao_api;
            $param .= "&redirect_url=".$kakao_redirect;
            $param .= "&code=".$_GET['code'];

            // Get Aeccess Token Value
            $auth_data = $this->common->restful_curl($url, $param, 'POST');
            $auth_data = json_decode($auth_data);

            if($auth_data->access_token) {

                $_SESSION['kakao_token'] = $auth_data->access_token;
                
                $url = "https://kapi.kakao.com/v1/user/me";
                $param = "";
                $header = array("Authorization: Bearer " .$auth_data->access_token);


                // Get User Info
                $user_data = $this->common->restful_curl($url, $param, 'POST', $header);
                $user_data = json_decode($user_data);
                $properties = $user_data->properties;

                $kakao_id = $user_data->id;
                $kakao_nickname = $properties->nickname;
                $kakao_picture = $properties->thumbnail_image;

                if(!empty($kakao_id) && !empty($kakao_nickname)) {
                    $this->load->model('biz/Signbiz', 'signbiz');
                    $result = $this->signbiz->sns_login_member('kakao', $kakao_id);
                    if($result['result'] === 'ok') {
                        $mem = $result['data'];
                        // 가입이 안되어 있으면 가입 처리
                        if(empty($mem)) {
                            self::save_sign('kakao', $kakao_id, '', $kakao_nickname, $kakao_picture, 0, $auth_data->access_token); 
                            redirect('/sign/joins', 'refresh');
                            //echo json_encode(error_result('joins'));
                        // 가입이 되어 있으면 로그인 처리
                        } else {
                            if(in_array($mem['status'], array('normal', 'manager'))) {
                                self::save_login($mem['mem_srl'], $this->encryption->decrypt($mem['mem_email']), $mem['mem_name'], $mem['status'], $mem['mem_noname'], $mem['mem_picture'], $auth_data->access_token);
                                redirect('/', 'refresh');
                                //echo json_encode(ok_result());
                            } else {
                                redirect('/sign/login', 'refresh');
                                //echo json_encode(error_result('로그인을 할 수 없는 정보입니다.'))'N', ;
                            }
                        }
                    } else {
                        redirect('/sign/login', 'refresh');
                        //echo json_encode(error_result());
                    }
                }

            }else {
                redirect('/sign/login', 'refresh');
            }

        }else {
            redirect('/sign/login', 'refresh');
        } 
    } // }}}

    // 카카오 회원가입 & 로그인
    /*public function ax_set_kakao() { // {{{
        $kakao_id = $this->input->post('id', true);
        $kakao_nickname = $this->input->post('name', true);
        $kakao_picture = $this->input->post('picture', true);
        if(!empty($kakao_id) && !empty($kakao_nickname)) {
            $this->load->model('biz/Signbiz', 'signbiz');
            $result = $this->signbiz->sns_login_member('kakao', $kakao_id);
            if($result['result'] === 'ok') {
                $mem = $result['data'];
                // 가입이 안되어 있으면 가입 처리
                if(empty($mem)) {
                    self::save_sign('kakao', $kakao_id, '', $kakao_nickname, $kakao_picture); 
                    echo json_encode(error_result('joins'));
                // 가입이 되어 있으면 로그인 처리
                } else {
                    if(in_array($mem['status'], array('normal', 'manager'))) {
                        self::save_login($mem['mem_srl'], $this->encryption->decrypt($mem['mem_email']), $mem['mem_name'], $mem['status'], $mem['mem_picture']);
                        echo json_encode(ok_result());
                    } else {
                        echo json_encode(error_result('로그인을 할 수 없는 정보입니다.'));
                    }
                }
            } else {
                echo json_encode(error_result());
            }
            die;
        }
        echo json_encode(error_result());
        die;
    } // }}}*/

    // 회원가입
    public function ax_set_sign() { // {{{
        $email1 = $this->input->post('email1', true);
        $email2 = $this->input->post('email2', true);
        $efs_srl = $this->input->post('efs_srl', true);
        $pwd = $this->input->post('pwd', true);
        $pwd1 = $this->input->post('pwd1', true);
        $name = $this->input->post('name', true);
        // 회원가입시 체크할 꺼 - 이메일주소와 efs_srl 비교, 비밀번호 비교
        $result = $this->emailforsignbiz->get_emailforsign($efs_srl);
        $step = $result['data'][0];
        $save_email1 = $this->encryption->decrypt($step['email1']);
        if($save_email1 !== $email1 || $step['email2'] !== $email2 || $step['efs_srl'] !== $efs_srl || empty($pwd) || $pwd !== $pwd1 || empty($name) || $step['efs_status'] !== 'notauth') {
            echo json_encode(error_result('필수값이 누락되었습니다.'));
            die;
        }

        $email = $this->encryption->encrypt($email1."@".$email2); // 이메일 전체 암호화 저장
        $email1 = sha1($email1); // @ 앞자리 md5 저장 - 로그인시 필요
        $pwd = password_hash($pwd, PASSWORD_BCRYPT); // 비밀번호 암호화

        $this->load->model('biz/Signbiz', 'signbiz');
        $result = $this->signbiz->sign_member('efs', $efs_srl, $email1, $email2, $pwd, $name, $email);
        echo json_encode($result);
    } // }}}

    // 로그인
/*    public function ax_get_login() { // {{{
        $email = $this->input->post('email', true);
        $pwd = $this->input->post('pwd', true);
        if(empty($email) || empty($pwd)) {
            echo json_encode(error_result('필수값이 누락되었습니다.'));
            die;
        }
        list($email1, $email2) = explode("@", $email);
        $email1 = sha1($email1);
        $this->load->model('biz/Signbiz', 'signbiz');
        $result = $this->signbiz->login_member($email1, $email2);
        if($result['result'] !== 'ok' || empty($result['data'])) {
            echo json_encode(error_result('회원정보가 없습니다.'));
            die;
        }
        $info = $result['data'][0];
        if($info['status'] === 'normal') {
            if(password_verify($pwd, $info['mem_pwd'])) {
                $this->session->set_userdata('loginmember', $loginmember);
                self::save_login($info['mem_srl'], $email, $info['mem_name']);
                echo json_encode(ok_result());
                die;
            } else {
                echo json_encode(error_result('회원정보가 일치하지 않습니다.'));
                die;
            }
        } else if($info['status'] === 'hold') {
            echo json_encode(error_result('로그인이 불가능 합니다.'));
            die;
        } else {
            echo json_encode(error_result('회원정보가 없습니다.'));
            die;
        }

    } // }}}
*/
    // 일반 로그아웃
    public function logout() { // {{{
        $this->load->library('facebook');
        $this->facebook->destroySession();
        $loginmember = $this->session->userdata('loginmember');
        if(!empty($loginmember)) {
            $this->session->unset_userdata('loginmember');
        }
        redirect('/', 'refresh');
    } // }}}

    // 로그아웃
    public function ax_get_logout() { // {{{
        $this->load->library('facebook');
        $this->facebook->destroySession();
        $loginmember = $this->session->userdata('loginmember');
        if(!empty($loginmember)) {
            $this->session->unset_userdata('loginmember');
        }
        echo json_encode(ok_result());
    } // }}}

    // no login
    public function ax_set_nologin() { // {{{
        $cookie = array(
            'name' => 'nologin',
            'value' => 'true',
            'expire' => '0',
        );
        $this->input->set_cookie($cookie);
        echo json_encode(ok_result());
    } // }}}

    // sns 를 통한 회원가입
    public function joins() { // {{{
        $member = $this->session->userdata('loginmember');
        if(!empty($member)) redirect('/', 'refresh');
        $data = array();
        $sign = $this->session->tempdata();
        if(empty($sign)) {
            redirect('/sign/login', 'refresh');
            die;
        }
        $data['sign'] = $sign;
        load_view('sign/joins', $data);
    } // }}}

    // 회원 가입을 위한 세션 저장
    private function save_sign($type, $srl, $email, $name, $picture=null) { // {{{
        if(!empty($type) && !empty($name) && !empty($srl)) {
            $name = preg_replace("/\s+/","",$name); // 닉네임 공백 제거
            $signmember = array(
                'sign_srl' => $srl,
                'sign_type' => $type,
                'sign_email' => $email,
                'sign_name' => $name,
                'sign_picture' => $picture,
            );
            // 5분후 사라지는 세션 생성
            $this->session->set_tempdata($signmember, NULL, 60*5);
        }
    } // }}}

    // 로그인 세션 저장
    private function save_login($srl, $email, $name, $level, $noname, $picture=null, $access_token=null) { // {{{
        if($srl > 0) {
            // 로그인 성공
            $loginmember = array(
                'mem_srl' => $srl,
                'mem_email' => $email,
                'mem_name' => $name,
                'mem_picture' => $picture,
                'mem_noname' => $noname,
                'level' => $level,
                'token' => $access_token,
            );
            $this->session->set_userdata('loginmember', $loginmember);
        }
    } // }}}

    // 정보 확인 & 수정
    public function info() { // {{{
        $member = $this->session->userdata('loginmember');
        if(empty($member)) redirect('/', 'refresh');
        $this->load->model('biz/Signbiz', 'signbiz');
        $result = $this->signbiz->get_member($member['mem_srl']);
        if($result['result'] !== 'ok') redirect('/', 'refresh');
        $info = $result['data'];
        if(empty($info) || (!empty($info) && !in_array($info['status'], array('normal', 'manager')))) redirect('/', 'refresh');
        $corrects = $this->signbiz->get_member_correct_info($member['mem_srl']);
        $correct = array('total' => 0, 'yes' => 0, 'no' => 0, 'cor' => 0);
        foreach($corrects['data'] as $k => $v) {
            if($v['correct'] === 'Y') {
                $correct['yes'] = $v['count'];
                $correct['total'] += $v['count'];
                $correct['yn'] += $v['count'];
            }
            if($v['correct'] === 'N') {
                $correct['no'] = $v['count'];
                //$correct['total'] += $v['count'];
                $correct['yn'] += $v['count'];
            }
            if($v['correct'] === 'C') {
                $correct['cor'] = $v['count'];
                $correct['total'] += $v['count'];
            }
        }
        $info['mem_email'] = $this->encryption->decrypt($info['mem_email']);
        $data['member'] = $member;
        $data['info'] = $info;
        $data['correct'] = $correct;
        load_view('sign/info', $data);
    } // }}}

    // 회원 정보 수정
    public function ax_set_info() { // {{{
        $member = $this->session->userdata('loginmember');
        $mem_srl = $this->input->post('mem', true);
        $name = trim(strip_tags($this->input->post('mem_name', true)));
        $noname = $this->input->post('mem_noname', true);
        $mem_email = $this->input->post('mem_email', true);
        $mem_photo = $this->input->post('photo', true);
        if($member['mem_srl'] !== $mem_srl) {
            echo json_encode(error_result('loginerror'));
            die;
        }
        $this->load->helper('email');
        if(!empty($mem_email) && !valid_email($mem_email)) {
            echo json_encode(error_result('이메일 주소를 확인해 주세요.'));
            die;
        } else {
            $email = $this->encryption->encrypt($mem_email);
        }
        $picture = null;
        $this->load->model('biz/Signbiz', 'signbiz');
        $result = $this->signbiz->update_member($mem_srl, $name, $email, $mem_photo, $noname, $member);
        if($result['result'] === 'ok') {
            $mem_srl = $member['mem_srl'];
            //$mem_email = $member['mem_email'];
            $level = $member['level'];
            $picture = (!empty($mem_photo))?$mem_photo:$member['mem_picture'];
            // 로그아웃 후 다시 로그인 처리
            $this->session->unset_userdata('loginmember');
            self::save_login($mem_srl, $mem_email, $name, $level, $noname, $picture);
            echo json_encode(ok_result());
        } else {
            echo json_encode(error_result($result['msg']));
        }
    } // }}}

    // 회원 가입
    public function ax_set_sns_sign() { // {{{
        $member = $this->session->userdata('loginmember');
        $sign = $this->session->tempdata();
        if(!empty($member) || empty($sign)) {
            echo json_encode(error_result());
            die;
        }
        $efs_srl = $this->input->post('mem', true);
        $mem_type = $this->input->post('from', true);
        $mem_email1 = $mem_type.$efs_srl;
        $mem_email2 = $mem_type;
        $mem_email = $this->input->post('mem_email', true);
        $mem_name = trim(strip_tags($this->input->post('mem_name', true)));
        $mem_name = preg_replace("/\s+/","",$mem_name); // 닉네임 공백 제거
        $mem_pwd = $mem_type;
        $mem_picture = $this->input->post('picture', true);
        if($sign['sign_srl'] != $efs_srl || $sign['sign_type'] != $mem_type) {
            echo json_encode(error_result());
            die;
        }
        $this->load->helper('email');
        if(!empty($mem_email) && !valid_email($mem_email)) {
            echo json_encode(error_result('이메일 주소를 확인해 주세요.'));
            die;
        }
        $this->load->model('biz/Signbiz', 'signbiz');
        $result = $this->signbiz->save_member($mem_type, $efs_srl, $mem_email1, $mem_email2, $mem_type, $mem_name, $this->encryption->encrypt($mem_email), $mem_picture);
        if($result['result'] === 'ok' && $result['data'] > 0) {
            self::save_login($result['data'], $mem_email, $mem_name, 'normal', 'N', $mem_picture, 0);
            echo json_encode(ok_result());
            die;
        }
        echo json_encode(error_result());
    } // }}}

    // 닉네임 중복체크
    public function ax_get_nickname() { // {{{
        $member = $this->session->userdata('loginmember');
        $name = $this->input->post('nickname', true);
        $name = preg_replace("/\s+/","",$name); // 닉네임 공백 제거
        if(empty($name)) {
            echo json_encode(error_result());
            die;
        }
        $this->load->model('biz/Signbiz', 'signbiz');
        $mem_srl = $member['mem_srl'];
        $log_type = 'mem_name';
        $log = $this->signbiz->get_member_log($log_type, $mem_srl);
        if($log['result'] === 'ok' && !empty($log['data'])) {
            $tm = time() - datetime_to_mktime($log['data']['create_at']);
            if($tm < 604800) {
                echo json_encode(error_result('닉네임을 '.$log['data']['create_at'].' 에 변경하였습니다. 7일 이후 변경이 가능합니다.'));
                die;
            }
        }
        $result = $this->signbiz->get_nickname($name);
        if($result['data']['mem_srl'] === $member['mem_srl']) {
            echo json_encode(error_result('본인이 사용중인 닉네임입니다.'));
            die;
        }
        if($result['result'] === 'ok') {
            if(empty($result['data'])) {
                echo json_encode(ok_result());
                die;
            }
        }
        echo json_encode(error_result('이미 사용중인 닉네임입니다.'));
    } // }}}

    // 회원정보 변경 이력 가져오기
    public function ax_get_infolog() { // {{{
        $member = $this->session->userdata('loginmember');
        $this->load->model('biz/Signbiz', 'signbiz');
        $mem_srl = $member['mem_srl'];
        $log_type = 'mem_name';
        $log = $this->signbiz->get_member_log_list($log_type, $mem_srl);
        if($log['result'] === 'ok') {
            $data = null;
            foreach($log['data'] as $k => $v) {
                $data .= $v['before']." > ".$v['after']." - ".$v['create_at']."<br>";
            }
            $result = array();
            $result['result'] = 'ok';
            $result['data'] = (empty($data))?"닉네임 변경이력이 없습니다":$data;
        } else {
            $result = array();
            $result['result'] = 'nok';
            $result['data'] = array();
        }
        echo json_encode($result);
    } // }}}

    // 이미지 올리기
    public function ax_set_uploads() { // {{{
        $result = array('result' => 'nok', 'msg' => '업로드에 실패하였습니다.');
        if(!empty($_FILES)) {
            $file_name = $_FILES['imageData']['name'];
            $tmp_name = $_FILES['imageData']['tmp_name'];
            $file_size = $_FILES['imageData']['size'];
            if($file_size > 10000) {
            }
            if(!empty($file_name) && !empty($tmp_name)) {
                $fileParts = pathinfo($_FILES['imageData']['name']);
                $targetPath = $_SERVER['DOCUMENT_ROOT']."/uploads";
                $code = '';
                for ($i=1;$i<=4;$i++ ) { // 8자리 난수 발생
                    $code .= substr('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', rand(0,61), 1);
                }
                $targetFilename = time().$code;
                $targetFile = rtrim($targetPath,'/').'/'.$targetFilename.".".$fileParts['extension'];
                $targetFullname = "/uploads/".$targetFilename.".".$fileParts['extension'];
                $targetThumbname = "/uploads/".$targetFilename."_thumb.".$fileParts['extension'];
                $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
                if (in_array($fileParts['extension'],$fileTypes)) {
                    move_uploaded_file($tmp_name,$targetFile);
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].$targetFullname;
                    $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].$targetThumbname;
                    //$config['create_thumb'] = TRUE;
                    //$config['maintain_ratio'] = TRUE;
                    $config['width'] = 50;
                    $config['height'] = 50;
                    $this->load->library('image_lib', $config);
                    if(!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                    } else {
                        unlink($config['source_image']);
                        $result = array(
                            'result' => 'ok',
                            'file_name' => $file_name,
                            'tmp_name' => $targetFullname,
                            'thumb_name' => $targetThumbname,
                        );
                    }
                } else {
                    $result = array('result' => 'nok', 'msg' => '지원하는 이미지 형식이 아닙니다.');
                }
            }
        }
        echo json_encode($result);
    } // }}}
}
