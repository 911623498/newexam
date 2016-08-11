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
        <li><a href="#">首页</a></li>
        <li><a href="#">修改密码</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>修改密码</span></div>

    <ul class="forminfo">
        <li><label>原密码：</label><input name="oldpwd" id="oldpwd" type="password" class="dfinput" /> <span id="checkold" style="position: absolute;left:500px; top:120px;"></span></li>
        <li><label>新密码：</label><input name="newpwd" id="newpwd" type="password" class="dfinput" /> <span id="checknew" style="position: absolute;left:500px; top:170px;"></span></li>
        <li><label>重复密码：</label><input name="repwd" id="repwd" type="password" class="dfinput" /> <span id="checkre" style="position: absolute;left:500px; top:220px;"></span></li>
        <li><label>&nbsp;</label><input name="" type="button" class="btn" id='btn' value="确认修改"/></li>
    </ul>
</div>
</body>
</html>
<script src="{{URL::asset('')}}js/jquery-1.9.1.min.js"></script>
<script>
    $(document).ready(function(){
        $("#oldpwd").blur(function(){
            var param=$("#oldpwd").val();
            $.ajax({
                type:"post",
                url:"{{url('login/repwdAjax')}}",
                data:{oldpwd:param},
                success:function(e){
                    if(e == '1'){
                        $("#checkold").html("<font color=\"green\" size=\"2\">√</font>");
                    }
                    else{
                        $("#checkold").html("<font color=\"red\" size=\"2\">原密码不正确</font>");
                    }
                }
            });
        });
        $("#newpwd").blur(function(){
            var num=$("#newpwd").val().length;
            if(num<6){
                $("#checknew").html("<font color=\"red\" size=\"2\">不能小于6个字符</font>");
            }
            else if(num>18){
                $("#checknew").html("<font color=\"red\" size=\"2\">不能大于18个字符</font>");
            }
            else{
                $("#checknew").html("<font color=\"green\" size=\"2\"> √</font>");
            }
        }) ;
        $("#repwd").blur(function(){
            var tmp=$("#newpwd").val();
            var num=$("#repwd").val().length;
            if($("#repwd").val()!=tmp){
                $("#checkre").html("<font color=\"red\" size=\"2\">两次输入不一致</font>");
            }
            else{
                if(num>=6&&num<=18){
                    $("#checkre").html("<font color=\"green\" size=\"2\">√</font>");
                }
                else{
                    $("#checkre").html("<font color=\"red\" size=\"2\">必须是6-18位字符</font>");
                }
            }
        });
        $("#btn").click(function(){
            var flag=true;
            var old=$("#oldpwd").val();
            var pass=$("#newpwd").val();
            var pass2=$("#repwd").val();
            var num1=$("#newpwd").val().length;
            var num2=$("#repwd").val().length;
            if(num1!=num2||num1<6||num2<6||num1>18||num2>18||pass!=pass2){
                flag=false;
            }
            else{
                flag=true;
            }
            if(flag){
                $.ajax({
                    url:"{{url('login/repwdInfo')}}",
                    data:{oldpwd:old,newpwd:pass},
                    success:function(e){
                        if(e == '1'){
                            window.parent.location.href="{{url('login/loginOut')}}";
                        }
                        else{
                            $("#checkold").html("<font color=\"red\" size=\"2\">原密码不正确</font>");
                        }
                    }
                });
            }
        });
    });
</script>