<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?
if(!empty($question)) {
?>
    <meta property="fb:app_id" content="993271550745290"/>
    <meta property="og:site_name" content="코멘트"/>
    <meta property="og:title" content="<?=htmlspecialchars(convert_text($question['question'], false))?>" />
    <meta property="og:description" content="코멘트" />
    <meta property="og:url" content="http://komment.co.kr<?=$this->input->server('REQUEST_URI', true)?>" />
    <meta property="og:image" content="http://komment.co.kr/static/image/komment.png" />
<?
}
?>
	<title>응답하라</title>
    <script src="/static/js/jquery-1.11.3.min.js"></script>
    <script src="/static/js/komment.util.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="/static/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/static/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/static/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/common.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="/static/js/bootstrap-datepicker.js"></script>
    <script src="/static/js/moment.min.js"></script>
    <script src="/static/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/static/js/jasny-bootstrap.min.js"></script>
    <script src="/static/js/iscroll.js"></script>
    <script src="/static/js/sp-slidemenu.js"></script>
    <script src="/static/js/swiper.jquery.min.js"></script>
<script language="javascript">
<!--

var db = (document.body) ? 1 : 0;
var scroll = (window.scrollTo) ? 1 : 0;

function setCookie(name, value, expires, path, domain, secure) {
    var curCookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
    document.cookie = curCookie;
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) end = dc.length;
    return unescape(dc.substring(begin + prefix.length, end));
}

function saveScroll() {
    if (!scroll) return;
    var now = new Date();
    now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
    var x = (db) ? document.body.scrollLeft : pageXOffset;
    var y = (db) ? document.body.scrollTop : pageYOffset;
    setCookie("xy", x + "_" + y, now);
}

function loadScroll() {
    if (!scroll) return;
    var xy = getCookie("xy");
    if (!xy) return;
    var ar = xy.split("_");
    if (ar.length == 2) {
        scrollTo(parseInt(ar[0]), parseInt(ar[1]));
    }
}
// -->
</script>
<script>
<? // GA ?>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-72634817-1', 'auto');
ga('send', 'pageview');
</script>
</head>
<body role="document" onLoadComplete="loadScroll()" onUnload="saveScroll()">
