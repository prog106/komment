<?
if($tps === 'answer') {
    $mem_picture = (!empty($mem_picture)?$mem_picture:"/static/image/komment.png");
    $mem_name = $mem_name;
    $title = "[댓글]";
    $end_time = $create_at;
    $text = "좋아요 ".number_format($likes);
} else {
    $mem_picture = ((!empty($mem_picture) && $mem_level !== 'manager')?$mem_picture:"/static/image/komment.png");
    $mem_name = ($mem_level !== 'manager')?$mem_name:"Komment";
    $title = "[질문]";
    $end_time = remain_datetime($end_time);
    $text = "댓글 ".number_format($respond)." &nbsp; 좋아요 ".number_format($likes);
}
?>
            <div class="media">
                <div class="media-left" style="padding-top:5px;">
                    <a href="#">
                        <img class="media-object" src="<?=$mem_picture?>">
                    </a>
                </div>
                <div class="media-body">
                    <span style="font-size:11px;line-height:25px;"><?=$title?> <?=$mem_name?></span>
                    <span style="font-size:11px;float:right;margin-right:20px;margin-top:5px;"><?=$end_time?></span>
                    <h5 class="media-heading link" style="line-height:22px;cursor:pointer;" data-link="/answer/view/<?=$que_srl?>"><?=convert_hashtag($question)?></h5>
                    <span style="font-size:11px;"><?=$text?></span>
<?
/* // 요거는 아직 미해결 - 안나오게 하는 것도 나쁘지 않은듯
        if($mem_srl !== $member['mem_srl']) {
?>
                    <a href="javascript:;" class="likethis" id="likethis<?=$v['que_srl']?>" data-question="<?=$v['que_srl']?>" data-status="<?=(empty($like[$v['que_srl']]))?"false":"true"?>" style="float:right;margin-right:25px;"><span class="glyphicon glyphicon-heart" id="like<?=$v['que_srl']?>" style="font-size:20px;color:<?=(empty($like[$v['que_srl']]))?"gray":"darkorange"?>;"></span></a>
<?
        }
        */
?>
                </div>
                <hr style="margin-top:5px;margin-bottom:0px">
            </div>