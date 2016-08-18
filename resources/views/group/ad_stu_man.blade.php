<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('')}}css/jquery.selectlist.css">

</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">组建管理</a></li>
    <li><a href="#">添加学生信息</a></li>
    </ul>
    </div>

    <div class="formbody">

    <div class="formtitle"><span>本班学生基本信息</span></div>

        <ul class="forminfo">

        <li><label>第几组：</label>

            <select id="calsse"  style="width: 300px;height: 28px;  border: solid 1px #A7B5BC">
                <option value="">请选择小组...</option>
                <?php
                    foreach($list as $k=>$v){
                ?>
                 <?php
                    if($v['stu_group']==0){
                        ?>
                        <option value="<?php echo $v['stu_group']?>">不分配小组</option>
                <?php
                    }else{
                ?>
                    <option value="<?php echo $v['stu_group']?>"><?php echo $v['stu_group']?>组</option>

                    <?php
                }
                ?>


                ?>
                <?php
                    }
                ?>
            </select>

        </li>

    <div id = 'e'>
	    <div class="f">
	    	<li><span>1:</span><label>组员姓名：</label><input id="stu_name" name="stu_name[]" type="text" class="dfinput" onblur="li_stu_name()"/><label id="s1"></label></li>
	    	<li><label>课程：</label><input id="course" name="course[]" type="text" class="dfinput"/></li>
            <li><label>重修次数：</label><input id="re_next" name="re_next[]" type="text" class="dfinput" /></li>
	    	<li><label>学生号：</label><input id="stu_care" name="stu_care[]" type="text" class="dfinput"/></li>
	    </div>
    </div>
    <li><label>&nbsp;</label>
        <input name="" type="button" class="btn" value="+" style="width:50px; height:20px;" id="jia" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="" type="button" class="btn" value="-" style="width:50px; height:20px;" id="jian" />
    </li>

    <!--<li><label>文章内容</label><textarea name="" cols="" rows="" class="textinput"></textarea></li>-->
    <li><label>&nbsp;</label><input name="" type="button" class="btn" id='bc' value="确认保存"/></li>
    </ul>
    
    
    </div>
</body>
</html>

<script src="{{URL::asset('')}}js/jquery-1.9.1.min.js"></script>
<script src="{{URL::asset('')}}js/jquery.selectlist.js"></script>
<script type="text/javascript">

</script>
<script type="text/javascript">
    //-----表单
    $("#jian").click(function(){
        if(($("input[name='stu_name[]']").length) <= 1){
            return false;
        }
        $("#e div:last").remove();

    });
    //++++++++表单
    $("#jia").click(function(){
        var zhi=$("span:last").text();

        zhi=zhi.substr(0,1);
        zhi++;
//        alert(zhi);
//        return false;
        var str = '';
        str += '<div class="f">';
        str += '<li><span>'+zhi+':'+'</span><label>学生姓名：</label><input id="stu_name" name="stu_name[]" type="text" class="dfinput" /></li>';
        str += '<li><label>课程：</label><input id="course" name="course[]" type="text" class="dfinput" /></li>';
        str += '<li><label>重修次数：</label><input id="re_next" name="re_next[]" type="text" class="dfinput" /></li>';
        str += '<li><label>学生号：</label><input id="stu_care" name="stu_care[]" type="text" class="dfinput" /></li>';
        str += '</div>';

        if(($("input[name='stu_name[]']").length)>4){
            return false;
        }
        $('#e').append(str);

    });

    $("#bc").click(function(){
        var zu=$("#calsse").val();
        //姓名
            var stu_name='';
            $("input[name='stu_name[]']").each(function(index,item){
                stu_name+=','+$(this).val();
            });
            stu_name=stu_name.substr(1);
        //课程
            var course='';
            $("input[name='course[]']").each(function(index,item){
                course+=','+$(this).val();
            });
            course=course.substr(1);
        //重修次数
            var re_next='';
            $("input[name='re_next[]']").each(function(index,item){
                re_next+=','+$(this).val();
            });
            re_next=re_next.substr(1);
        //学号
            var stu_care='';
            $("input[name='stu_care[]']").each(function(index,item){
                stu_care+=','+$(this).val();
            });
            stu_care=stu_care.substr(1);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if(stu_name == ""){
                alert("姓名不能为空");
                return false;
            }
            if(course == ""){
                alert("课程不能为空");
                return false;
            }
            if(re_next == ""){
                alert("重修次数不能为空");
                return false;
            }
            if(stu_care == ""){
                alert("学生号不能为空");
                return false;
            }
            $.ajax({
                type: "POST",
                url: "{{url('group/addin_data')}}",
                data: "stu_name="+stu_name+"&course="+course+"&re_next="+re_next+"&stu_care="+stu_care+"&zu="+zu,
                success: function(msg){

                    if(msg == 0){
                        alert("添加失败");
                    }else if(msg == 1){
                        alert("请完善学生的课程");
                    }else if(msg == 2){
                        alert("请完善学生的重修次数");
                    }else if(msg == 3){
                        alert("学生已存在");
                    }else if(msg == 4){
                        alert("姓名不能为空");
                    }else if(msg == 5){
                        alert("学号已存在");
                    }else if(msg == 6){
                        alert("学号不能为空");
                    }else if(msg == 7){
                        alert("添加成功");location.href="{{url('group/group_list')}}";
                    }else if(msg == 8){
                        alert("该组成员超过6位了！");
                    }
                }
            });

    })
</script>
{{--location.href="{{url('group/ad_stu_massage')}}";--}}