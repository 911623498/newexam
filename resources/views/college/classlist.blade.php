<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('')}}css/bootstrap.css"/>
    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>
<script language="javascript">
$(function(){	
	//导航切换
	$(".imglist li").click(function(){
		$(".imglist li.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });

    $(".click").click(function(){
        $(".top").fadeIn(200);
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
</script>
</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">图片列表</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click"><span><img src="{{URL::asset('')}}images/t01.png" /></span>添加</li>
        </ul>
        

    
    </div>
    
    
    <table class="imgtable">
    
    <thead>
    <tr>
    <th width="100px;">班级名称</th>
    <th>所属学院</th>
    <th>所属系</th>
    <th>所属阶段</th>
    <th>PK班级</th>
    <th>讲师</th>
    <th>班级号</th>
    <th>课程</th>
    <th>操作</th>
    </tr>
    </thead>
    
    <tbody>

    @foreach ($users as $user)

    <tr>
    <td class="imgtd">{{ $user['cla_name'] }}</td>
	<td>
        {{$xy}}
	</td>
    <td>
        {{$jd}}

    </td>
        <td class="imgtd">@if($user['cla_jd'] ===0)
   计算机基础
@elseif ($user['cla_jd']===1)
   专业
@elseif ($user['cla_jd'] ===2)
	高级
	@else
		没有信息
@endif</td>
        <td class="imgtd">{{ $user['cla_pk'] }}</td>
        <td class="imgtd">{{ $user['cla_tea'] }}</td>
        <td class="imgtd">{{ $user['cla_mph'] }}</td>
    <td><a href="#">{{ $user['cla_intro'] }}</a><p></p></td>
    <td><a href="#" onclick="disp_prompt({{$user['cla_id']}})">选择PK班级</a>&nbsp&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp<a href="#" onclick="fun2({{$user['cla_id'] }})">修改</a>&nbsp&nbsp&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp<a href="{{URL('college/classdel')}}?id={{$user['cla_id'] }}">删除</a><p>ID: {{$user['cla_id']}}</p></td>
    </tr>
    @endforeach
  
    
    </tbody>
    
    </table>


        <div class="pagin">

            <li class="paginItem"> <?php echo $users->render(); ?></li>

       </div>

    
   
    <div class="pagin">

    </div>
    </div>
    <form action="{{URL('college/classadd')}}"  method="post">
        <div class="tip">
            <div class="tiptop"><span>信息</span><a></a></div>

            <div class="tipinfo">
                <input type="hidden" id="token" name="_token" value="<?php echo csrf_token();?>"/>
              
                <div class="tipright">
                    <p>班级名称：<input type="text" id="cla_name" name="cla_name" onblur="fun1()"/></p>
					<p>讲师：<input type="text" id="cla_tea" name="cla_tea"/></p>
					<p>门牌号：<input type="text" id="cla_mph" name="cla_mph"/></p>
                    <p>课程：<input type="text" id="cla_intro" name="cla_intro"/></p>
                    <input type="hidden" id="id" name="id" value=""/>
                    <input type="hidden" id="" name="cla_pid" value="{{$xi}}"/>
                    <p> 所属阶段： {{$jd}}
                    <select name="cla_xi" id="">
                        <option value="0">专业基础
                        <option value="1">专业阶段
                        <option value="2">高级阶段
                    </select>
                        </p>
                </div>

            </div>

            <div class="tipbtn">
                <input name="" type="submit"  class="sure" value="确定" />&nbsp;
                <input name="" type="button"  class="cancel" value="取消" />
            </div>

        </div>
    </form>
<script type="text/javascript">
	$('.imgtable tbody tr:odd').addClass('odd');
    function fun(id){
        var token=$("#token").val();
        $.ajax({
            type: "POST",
            url: "{{URL('college/classdel')}}",
            data: "id="+id+"&&_token="+token,
            success: function(msg){
              if(msg==0){
                  alert("删除失败！");
                  history.go(0);
              }else if(msg==2){
                  alert("此学院下面有分类，不能删除！");
                  history.go(0);
              }else if(msg==1){
                  alert("删除成功！");
                  history.go(0);
              }else{
                  alert("发生错误！");
                  history.go(0);
              }
            }
        });
    }
    function fun2(id){
        $("#id").val(id);
        $(".tip").fadeIn(200);
    }
    function fun1(){
        var id=$("#id").val();
        var token=$("#token").val();
        var cla_name=$("#cla_name").val();
        $.ajax({
            type: "POST",
            url: "{{URL('college/claweiyi')}}",
            data: "id="+id+"&&_token="+token+"&&cla_name="+cla_name,
            success: function(msg){
                if(msg==1)
                {
                    alert("名称已存在,请重新输入");
                    $("#cla_name").val("");
                }
            }
        });
    }
    function disp_prompt(id)
    {
//        alert(id)
        //获取当前网址，如： http://localhost:8083/uimcardprj/share/meun.jsp
        var curWwwPath=window.document.location.href;
        //获取主机地址之后的目录，如： uimcardprj/share/meun.jsp
        var pathName=window.document.location.pathname;
        var pos=curWwwPath.indexOf(pathName);
        //获取主机地址，如： http://localhost:8083
        var localhostPaht=curWwwPath.substring(0,pos);
        //获取带"/"的项目名，如：/uimcardprj
        var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
        var cla_name=prompt("请选择PK班级：","班级名称");
        if(cla_name){
            $.ajax({
                type: "POST",
                url: "{{URL('college/pkclass')}}",
                data: "id="+id+"&&_token="+token+"&&cla_name="+cla_name,
                success: function(msg){
//                    alert(msg)
                    if(msg==0)
                    {
                        alert("班级不存在,请重新输入");
                        $("#cla_name").val("");
                    }else if(msg==2){
                        alert("请选择同系的班级！");
                    }else if(msg==1){
                        alert("选择PK班级成功！");
                        window.location.href=localhostPaht+projectName+"/public/college/classes";
                    }else if(msg==3){
                        alert("此班级已于别的班级进行PK,您选择的班级将交互PK！");
                        window.location.href=localhostPaht+projectName+"/public/college/classes";
                    }else{
                        alert("错误！")
                    }
                }
            });

        }else{
			
		}


    }
	</script>
</body>
</html>
