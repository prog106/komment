<link href="/static/css/bootstrap-slider.css" rel="stylesheet">
<script type="text/javascript" src="/static/js/bootstrap-slider.js"></script>
<form class="form-horizontal" id="question_form" onsubmit="return false;" style="display:none">
    <input type="hidden" name="que_srl" id="que_srl" value="0">
    <div class="form-group">
        <label for="question" class="col-sm-12 control-label"><span style="color:crimson">주의! 질문은 하루 3개 등록 가능합니다.<br>질문을 삭제하시면 오늘은 다시 등록할 수 없습니다.</font></label>
    </div>
    <div class="form-group">
        <label for="question" class="col-sm-2 control-label">메인 이미지(필수아님)</label>
        <div class="col-sm-10">
            <input class="form-control" name="question_image" id="question_image" rows="5" maxlength="255" placeholder="이미지 링크를 넣어주세요.">
        </div>
    </div>
    <div class="form-group">
        <label for="question" class="col-sm-2 control-label">질문을 올려주세요.</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="question" id="question" rows="4" maxlength="500" placeholder="질문을 입력해 주세요. 
#을 통해 해시태크 설정이 가능합니다. 
예) #해시태그"></textarea>
        </div>
    </div>
    <!-- div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="nonickname" id="nonickname" value="Y"> 익명으로 올리기
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="endtime" class="col-sm-2 control-label"><span id="tmval">3일</span> 동안 댓글을 받습니다. (최소 2시간, 최대 7일)</label>
        <div class="col-sm-offset-2 col-sm-10">
            <input id="tm" type="text" name="tm" data-slider-min="2" data-slider-max="168" data-slider-step="2" data-slider-value="72"/>
        </div>
    </div -->
<?
if($member['level'] === 'manager') {
?>
    <div class="form-group">
        <label for="start_y" class="col-sm-2 control-label">노출 시작일</label>
        <div class="col-sm-10">
            <input type="text" onfocus="blur()" name="start" class="form-control" id="start" placeholder="노출시작일" value="<?=date('Y-m-d', mktime(0,0,0,date("m")  , date("d")+1, date("Y")))?>">
        </div>
    </div>
    <div class="form-group">
        <label for="main_start" class="col-sm-2 control-label">메인 노출 기간</label>
        <div class="col-sm-10">
            <div class="input-group input-daterange">
                <input type="text" onfocus="blur()" class="form-control" id="main_start" name="main_start" value="" placeholder="Start">
                <span class="input-group-addon">~</span>
                <input type="text" onfocus="blur()" class="form-control" id="main_end" name="main_end" value="" placeholder="End">
            </div>
        </div>
    </div>
<script>
$(document).ready(function() {
    $.fn.datepicker.defaults.format = "yyyy-mm-dd";
    $.fn.datepicker.defaults.autoclose = true;
    $.fn.datepicker.defaults.clearBtn = true;
    $.fn.datepicker.defaults.todayHighlight = true;
    $.fn.datepicker.defaults.startdate = '0d';
    $('#start').datepicker();
    var startDate = new Date('01/01/2015');
    var FromEndDate = new Date();
    var ToEndDate = new Date();
    ToEndDate.setDate(ToEndDate.getDate()+365);
    $('#main_start').datepicker({
        weekStart: 1,
        startDate: '2015-01-01',
        //endDate: FromEndDate, 
        autoclose: true
    }).on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#main_end').datepicker('setStartDate', startDate);
    }); 
    $('#main_end').datepicker({
        weekStart: 1,
        startDate: startDate,
        endDate: ToEndDate,
        autoclose: true
    }).on('changeDate', function(selected){
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('#main_start').datepicker('setEndDate', FromEndDate);
    });
    $('.input-daterange input').each(function() {
        $(this).datepicker();
    });
});
</script>
<?
}
?>
    <br>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" id="regist" class="btn btn-success">질문 수정하기</button>
            <button type="button" id="cancel" class="btn btn-danger">취소</button>
        </div>
    </div>
</form>
<table class="table table-condensed" id="question_list">
    <tr>
        <th width="5%"></th>
        <th width="80%">내가 올린 질문</th>
        <th width="10%">수정</th>
    </tr>
</table>
<style>
#sliderBox { width:40px;height:40px;position:fixed;right:0px;background:goldenrod;margin-right:20px;border-radius:50%;cursor:pointer; }
#sliderBox h5 { line-height:20px;text-align:center;color:#fff; }
</style>
<div id="sliderBox">
    <h5 class="link" data-link="/question/">Write</h5>
</div>
<button type="button" id="more" class="glyphicon glyphicon-chevron-down btn btn-default btn-sm" style="width:100%"> 더보기</button>
<script type="text/javascript">
var page_num = 1;
var timer    = setInterval(function () { scrollOK = true; }, 100);
var scrollOK = true;

    $('#sliderBox').css({ 'top' : $(window).scrollTop() + 10 });
    $(window).scroll(function() {
        $('#sliderBox').css({ 'top' : $(window).scrollTop() + 10 });
    });
