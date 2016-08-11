<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站后台管理系统HTML模板--我爱模板网 www.5imoban.net</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('')}}css/bootstrap.css"/>
<link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
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
    <li><a href="#">组建管理</a></li>
    <li><a href="#">学生列表</a></li>
    </ul>
    </div>

    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar1">
                <li><label>&nbsp;</label><input name="" type="button" class="btn" id='sc' value="生成账号"/></li>
            </ul>

        </div>



    <table class="tablelist">
        <thead>
        <tr>
            <th><input name="" type="checkbox" value=""/></th>
            <th>编号<i class="sort"><img src="{{URL::asset('')}}images/px.gif" /></i></th>
            <th>姓名</th>
            <th>组</th>
            <th>学号</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody id='eew'>
        <?php
        foreach($user_list as $k=>$v){
        ?>
        <tr id='qwe'>
            <th><input name='' type='checkbox' /></th>
            <th><?php echo $v['stu_id']?></th>
            <th><span><?php echo $v['stu_name']?></span><input type='text' value='<?php echo $v['stu_name']?>' style='display: none'/></th>
            <th><?php echo $v['stu_group']?></th>
            <th><?php echo $v['stu_care']?></th>
            <th><a href='javascript:' onclick='del(<?php echo $v['stu_id']?>)'>删除</a></th>
            <input type='hidden' value='<?php echo $v['stu_id']?>'/>
        </tr>
        <?php
        }
        ?>
        </tbody>

    </table>
    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>

      <div class="tipinfo">

        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>

        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>

    </div>



        <li class="paginItem"> <?php echo $user_list->render(); ?></li>
    </div>

    <script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</body>
</html>
<script src="{{URL::asset('')}}js/jquery-1.9.1.min.js"></script>
<script src="{{URL::asset('')}}js/jquery.selectlist.js"></script>
<script type="text/javascript">
    $("#sc").click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{url('group/sczh')}}",
            data: "",
            success: function(msg) {

                    if (msg == 11) {
                        alert("账号生成成功");
                    } else if (msg == 11) {
                        alert("账号生成失败");
                    } else if (msg == 2333) {
                        alert("本班账号已经生成");
                    }
            }
        });
    });
    function del(stu_id){
        last_id=$("tbody>tr:last>input:hidden").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{url('group/stu_del')}}",
            data: "stu_id="+stu_id+"&last_id="+last_id,
            success: function(msg) {
               // alert(msg.stu_id);
                //console.log(str[0].stu_care);
                if(msg == 0){
                    alert("删除失败");
                }else{
                    var str=eval("("+msg+")");
                    $("#qwe").remove();
                    var mvp="<tr id='qwe'><th><input name='' type='checkbox' /></th><th>"+str[0].stu_id+"</th><th>"+str[0].stu_name+"</th><th>"+str[0].stu_group+"</th> <th>"+str[0].stu_care+"</th><th><a href='javascript:' onclick='del("+str[0].stu_id+")'>删除</a></th><input type='hidden' value='"+str[0].stu_id+"'/></tr>";

                       // alert(mvp);
                    $("tbody>tr:last").after(mvp);
                }
            }
        });
    }

</script>
