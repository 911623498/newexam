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
        <li><a href="#">学生信息列表</a></li>
    </ul>
</div>
        <div>
            <table class="tablelist" style="width:200px;">
                <thead>
                <?php
                foreach($pk as $kk => $vv){
                ?>
                <tr>

                    <th><?php echo $vv['stu_name']?></th>
                    <th>PK</th>
                </tr>
                <?php
                }
                ?>
                </thead>
                <tbody>
            </table>
        </div>
        <div>
                <table class="tablelist" style="width: 200px; margin-left:200px; float: right;">
                    <?php
                    foreach($pk1 as $k1 => $v1){
                    ?>
                    <tr>
                        <th><?php echo $v1['stu_name']?></th>
                    </tr>
                    <?php
                    }
                    ?>
                    </thead>
                    <tbody>
                </table>
        </div>
<div class="formbody">
    <div class="formtitle"><span>本班学生基本信息</span></div>
    <?php
        foreach($person as $k => $v){
    ?>
    <div style=" width: 100px;height: 30px;">
        <input type="checkbox" name="test" value="<?php echo $v['stu_id']?>"/><?php echo $v['stu_name']?>组
    </div>
    <?php
    }
    ?>
    <label>&nbsp;</label><input name="" type="button" class="btn" id='pk' value="PK"/>
</div>
</body>
</html>

<script src="{{URL::asset('')}}js/jquery-1.9.1.min.js"></script>
<script src="{{URL::asset('')}}js/jquery.selectlist.js"></script>
<script type="text/javascript">
    $("#pk").click(function(){
        var str="";
        $('input[name="test"]:checked').each(function(){
            str+=','+$(this).val();
        });
        if(str == ""){
            alert("请您选择要PK的小组");

        return false;
        }else if((str.length)<4){
            alert("您选一个组，怎么PK");

        return false;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id=str.substr(1);
        $.ajax({
            type: "POST",
            url: "{{url('group/group_pk')}}",
            data: "id="+id,
            success: function(msg){
                if(msg == 0){
                    alert("分配PK组失败");
                }else{
                    alert("成功");location.href="{{url('group/chose_grouper')}}";
                }
            }
        });
    })
</script>
<script>
    $(function(){
        var num = 0;
        $(":checkbox").each(function(){
            $(this).click(function(){
                if($(this)[0].checked) {
                    ++num;
                    if(num == 2) {
                        //alert("最多选择 三项 的上限已满, 其他选项将会变为不可选.");
                        $(":checkbox").each(function(){
                            if(!$(this)[0].checked) {
                                $(this).attr("disabled", "disabled");
                            }
                        });
                    }
                }else{
                    --num;
                    if(num <= 1) {
                        $(":checkbox").each(function(){
                            if(!$(this)[0].checked) {
                                $(this).removeAttr("disabled");
                            }
                        });
                    }
                }
            });
        });
    })
</script>