<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欢迎登录</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="js/jquery.js"></script>
    <script src="js/cloud.js" type="text/javascript"></script>

    <script language="javascript">
        $(function(){
            $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            $(window).resize(function(){
                $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            })
        });
    </script>
</head>
<body style="background-color:#1c77ac; background-image:url(images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">
<div id="mainBody">
    <div id="cloud1" class="cloud"></div>
    <div id="cloud2" class="cloud"></div>
</div>
<div class="logintop">
    <span>欢迎登录八维考试管理平台</span>
</div>

<div class="loginbody">
    <span><img src="{{URL::asset('')}}images/logo.png" title="系统首页" /><span style="position: absolute;left:90px;top:30px;font-size:30px;color:#ffffff">八维考试管理系统</span></span>

    <div class="loginbox">
        <ul>

            <li><input name="user_name" type="text" class="loginuser" value="" placeholder="Username"/></li>

            <li><input name="user_pwd" type="password" class="loginpwd" value="" placeholder="Password"/></li>
            <li>
                <input name="" type="button" class="loginbtn" value="登录" />
                <label><a href="#">忘记密码？</a><br/><span id = 'error' style="color: red;margin-left: 112px;margin-top: 8px;"></span></label>
            </li>

        </ul>
    </div>
</div>
<div class="loginbm"></div>
</body>
</html>
<script>
    $(function(){
      $('.loginbtn').click(function () {
          var user_name  = $('.loginuser').val();
          var user_pwd  = $('.loginpwd').val();
          var res = true;
          if(user_name == ''){
                $('#error').html('用户名不能为空')
              res = false;
          }
          if(user_pwd == ''&&user_name !=''){
              $('#error').html('密码不能为空')
              res = false;
          }
          if(user_pwd != ''&&user_name !=''){
              $('#error').html('')
             res = true;
          }
          if(res){
              $.ajax({
                  type:'POST',
                  url:'{{URL('login/loginInfo')}}',
                  data:{
                      user_name:user_name,
                      user_pwd:user_pwd
                  },
                  success: function (msg) {
                      var data = eval("("+msg+")");
                      if(data.status == '1'){
                          location.href = '{{URL("index/index")}}'
                      }else{
                          $('#error').html(data.error);
                      }
                  }

              })
          }
      })
    })
</script>
