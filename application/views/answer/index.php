    <div class="row">
        <div class="col-sm-12">
            <div class="media">
                <div class="media-left" style="padding-top:5px;">
                    <a href="#">
                        <img class="media-object" src="<?=((!empty($question['mem_picture']) && $question['mem_level'] !== 'manager')?$question['mem_picture']:"/static/image/komment.png")?>">
                    </a>
                </div>
                <div class="media-body">
                    <span style="font-size:11px;line-height:25px;"><span class="label label-default">레벨<?=get_level($question['mem_point'])?></span> <?=($question['mem_level'] !== 'manager')?$question['mem_name']:"Komment"?></span>
                    <span style="font-size:11px;float:right;margin-right:20px;margin-top:5px;"><?=remain_datetime($question['end_time'])?></span>
<?
if(!empty($question['question_image'])) {
?>
                    <h6><a href="<?=$question['question_image']?>"><img src="<?=$question['question_image']?>" style="border-radius:0px;width:auto;max-width:250px;height:auto"></a><br>(이미지를 클릭하시면 원본으로 보실수 있습니다.)</h6>
<?
}
?>
                    <h5 class="media-heading" style="line-height:22px;"><?=convert_hashtag($question['question'])?><? if($question['vote_count'] > 0) { ?><span style="font-size:12px"> (<?=$question['vote_count']?>개 선택)</span><? } ?></h5>
                    <span style="font-size:11px;">응답 <span id="respond"><?=number_format($question['respond'])?></span> &nbsp; 좋아요 <span id="likecount<?=$question['que_srl']?>"><?=number_format($question['likes'])?></span></span>
<?
if($question['mem_srl'] !== $member['mem_srl']) {
?>
                    <a href="javascript:;" class="likethis" id="likethis<?=$question['que_srl']?>" data-question="<?=$question['que_srl']?>" data-status="<?=(empty($like[$question['que_srl']]))?"false":"true"?>" style="float:right;margin-right:25px;"><span class="glyphicon glyphicon-thumbs-up" id="like<?=$question['que_srl']?>" style="font-size:22px;color:<?=(empty($like[$question['que_srl']]))?"gray":"darkorange"?>;"></span></a>
<?
}
?>
                    <!-- a href="javascript:;" id="answer_area_view" style="float:right;margin-right:25px;"><span class="glyphicon glyphicon-comment" style="font-size:20px;color:mediumorchid;"></span></a -->
                </div>
