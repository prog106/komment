<? $this->load->view('/lists/tbar', array('recent' => '', 'respond' => 'on', 'likes' => '', 'user' => ''), 'true'); ?>
<link rel="stylesheet" href="/static/css/swiper.min.css">
    <div class="row">
        <!-- div class="col-sm-12">
            <div class="swiper-container">
                <div class="swiper-wrapper">
<?
// 노출은 일~토 기준으로 하자
// 2016-01-31 ~ 2016-02-06 방식으로 보여주자
// 오늘날짜를 기준으로 최근 5주전 까지(선택주 포함)만 날짜 데이터를 가져오자
// 요일 date('w');
foreach($list as $k => $v) {
?>
                    <div class="swiper-slide">
                        <div class="media" style="margin-top:-30px;">
                            <div class="media-body">
                                <img src="<?=((!empty($v['mem_picture']) && $v['mem_level'] !== 'manager')?$v['mem_picture']:"/static/image/komment.png")?>" width="35" class="swipeimg"><br>
                                <span style="font-size:11px;line-height:25px;"><?=($v['mem_level'] !== 'manager')?$v['mem_name']:"Komment"?></span>
                                <h5 class="media-heading link" style="line-height:22px;cursor:pointer;margin:0 10px;overflow:hidden;height:40px;" data-link="/answer/view/<?=$v['que_srl']?>"><?=convert_hashtag($v['question'])?></h5>
                                <span style="font-size:11px;">응답 <?=number_format($v['respond'])?> &nbsp; 좋아요 <span id="likecount<?=$v['que_srl']?>"><?=number_format($v['likes'])?></span></span>
                            </div>
                        </div>
                    </div>
<?
}
?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div -->
        <div class="col-sm-12">
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?=$week['s']?> ~ <?=$week['e']?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
<?
for($i=1;$i<10;$i++) {
    $ws = date('Y-m-d', strtotime((($i-1)*7)+date('w')." day ago")); // 이전 주들의 시작요일인 일요일 날짜 구하기
    $we = date('Y-m-d', strtotime((($i-1)*7)+date('w')-(($i>1)?6:date('w'))." day ago")); // 이전 주들의 마지막요일인 토요일 날짜 구하기
?>
                    <li><a href="/lists/respond?weekstart=<?=$ws?>&weekend=<?=$we?>"><?=$ws?> (일) ~ <?=$we?> (토)</a></li>
<?
}
?>
                </ul>
            </div>
        </div>
        <div class="col-sm-12" id="respond_list" style="margin-top:15px;">
<?
foreach($result as $k => $v) {
    echo $this->load->view('lists/item', $v, true);
}
?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="text-align:center">
            <?=$paging?>
        </div>
    </div>
    <!-- button type="button" id="more" class="glyphicon glyphicon-chevron-down btn btn-default btn-sm" style="width:100%"> 더보기</button -->
<script>
var page_num = 1;
var timer    = setInterval(function () { scrollOK = true; }, 100);
var scrollOK = true;
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    //nextButton: '.swiper-button-next',
    //prevButton: '.swiper-button-prev',
    slidesPerView: 1,
    paginationClickable: true,
    spaceBetween: 30,
    loop: true,
    autoplay: 3000,
    autoplayDisableOnInteraction: false,
<?/*    effect: 'cube',
    grabCursor: true,
    cube: {
        shadow: true,
        slideShadows: true,
        shadowOffset: 10,
        shadowScale: 0.64
    }*/?>
});
$(document).ready(function() {
    $('#more').click(function() {
        get_question_list(page_num+1);
    });
    //get_question_list(1);
    function get_question_list(page_val){
        page_num = page_val;
        url = '/lists/ax_get_lists';
        data = {page:page_num,tp:'respond'};
        ax_post(url, data, function(d) {
            if(d.recordsTotal > 0){
                var len = d.data.length;
                var html = '';
                for(var i = 0 ; i < len ; i++){
                    if(i > 4) {
                        var data = d.data[i];
                        html += data;
                    }
                }
                $('#respond_list').append(html);
                if(d.recordsTotal < 20) {
                    $('#more').hide();
                }
            } else {
                $('#more').hide();
            }
        });
    }
    $('.link').click(function() { window.location.href=$(this).data('link'); });
    function likes(que, already) {
        $('#like'+que).css('color', 'darkorange');
        $('#likethis'+que).data('status', true);
        if(!already) {
            $('#likecount'+que).text(parseInt($('#likecount'+que).text())+1);
        }
    }
    function dontlikes(que, already) {
        $('#like'+que).css('color', 'gray');
        $('#likethis'+que).data('status', false);
        if(!already) {
            $('#likecount'+que).text(parseInt($('#likecount'+que).text())-1);
        }
    }
    $('.likethis').click(function() {
        if($(this).data('status')) {
            var st = 'dontlike';
        } else {
            var st = 'like';
        }
        var url = '/like/ax_set_'+st;
        var que = $(this).data('question');
        var data = {question:que}
        ax_post(url, data, function(ret) {
            if(ret.result == 'ok') {
                already = true;
                if(ret.data != 'already') already = false;
                if(st == 'like') likes(que, already);
                else if(st == 'dontlike') dontlikes(que, already);
            } else {
                alert(ret.msg);
            }
        });
    });
});
</script>
