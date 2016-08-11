
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>
</head>
<body>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    </ul>
    </div>
    <div class="mainindex">
    <div class="welinfo">
    <span><img src="{{URL::asset('')}}images/sun.png" alt="天气" /></span>
    <b><span style="color: red"><?= $_SESSION['user']['use_names']?></span>你好，欢迎使用八维成绩管理系统</b>
    <a href="#">帐号设置</a>
    </div>
    
    <div class="welinfo">
    <span><img src="{{URL::asset('')}}images/time.png" alt="时间" /></span>
    <i>您上次登录的时间：<?= $_SESSION['user']['use_time']?></i> （不是您登录的？<a href="#">请点这里</a>）
    </div>
     <?php
            if(!empty($arr)){
     ?>
        <div class="rightinfo">
            <table class="tablelist">
                <tbody>
                <tr>
                    <td colspan="3"><center style="color:red; font-size: 20px;">成绩有误</center></td>
                </tr>
                <tr>
                    <td>组</td>
                    <td>日考</td>
                    <td>操作</td>
                </tr>
                @foreach($arr as $k=>$v)
                    <tr>
                        <td>{{$v['grou_id']}}组</td>
                        <td>{{$v['exam_day']}}</td>
                        <td><a href="{{URL('grade/record')}}" >修改</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
     <?php

            }
     ?>

        <img src="{{URL::asset('')}}images/banner3.png" alt=""/>
    
    </div>

</body>
</html>