<?
if(!empty($example)) {
?>
            </div>
        </div>
        <div class="col-sm-12">
        <input type="hidden" id="vote_count" value="<?=$question['vote_count']?>">
            <div class="media">
                <div class="media-left" style="padding-top:5px;">
                </div>
                <div class="media-body">
<?
    //shuffle($example);
    foreach($example as $k => $v) {
        $text = "선택";
        $cor = "btn-primary";
        $dis = "";
        if($question['vote_count'] > 0) { // 투표
            if(!empty($correct)) {
                if(array_key_exists($v['exam_srl'], $correct)) {
                    if($correct[$v['exam_srl']]['correct'] === 'C') {
                        $text = "투표";
                        $cor = "btn-success";
                        $dis = "disabled";
                    }
                }
            }
            if($question['vote_count'] == count($correct)) {
                $dis = "disabled";
            }
        } else { // 객관식
            if(!empty($correct)) {
                $dis = "disabled";
                if(array_key_exists($v['exam_srl'], $correct)) {
                    if($correct[$v['exam_srl']]['correct'] === 'Y') {
                        $text = "정답";
                        $cor = "btn-success";
                        $dis = "disabled";
                    } else {
                        $text = "오답";
                        $cor = "btn-danger";
                        $dis = "disabled";
                    }
                } else {
                    if($v['answer'] === 'Y') {
                        $text = "정답";
                        $cor = "btn-warning";
                    }
                }
            }
        }
        if($question['end_time'] < YMD_HIS) {
            $dis = "disabled";
        }
        $per = (!empty($percent[$v['exam_srl']]['cnt']))?($percent[$v['exam_srl']]['cnt']/$total_percent)*100:0;
        $count = (!empty($percent[$v['exam_srl']]['cnt']))?$percent[$v['exam_srl']]['cnt']:0;
        if($question['vote_count'] > 0) { // 투표일 경우
?>
                    <h5><button type="button" class="btn btn-sm <?=$cor?> correct" <?=$dis?> data-example="<?=$v['exam_srl']?>" data-question="<?=$v['que_srl']?>" style="margin-right:10px;"><?=$text?></button><span style="position:absolute;margin:5px 15px 0 5px;"> <?=$k+1?>. <?=$v['example']?> <span style="font-size:10px;">( <?=number_format($count)?> - <?=round($per,1)?>% )</span></span></h5>
<?
        } else { // 객관식
?>
                    <h5><button type="button" class="btn btn-sm <?=$cor?> correct" <?=$dis?> data-example="<?=$v['exam_srl']?>" data-question="<?=$v['que_srl']?>" style="margin-right:10px;"><?=$text?></button><span style="position:absolute;margin:5px 15px 0 5px;"> <?=$k+1?>. <?=$v['example']?><? if($text === '정답') { ?> <span style="font-size:10px;">( 정답률 : <?=round($per,1)?>% )</span><? } ?></span></h5>
<?
        }
    }
?>
                </div>
<?
}
?>
            </div>
        </div>
        <div class="col-sm-12" style="margin-top:5px">
            <div class="input-group" style="left:45px;">
                <a id="kakaotalk" href="javascript:;" data-txt="<?=htmlspecialchars(convert_text($question['question'], false, false))?>"><img src="/static/image/kakao.png" style="margin:3px;border-radius:5px;width:30px;height:30px"></a>
                <a id="kakaostory" href="javascript:;"><img src="/static/image/kakaostory.png" style="margin:3px;border-radius:5px;width:30px;height:30px"></a>
                <a id="facebook" href="javascript:;"><img src="http://ttolo.kr/static/img/fb.jpg" style="margin:3px;border-radius:5px;width:30px;height:30px;"></a>
                
            </div>
            <hr style="margin-top:15px;margin-bottom:10px">
        </div>
        <div class="col-sm-12">
        <form id="answer_form" onsubmit="return false;">
        <input type="hidden" name="chnoname" value="<?=$member['mem_noname']?>" id="chnoname">
        <input type="hidden" name="question" id="question" value="<?=$question['que_srl']?>">
            <div class="input-group">
                <!-- label for="answer">응답하라</label -->
                <textarea class="form-control col-sm-3" name="answer" id="answer" rows="3" maxlength="500" placeholder="<?=($question['end_time'] < YMD_HIS)?"댓글을 등록할 수 없습니다.":((empty($member))?"로그인 후 이용해 주세요.":"댓글을 남겨주세요")?>"<?=(empty($member) || $question['end_time'] < YMD_HIS)?" READONLY":""?>></textarea>
                <span class="input-group-btn">
                    <button type="button" id="regist" class="btn btn-default" style="height:74px;"<?=(empty($member) || $question['end_time'] < YMD_HIS)?" disabled=\"disabled\"":"";?>><?=($member['mem_noname'] === 'Y')?"익명 ":""?>남기기</button>
                </span>
            </div>
        </form>
        </div>
        <div class="col-sm-12" id="answer_list">
        </div>
    </div>
    <!-- ul class="list-group" data-role="listview" data-inset="true" id="answer_list" style="margin-top:15px;">
    </ul -->
    <button type="button" id="more" class="glyphicon glyphicon-chevron-down btn btn-default btn-sm" style="width:100%"> 더보기</button>
<script type="text/javascript">
var page_num = 1;
var timer    = setInterval(function () { scrollOK = true; }, 100);
var scrollOK = true;
var noname = 0;
var vote_count = <?=$question['vote_count']?>;

