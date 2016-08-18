<?php session_start();error_reporting(0);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="{{URL::asset('')}}js/jquery.js"></script>
<script type="text/javascript">
$(function(){	
	//顶部导航切换
	$(".nav li a").click(function(){
		$(".nav li a.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
</script>


</head>

<body style="background:url({{URL::asset('')}}images/topbg.gif) repeat-x;">

    <div class="topleft">
    <a href="{{URL('index/index')}}" target="_parent"><img src="{{URL::asset('')}}images/logo.png" title="系统首页" /><span style="position: absolute;left:90px;top:30px;font-size:30px;color:#ffffff">八维考试管理系统</span></a>
    </div>

    {{--<ul class="nav">--}}
    {{--<li><a href="default.html" target="rightFrame" class="selected"><img src="images/icon01.png" title="工作台" /><h2>工作台</h2></a></li>--}}
    {{--<li><a href="imgtable.html" target="rightFrame"><img src="images/icon02.png" title="模型管理" /><h2>模型管理</h2></a></li>--}}
    {{--<li><a href="imglist.html"  target="rightFrame"><img src="images/icon03.png" title="模块设计" /><h2>模块设计</h2></a></li>--}}
    {{--<li><a href="tools.html"  target="rightFrame"><img src="images/icon04.png" title="常用工具" /><h2>常用工具</h2></a></li>--}}
    {{--<li><a href="computer.html" target="rightFrame"><img src="images/icon05.png" title="文件管理" /><h2>文件管理</h2></a></li>--}}
    {{--<li><a href="tab.html"  target="rightFrame"><img src="images/icon06.png" title="系统设置" /><h2>系统设置</h2></a></li>--}}
    {{--</ul>--}}


    <div style="position: absolute;right: 200px; top:30px;font-size:20px;color:#ffffff" id="show_time"></div>
    <div class="topright">
    <ul>
    <li><a href="{{URL('login/resetPwd')}}" target="rightFrame">修改密码</a></li>
    <li><a href="#">关于</a></li>
    <li><a href="{{URL('login/loginOut')}}" target="_parent">退出</a></li>
    </ul>
     
    <div class="user">
    <span><?php echo $_SESSION['user']['use_names']?></span>
    <i>消息</i>
             @if($_SESSION['user']['role_id']==3)
            <a href="{{URL('index/news')}}" target="rightFrame"><b>{{$_SESSION['user']['sum']}}</b></a>
             @elseif($_SESSION['user']['role_id']==2)
              <a href="{{URL('grade/look')}}" target="rightFrame"><b>{{$_SESSION['user']['sum']}}</b></a>
            @else
            <b>{{$_SESSION['user']['sum']}}</b>
        @endif
    </div>
    
    </div>
</body>
</html>
<script>
    var time = "{{$time}}";
    var tmss = parseInt(time)-1;
    window.onload = totime(tmss);
    function totime(tms){
        var tm = parseInt(tms);
        tm++;
        tms = getLocalTime(tm);
        $('#show_time').html(tms);
       t = setTimeout("totime("+tm+")",1000)
    }
    function getLocalTime(nS) {
        var str="";
        var d=new Date(parseInt(nS) * 1000);
        str+= d.getFullYear()+"-";
        str+= d.getMonth()+1+"-";
        str+= d.getDay()+" ";
        str+= d.getHours()+":";
        str+= d.getMinutes()+":";
        str+= d.getSeconds()+"";
        return str;
    }





{{--window.onload=function(){--}}
        {{--setInterval("show_time()",1000);--}}
    {{--};--}}
    {{--$(function(){--}}
        {{--time="{{$time}}";--}}
    {{--});--}}


    {{--function show_time(){--}}
        {{--var str="";--}}

        {{--var date=parseInt(time) * 1000+1000;--}}
        {{--//date++;--}}
        {{--//alert(date);--}}
        {{--var d=new Date(date);--}}
        {{--str+= d.getFullYear()+"-";--}}
        {{--str+= d.getMonth()+1+"-";--}}
        {{--str+= d.getDay()+" ";--}}
        {{--str+= d.getHours()+":";--}}
        {{--str+= d.getMinutes()+":";--}}
        {{--str+= d.getSeconds()+"";--}}
        {{--document.getElementById("show_time").innerHTML=str;--}}
    {{--}--}}
</script>