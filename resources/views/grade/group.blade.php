<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html id="show">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
      var val_payPlatform = $(':input[name="group"]:checked');

     // alert(val_payPlatform.length);
            if(val_payPlatform.length==0)
            {
                $("#check").html("<font color='red'>请选择要录入成绩的组！</font>");

            }
             else
            {
                $("#check").html("");
                $(".tip").fadeIn(200);
            }

  });
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});

    function u_test()
    {
        var id = $(':input[name="group"]:checked').attr('uid');
        $.get("{{URL('grade/test')}}", { id: id },
                function(data){
                  //  alert(data);
               $("#show").html(data);
                });

    }
</script>
</head>
<body>
	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">成绩管理</a></li>
    <li><a href="#">录入成绩</a></li>
    </ul>
    </div>
    <div class="rightinfo">
    <div class="tools">
    	<ul class="toolbar">
        <li class="click"><span><img src="{{URL::asset('')}}images/t02.png" /></span>成绩录入</li>
        </ul>
        <span id="check"></span>

        <ul class="toolbar1">
        </ul>
    </div>
    <table class="tablelist" >
    	<tr>
        <th>请选择</th>
        <th>当前组名</th>
        <th>学号</th>
        <th>组长</th>
        <th>班级</th>
        </tr>
        <tbody>
        @foreach($data as $v)
        <tr>
        <td><input name="group"  type="radio" value="{{$v['stu_id']}}" uid="{{$v['stu_group']}}"/>
            <input type="hidden" id="u_id" value="{{$v['stu_group']}}"/></td>
        <td>第{{$v['stu_group']}}组</td>
        <td>{{$v['stu_care']}}</td>
        <td>{{$v['stu_name']}}</td>
        <td>{{$class_name}}</td>
        </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagin">
    	<div class="message">共<i class="blue">{{$num}}</i>个小组</div>
    </div>
    <div class="tip">
    	<div class="tiptop"><span>提示信息</span><a></a></div>
      <div class="tipinfo">
        <span><img src="{{URL::asset('')}}images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认录入本组成绩？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" onclick="u_test()" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    </div>
    </div>
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>
</body>
</html>