$(document).ready(function(){
    $('#answer_area_view').click(function() { $('#answer_area').toggle("slow"); });
    $('.correct').click(function() {
        if(!confirm('선택하시겠습니까?')) return false;
        var cor = $(this);
        var url = "/answer/ax_set_correct";
        var data = {example:$(this).data('example'),question:$(this).data('question')}
        ax_post(url, data, function(ret) {
            if(ret.result == 'ok') {
                alert(ret.msg);
                if(vote_count > 0) {
                    cor.addClass('btn-success').text('투표').attr('disabled', true);
                    vt = 0;
                    $('.correct').each(function() {
                        if($(this).text() == '투표') {
                            vt++;
                        }
                    });
                    if(vt == vote_count) {
                        $('.correct').attr('disabled', true);
                    }
                } else {
                    if(ret.msg == '정답입니다.') {
                        cor.addClass('btn-success').text('정답');
                    } else {
                        cor.addClass('btn-danger').text('오답');
                    }
                    $('.correct').attr('disabled', true);
                }
            } else {
                alert(ret.msg);
            }
        });
    });
    $('#regist').click(function() {
        if(!$('#answer').val()) {
            alert('응답글이 없어요!');
            return false;
        }
        var url = "/answer/ax_set_answer";
        var data = $('#answer_form').serialize();
        ax_post(url, data, function(ret) {
            if(ret.result == 'ok') {
                self.location.reload();
            } else {
                alert(ret.msg);
            }
        });
    });

    $('#more').click(function() {
        get_answer_list(page_num+1);
    });
/*    $(window).on('scroll', function () {
        if (scrollOK) {
            scrollOK = false;
            if ($(this).scrollTop() + $(this).height() >= ($(document).height() - 5)) {
                get_answer_list(page_num+1);
            }
        }
    });
*/
    get_answer_list(1);
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

    function get_answer_list(page_val){
        page_num = page_val;
        url = '/answer/ax_get_answer';
        data = {page:page_num,question:$('#question').val()};
        ax_post(url, data, function(d) {
            if(d.recordsTotal > 0){
                var len = d.data.length;
                var html = '';
                for(var i = 0 ; i < len ; i++){
                    var data = d.data[i];
                    html += data;
<?/*
                    var like_color = 'gray';
                    var st = 'like';
                    if(data.la_srl) {
                        like_color = 'orange';
                        st = 'dontlike';
                    }
                    html += '<li class="list-group-item">';
                    if(data.me) {
                        html += '<a href="javascript:;" class="delthis" id="delthis'+data.ans_srl+'" data-ans="'+data.ans_srl+'"><span class="glyphicon glyphicon-trash" style="font-size:12px;color:deeppink;"></span></a>';
                    }
                    html += ' <span style="font-size:11px"> [ '+data.create_at+' ] '+data.mem_name+'</span> ';
                    html += ' <span style="color:darkorange;font-size:11px"> 좋아요 <span style="font-size:11px" id="likecount'+data.ans_srl+'">'+data.likes+'</span></span>';
                    if(!data.me) {
                        html += '<a href="javascript:;" class="likeans" style="float:right;" id="likethis'+data.ans_srl+'" data-ans="'+data.ans_srl+'" data-status="'+st+'"><span class="glyphicon glyphicon-heart" id="like'+data.ans_srl+'" style="font-size:15px;color:'+like_color+';"></span></a>';
                    }
                    //html += data.ans_srl;
                    html += '<br>'+data.answer;
                    html += '</li>';
*/?>
                }
                $('#answer_list').append(html);
                if(d.recordsTotal < 20) {
                    $('#more').hide();
                }
            } else {
                $('#more').hide();
            }
            $('.link').click(function() { window.location.href=$(this).data('link'); });
            $('.delthis').click(function() {
                if(confirm('댓글을 정말 삭제하시겠어요?')) {
                    var ans = $(this).data('ans');
                    var url = '/answer/ax_set_answer_delete';
                    var data = {answer:ans}
                    ax_post(url, data, function(ret) {
                        if(ret.result == 'ok') {
                            $('#delthis'+ans).closest('.media').remove();
                            $('#respond').text(parseInt($('#respond').text() - 1));
                            alert('삭제되었습니다.');
                        } else {
                            alert(ret.msg);
                        }
                    });
                }
            });
            $('.likeans').click(function() {
                var sts = $(this).data('status');
                var ans = $(this).data('ans');
                var url = '/like/ax_set_answer_'+sts;
                var data = {answer:ans}
                ax_post(url, data, function(ret) {
                    if(ret.result == 'ok') {
                        already = true;
                        if(ret.data != 'already') already = false;
                        if(sts == 'like') {
                            $('#like'+ans).css('color', 'darkorange');
                            $('#likethis'+ans).data('status', 'dontlike');
                            if(!already) {
                                $('#likecount'+ans).text(parseInt($('#likecount'+ans).text())+1);
                            }
                        } else if(sts == 'dontlike') {
                            $('#like'+ans).css('color', 'gray');
                            $('#likethis'+ans).data('status', 'like');
                            if(!already) {
                                $('#likecount'+ans).text(parseInt($('#likecount'+ans).text())-1);
                            }
                        }
                    } else {
                        alert(ret.msg);
                    }
                });
            });
        });
    }
});
</script>
