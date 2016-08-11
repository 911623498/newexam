<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>

<script type="text/javascript">
$(function(){	
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active");
		$(this).addClass("active");
	});
	
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
})	
</script>


</head>

<body style="background:#f0f9fd;">
	<div class="lefttop"><span></span>常用操作</div>
    <dl class="leftmenu">
        @if($_SESSION['user']['use_id'] != 1)
        @foreach($_SESSION['user']['left'] as $key=>$val)
            <dd>
                <div class="title">
                    <span><img src="{{URL::asset('')}}images/leftico01.png" /></span>{{$val['bs']}}
                </div>
                <ul class="menuson">
                    @foreach($val['son'] as $k=>$v)
                        <li><cite></cite><a href="{{URL::asset('')}}{{$v['url']}}" target="rightFrame">{{$v['bs']}}</a><i></i></li>
                    @endforeach
                </ul>
            </dd>
        @endforeach
        @else
            <dd>
                <div class="title">
                    <span><img src="{{URL::asset('')}}images/leftico01.png" /></span>权限管理
                </div>
                <ul class="menuson">
                    <li><cite></cite><a href="{{URL('privilege/user')}}" target="rightFrame">用户管理</a><i></i></li>
                    <li><cite></cite><a href="{{URL('privilege/role')}}" target="rightFrame">角色管理</a><i></i></li>
                    <li><cite></cite><a href="{{URL('privilege/node')}}" target="rightFrame">权限管理</a><i></i></li>
                </ul>
            </dd>
            <dd>
            <div class="title">
            <span><img src="{{URL::asset('')}}images/leftico02.png" /></span>考试周期管理
            </div>
                <ul class="menuson">
                <li><cite></cite><a href="{{URL('exam/exam_list')}}" target="rightFrame">考试周期列表</a><i></i></li>
                <li><cite></cite><a href="{{URL('exam/record')}}" target="rightFrame">考试类型录入</a><i></i></li>
                </ul>
            </dd>

            <dd><div class="title"><span><img src="{{URL::asset('')}}images/leftico03.png" /></span>学院管理</div>
                <ul class="menuson">
                    <li><cite></cite><a href="{{URL('college/college')}}" target="rightFrame">学院列表</a><i></i></li>
                    <li><cite></cite><a href="{{URL('college/classes')}}" target="rightFrame">班级列表</a><i></i></li>
                </ul>
            </dd>
            <dd><div class="title"><span><img src="{{URL::asset('')}}images/leftico04.png" /></span>组建管理</div>
                <ul class="menuson">
                    <li><cite></cite><a href="{{URL('group/ad_stu_massage')}}" target="rightFrame">添加学生信息</a><i></i></li>
                    <li><cite></cite><a href="{{URL('group/chose_grouper')}}" target="rightFrame">学生小组PK</a><i></i></li>
                    <li><cite></cite><a href="{{URL('group/group_list')}}" target="rightFrame">学生列表</a><i></i></li>
                </ul>
            </dd>
            <dd><div class="title"><span><img src="{{URL::asset('')}}images/leftico04.png" /></span>成绩管理</div>
                <ul class="menuson">
                    <li><cite></cite><a href="{{URL('grade/look')}}" target="rightFrame">查看成绩</a><i></i></li>
                    <li><cite></cite><a href="{{URL('grade/record')}}" target="rightFrame">录入成绩</a><i></i></li>
                </ul>
            </dd>
        @endif
    </dl>
</body>
</html>