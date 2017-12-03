<? $this->load->view('/lists/tbar', array('recent' => '', 'respond' => '', 'likes' => '', 'user' => 'on'), 'true'); ?>
<style>
.filebox label {
    display: inline-block;
    padding: .5em .75em;
    margin-top: 5px;
    color: #999;
    font-size: inherit;
    line-height: normal;
    vertical-align: middle;
    background-color: #fdfdfd;
    cursor: pointer;
    border: 1px solid #ebebeb;
    border-bottom-color: #e2e2e2;
    border-radius: .25em;
}

.filebox input[type="file"] {  /* 파일 필드 숨기기 */
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip:rect(0,0,0,0);
    border: 0;
}
</style>
    <form class="form-horizontal" id="user_form" onsubmit="return false;">
    <input type="hidden" name="mem" value="<?=$info['mem_srl']?>">
    <input type="hidden" name="mem_noname" id="mem_noname" value="<?=$info['mem_noname']?>">
        <div class="form-group">
            <div class="col-sm-12" style="text-align:center">
                <img src="<?=$info['mem_picture']?>" id="review" class="img-circle">
                <!-- input type="file" name="picture" accept="image/jpg|gif|png" capture="camera" -->
                <div class="filebox">
                    <input type="hidden" name="photo" id="photo" value="">
                    <label for="ex_file">이미지 선택</label>
                    <input type="file" id="ex_file" value="" class="input input-file" accept="image/*"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="correct_info" class="col-sm-2 control-label">참여점수</label>
            <div class="col-sm-10"><span class="label label-default">레벨 <?=get_level($correct['total'])?></span> <?=number_format($correct['total'])?> 점
                (투표참여 <?=$correct['cor']?> / 정답 <?=$correct['yes']?> / 오답 <?=$correct['no']?>)
            </div>
        </div>
        <div class="form-group">
            <label for="mem_name" class="col-sm-2 control-label" style="color:crimson">닉네임(필수) - 변경 후 7일간 변경 불가</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" class="form-control" id="mem_name" name="mem_name" placeholder="닉네임(필수)" value="<?=$info['mem_name']?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="nickcheck">중복체크</button>
                        <button class="btn btn-default" type="button" id="nicklog">변경이력</button>
                    </span>
                </div>
                <span id="nickcheckst"></span>
            </div>
        </div>
        <div class="form-group" style="display:none;" id="nicknamelog">
            <div class="col-sm-offset-2 col-sm-10" id="nicknamelogs">
            </div>
        </div>
        <div class="form-group">
            <label for="mem_email" class="col-sm-2 control-label">이메일(선택)</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="mem_email" name="mem_email" placeholder="이메일" value="<?=$info['mem_email']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="regist" class="col-sm-2 control-label">익명 사용 여부</label>
            <div class="col-sm-10">
                <input class="btn btn-default<?=($info['mem_noname']=='Y')?" btn-success":""?>" type="button" id="noname" value="<?=($info['mem_noname']=='Y')?"익명을 사용합니다.":"닉네임을 사용합니다."?>">
            </div>
        </div>
        <div class="form-group">
            <label for="regist" class="col-sm-2 control-label">가입일</label>
            <div class="col-sm-10">
                <?=$info['create_datetime']?>
            </div>
        </div>
        <div class="form-group">
            <label for="from" class="col-sm-2 control-label">가입경로</label>
            <div class="col-sm-10">
                <?=strtoupper($info['mem_pwd'])?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" id="save" class="btn btn-default">저장하기</button>
            </div>
        </div>
    </form>

<script>
function nickchk(str) {
    return (str.match(/[^(ㄱ-ㅎ가-힝0-9a-zA-Z)]/)) ? false : true;
}
$(document).ready(function() {
    $('.link').click(function() { window.location.href=$(this).data('link'); });
    $('.input-file').each(function() {
        $(this).change(function() {
            if(window.FileReader){  // modern browser
                var filename = $(this)[0].files[0].name;
            }
            else {  // old IE
                var filename = $(this).val().split('/').pop().split('\\').pop();  // 파일명만 추출
            }
            var url = '/sign/ax_set_uploads';
            var formData = new FormData();
            formData.append('imageData', $(this)[0].files[0]);
            var data = formData;
            ax_post_file(url, data, function(ret) {
                console.log(ret);
                if(ret.result == 'ok') {
                    $('#photo').val(ret.thumb_name);
                    $('#review').attr('src', ret.thumb_name);
                } else {
                    alert(ret.msg);
                }
            });
        });
    });
    var flip = 0;
    $('#nicklog').click(function() {
        var url = '/sign/ax_get_infolog';
        var data = null;
        $('#nicknamelog').toggle(function() {
            if(flip++ % 2 === 0) {
                ax_post(url, data, function(ret) {
                    if(ret.result == 'ok') {
                        $('#nicknamelogs').html(ret.data);
                    } else {
                        $('#nicknamelogs').text('변경이력이 없습니다.');
                    }
                });
            }
        });
    });
    var nickauth = true;
    $('#nickcheck').click(function() {
        if(!$('#mem_name').val()) {
            alert('닉네임을 입력해 주세요.');
            return false;
        }
        if(!nickchk($('#mem_name').val())) {
            alert('한글, 숫자, 영문 조합으로 입력해 주세요.\n\n(특수문자, 공백 등 사용 불가)');
            return false;
        }
        var url = '/sign/ax_get_nickname';
        var data = {nickname:$('#mem_name').val()};
        ax_post(url, data, function(ret) {
            if(ret.result == 'ok') {
                $('#nickcheckst').css('color', '').text('사용이 가능한 닉네임입니다.');
                nickauth = true;
            } else {
                $('#nickcheckst').css('color', 'crimson').text(ret.msg);
                nickauth = false;
            }
        });
    });
    $('#noname').click(function() {
        $(this).toggleClass('btn-success');
        if($('#mem_noname').val() == 'Y') {
            $('#mem_noname').val('N');
            $(this).val('닉네임을 사용합니다.');
        } else {
            $('#mem_noname').val('Y');
            $(this).val('익명을 사용합니다.');
        }
    });
    $('#mem_name').change(function() {
        $('#nickcheckst').css('color', 'crimson').text('닉네임 중복체크 해주세요.');
        nickauth = false;
    });
    $('#save').click(function() {
        if(!nickauth) {
            alert('닉네임 중복체크를 해 주세요.');
            return false;
        }
        var url = '/sign/ax_set_info';
        var data = $('#user_form').serialize();
        ax_post(url, data, function(ret) {
            if(ret.result == 'ok') {
                alert('저장되었습니다.');
                window.location.reload();
            } else {
                if(ret.msg == 'loginerror') {
                    alert('다시 로그인 후 이용해 주세요.');
                    window.location.href='/sign/logout';
                } else {
                    alert(ret.msg);
                }
            }
        });
    });
});
</script>
