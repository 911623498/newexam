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
                <option value="0">请选择小组。。。</option>
                <option value="1">1组</option>
                <option value="2">2组</option>
                <option value="3">3组</option>
                <option value="4">4组</option>
                <option value="5">5组</option>
                <option value="6">6组</option>
                <option value="7">7组</option>
                <option value="8">8组</option>
                <option value="9">9组</option>
                <option value="10">10组</option>
                <option value="11">11组</option>
                <option value="12">12组</option>
            </select>

        </li>
        <li><label>组长姓名：</label><input name="stu_name[]" type="text" class="dfinput" /></li>
        <li><label>学生号：</label><input name="stu_care[]" type="text" class="dfinput" /></li>
    <div id = 'e'>
	    <div class="f">
	    	<li><label>组员姓名：</label><input name="stu_name[]" type="text" class="dfinput" /></li>
	    	<li><label>学生号：</label><input name="stu_care[]" type="text" class="dfinput" /></li>
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



        if(($("input[name='stu_name[]']").length) <= 2){
            alert("一个组最少两个人");
            return false;
        }
        $("#e div:last").remove();

    });
    //++++++++表单
    $("#jia").click(function(){
        var str = '';
        str += '<div class="f">';
        str += '<li><label>学生姓名：</label><input name="stu_name[]" type="text" class="dfinput" /></li>'
        str += '<li><label>学生号：</label><input name="stu_care[]" type="text" class="dfinput" /></li>'
        str += '</div>';
        //alert(str);
        if(($("input[name='stu_name[]']").length)>5){
            alert("亲！每个小组最多只能有6个人哦。。。");
            return false;
        }
        $('#e').append(str);

    });
    $("#bc").click(function(){
        var zu=$("#calsse").val();
        if(zu == ""){
            alert("请选择小组");
            return false;
        }else if(zu == 0){
            alert("请选择小组");
            return false;
        }else{
            var stu_name='';
            var stu_care='';
            $("input[name='stu_name[]']").each(function(index,item){
                stu_name+=','+$(this).val();
            });
            stu_name=stu_name.substr(1);
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
            if(stu_care == ""){
                alert("学生号不能为空");
                return false;
            }
            $.ajax({
                type: "POST",
                url: "{{url('group/addin_data')}}",
                data: "stu_name="+stu_name+"&stu_care="+stu_care+"&zu="+zu,
                success: function(msg){
                    if(msg == 0){
                        alert("添加失败");location.href="{{url('group/ad_stu_massage')}}";
                    }else if(msg == 1){
                        alert("添加成功");location.href="{{url('group/ad_stu_massage')}}";
                    }else if(msg == 7){
                        alert("该小组已经添加");
                    }else if(msg == 3){
                        alert("这个小组的组长已存在，请您重添加吧!");
                    }else if(msg ==4){
                        alert("这个小组的组员已经是其他组的成员了，请您重添加吧！");
                    }else if(msg ==5){
                        alert("这个小组的组长学号已存在，请您重添加吧！");
                    }else if(msg ==6){
                        alert("这个小组的组员学号已经存在，请您重添加吧！");
                    }
                }
            });
        }
    })
</script>