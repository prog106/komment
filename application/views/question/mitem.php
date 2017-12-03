    <tr>
        <td><a href="javascript:;" class="delthis" id="delthis<?=$que_srl?>" data-que="<?=$que_srl?>"><span class="glyphicon glyphicon-trash" style="font-size:12px;color:deeppink;"></span></a></td>
        <td>
            <span style="font-size:11px"><?=remain_datetime($end_time)?> - <?=$create_at?> [ <?=$start?> ]</span>
<?
if(!empty($question_image)) {
?>
            <h6 id="question_image<?=$que_srl?>" data-img="<?=$question_image?>"><a href="<?=$question_image?>" target="_image"><img src="<?=$question_image?>" style="border-radius:0px;width:auto;max-width:300px;height:auto"></a></h6>
<?
}
?>
            <h5 style="cursor:pointer;" class="link" id="question<?=$que_srl?>" data-link="/answer/view/<?=$que_srl?>"><?=$question?></h5>
            <span style="font-size:11px">응답 <?=$respond?> &nbsp; 좋아요 <?=$likes?><br> <?=$main_start?> ~ <?=$main_end?></span>
        </td>
        <td style="vertical-align:middle">
<?
if($choice < 1) {
?>
            <a href="javascript:;" class="modthis btn btn-xs btn-primary" id="modthis<?=$que_srl?>" data-que="<?=$que_srl?>" data-start="<?=$start?>" data-main_start="<?=substr($main_start,0,10)?>" data-main_end="<?=substr($main_end,0,10)?>"><span class="glyphicon glyphicon-edit" style="font-size:13px;"></span></a>
<?
} else {
?>
            <span style="font-size:12px">수정<br>불가</font>
<?
}
?>
        </td>
    </tr>
