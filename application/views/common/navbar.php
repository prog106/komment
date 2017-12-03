<div class="slidemenu slidemenu-left">
    <div class="slidemenu-header">
        <div>
            코멘트
        </div>
    </div>
    <div class="slidemenu-body">
        <ul class="slidemenu-content">
<?
if(!empty($member)) {
?>
            <li>
                <a href="/sign/info">
                    <img src="<?=$member['mem_picture']?>" width="50">
                    <span style="position:absolute;line-height:45px;margin-left:7px;"><?=(($member['level']==='manager')?"[관리자] ":"")?> <?=$member['mem_name']?> 님</span>
                </a>
            </li>
            <li><a href="javascript:;" id="logout"><span class="glyphicon glyphicon-off"></span> 로그아웃</a></li>
            <!-- li><a href="/lists/recent"><span class="glyphicon glyphicon-send"></span> 최신 질문 보기</a></li>
            <li><a href="/lists/respond"><span class="glyphicon glyphicon-star"></span> 인기 질문 보기</a></li>
            <li><a href="/lists/close"><span class="glyphicon glyphicon-time"></span> 마감 임박 질문 보기</a></li -->
            <!-- li><a href="javascript:alert('준비중');">[준비중] 내가 올린 질문</a></li -->
            <li><a href="/question/lists"><span class="glyphicon glyphicon-comment"></span> 내가 올린 질문</a></li>
            <li><a href="/question/"><span class="glyphicon glyphicon-pencil"></span> 글쓰기</a></li>
<?
} else {
?>
            <li><a href="/">다른 질문 보기</a></li>
            <li><a href="/sign/login/?url=<?=$this->input->server('REQUEST_URI')?>">로그인</a></li>
<?
}
?>
        </ul>
    </div>
</div>
<script src="/static/js/kakao.min.js"></script>
<script>
$(document).ready(function() {
<?
if(!empty($member)) {
?>
    $('#logout').click(function() {
        if(!confirm('로그아웃 하시겠습니까?')) {
            return false;
        }
        var url = '/sign/ax_get_logout';
        ax_post(url, null, function(ret) {
            if(ret.result == 'ok') {
                alert('로그아웃 되었습니다.');
                window.location.href='<?=$this->input->server('REQUEST_URI')?>';
            } else {
                alert(ret.msg);
            }
        });
    });
<?
}
?>
    var menu = SpSlidemenu('#main', '.slidemenu-left', '.menu-button-left', {direction: 'left'});
    $('#gohome').click(function() { window.location.href='/'; });
});
// 사용할 앱의 JavaScript 키를 설정해 주세요.
Kakao.init('c5db39cae6afde0c07ba83fdb3cb6a47');
function kakaotalk(txt) {
    Kakao.Link.sendTalkLink({
        label : "코멘트" ,
<?/*        image: {
            src: 'http://komment.co.kr/static/image/komment.png',
            width: '145',
            height: '190'
        },*/?>
        webLink : {
            text: txt, 
            url: 'http://komment.co.kr<?=$this->input->server('REQUEST_URI', true);?>' // 앱 설정의 웹 플랫폼에 등록한 도메인의 URL이어야 합니다.
        }
    });
}
function kakaostory() {
    var win = window.open('http://story.kakao.com/share?url=http://komment.co.kr<?=$this->input->server('REQUEST_URI', true);?>','kakaostory','width=550px,height=440px');
    if(win) { win.focus(); }
}
function facebook() {
    var win = window.open('http://www.facebook.com/sharer/sharer.php?u=http://komment.co.kr<?=$this->input->server('REQUEST_URI', true);?>','facebook','width=550px,height=440px');
    if(win) { win.focus(); }
}
$(function() {
    $('#kakaotalk').click(function() { kakaotalk($(this).data('txt')); });
    $('#kakaostory').click(function() { kakaostory(); });
    $('#facebook').click(function() { facebook(); });
});
</script>
<div id="main">
    <header id="header">
        <span style="font-size:20px;margin-top:9px;position:absolute;top:0;left:50%;margin-left:-30px;padding:6px 5px;cursor:pointer;" id="gohome">코멘트</span>
        <span class="button menu-button-left" style="cursor:pointer"></span>
        <!-- span class="button" onclick="history.back();" style="cursor:pointer;right:0px;border-left:1px solid #ddd;background-image:url('');font-size:25px;line-height:55px;padding-left:10px;"><span class="glyphicon glyphicon-arrow-left" style="color:#666"></span></span -->
    </header>
    <div class="container theme-showcase" role="main" style="padding-top:10px">