$(document).ready(function(){
    $("#tm").slider({
        formatter: function(value) {
            if(value >= 24) {
                values = parseInt(value/24) + '일 ';
                times = parseInt(value%24);
                if(times > 0) {
                    values += times + '시간';
                }
            } else {
                values = value + '시간';
            }
            return values;
        }
    });
    $("#tm").on("slide", function(slideEvt) {
        value = slideEvt.value;
        if(value >= 24) {
            values = parseInt(value/24) + '일 ';
            times = parseInt(value%24);
            if(times > 0) {
                values += times + '시간';
            }
        } else {
            values = value + '시간';
        }
        $("#tmval").text(values);
    });
    $('#regist').click(function() {
<?
if($member['level'] === 'manager') {
?>
        if(!$('#start').val()) {
            alert('노출 시작일을 선택해 주세요.');
            return false;
        }
<?
}
?>
        var url = "/question/ax_set_question";
        var data = $('#question_form').serialize();
        ax_post(url, data, function(ret) {
            if(ret.result == 'ok') {
                alert('등록되었습니다.');
                window.location.reload();
            } else {
                alert(ret.msg);
            }
        });
    });

    $('#more').click(function() {
        get_question_list(page_num+1);
    });
/*    $(window).on('scroll', function () {
        if (scrollOK) {
            scrollOK = false;
            if ($(this).scrollTop() + $(this).height() >= ($(document).height() - 5)) {
                get_question_list(page_num+1);
            }
        }
    });
*/
    get_question_list(1);
    $('#cancel').click(function() {
        if(!confirm('취소 하시겠습니까?')) return false;
        $('#question_form').hide();
        $('#regist').text('질문 올리기');
        $('#que_srl').val(0);
        $('#question').val('');
        $('#nonickname').prop('disabled', false);
        $('#tm').slider('enable');
    });
    $('.day').keyup(function() {
        if($(this).val() > 31 || $(this).val() < 1) {
            $(this).val('');
        }
    });
});

function get_question_list(page_val){
    page_num = page_val;
    url = '/question/ax_get_question';
    data = {page:page_num};
    ax_post(url, data, function(d) {
        if(d.recordsTotal > 0){
            var len = d.data.length;
            var html = '';
            for(var i = 0 ; i < len ; i++){
                var data = d.data[i];
                html += data;
<?/*
                var col = 'black';
                html += '<li class="list-group-item">';
                html += data.que_srl;
                console.log(data.start);
                if(data.start >= '<?=date('Y-m-d')?>') {
                    if(data.main_start < '<?=YMD_HIS?>' && data.main_end > '<?=YMD_HIS?>') {
                        col = 'crimson';
                    } else if(data.main_start > '<?=YMD_HIS?>') {
                        col = 'darkorange';
                    }
                }
                if(data.main_start) {
                    html += "<br>"+data.main_start+" ~ "+data.main_end;
                }
                if(data.status == 'delete') {
                    html += '<span style="text-decoration:line-through;">';
                }
                html += "<br><span style=\"color:"+col+";\">"+data.question+"</span>";
                if(data.status == 'delete') {
                    html += '</span>';
                }
                if(data.main_start) {
                    html += "</span>";
                }
                html += '<br>댓글 '+data.respond+' 좋아요 '+data.likes;
                html += '</li>';
*/?>
            }
            $('#question_list tbody').append(html);
            if(d.recordsTotal < 20) {
                $('#more').hide();
            }
        } else {
            $('#more').hide();
        }
        $('.link').click(function() { window.location.href=$(this).data('link'); });
        $('.modthis').click(function() {
            if(!confirm('질문을 수정하시겠습니까?')) return false;
            $('#question_image').val($('#question_image'+$(this).data('que')).data('img'));
            $('#question').val($('#question'+$(this).data('que')).text());
            $('#que_srl').val($(this).data('que'));
<?
if($member['level'] === 'manager') {
?>
            $('#start').datepicker('update', $(this).data('start'));
            $('#main_start').datepicker('update', $(this).data('main_start'));
            $('#main_end').datepicker('update', $(this).data('main_end'));
<?
}
?>
            $('#regist').text('질문 수정하기');
            $('#question_form').show();
            $('#nonickname').prop('disabled', true);
            $('#tm').slider('disable');
            window.scrollTo(0,0);
        });
        $('.delthis').click(function() {
            if(!confirm('작성된 응답과 좋아요 정보가 삭제됩니다.\n\n삭제 후 복구가 불가능 합니다.\n\n정말 삭제하시겠습니까?')) return false;
            var q = $(this).data('que');
            var url = "/question/ax_set_question_del";
            var data = {que:q};
            ax_post(url, data, function(ret) {
                if(ret.result == 'ok') {
                    $('#question_form').hide();
                    $('#delthis'+q).parent('td').parent('tr').remove();
                    alert('삭제되었습니다.');
                } else {
                    alert(ret.msg);
                }
            });
        });
    });
}
</script>
