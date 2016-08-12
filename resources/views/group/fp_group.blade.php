<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>双列表</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('')}}css/hdw.css"/>
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery-1.6.4.min.js"></script>
    {{--<script type="text/javascript" src="{{URL::asset('')}}js/hdw.js"></script>--}}
</head>
<body>

<body>
<div class="big-div">
    <div class="content">
        <select multiple="multiple" id="select1">
            <?php
            foreach($list as $k=>$v){
            ?>
            <option value="<?php echo $v['stu_id']?>"><?php echo $v['stu_name']?></option>

            <?php
            }
            ?>

        </select>
        <span id="add">选中右移>></span> <span id="add_all">全部右移>></span>
    </div>
    <div class="content">
        <select multiple="multiple" id="select2"></select>
        <span id="remove">选中左移>></span><span id="remove_all">全部左移>></span>
    </div>
    <button class="but" id="fp">分配</button>
</div>
</body>

</body>
</html>
<script>

    $("#fp").click(function(){
        //获取选中的人的
        size=$("#select2 option").size();
        //获取选中的值
        var str = $("#select2 option").map(function(){return $(this).val();}).get().join(", ");

        if(size == ""){
            alert("请选择要分配的小组成员");
            return false;
        }else if(size < 2){
            alert("每组成员最少两个");
            return false;
        }else if(size > 6){
            alert("每个组最多6个人");
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: "{{url('group/fenpei')}}",
                data: "ss="+str,
                success: function(msg){
                    if(msg == 1){
                        alert("分配小组成功");localtion.href="{{url('group/fenpei')}}";
                    }else{
                        alert("分配小组失败");localtion.href="{{url('group/fenpei')}}";
                    }
//                    alert(msg)
                }
            });
        }

//        var s="";
//        $("#select1 option:selected").each(function(){
//            s+=','+$(this).val();
//        });


            {{--$.ajax({--}}
                {{--type: "POST",--}}
                {{--url: "{{url('group/fenpei')}}",--}}
                {{--data: "ss="+ss,--}}
                {{--success: function(msg){--}}
                    {{--alert(  msg );--}}
                    {{--return false;--}}
                {{--}--}}
            {{--});--}}
//            $("#select1 option:selected").appendTo("#select2");


    });

</script>

<script>
    $(document).ready(function(){

        $("#add").click(function(){

            $("#select1 option:selected").appendTo("#select2");

        });

        $("#add_all").click(function(){

            $("#select1 option").appendTo("#select2");

        });

        $("#remove").click(function(){

            $("#select2 option:selected").appendTo("#select1");

        });

        $("#remove_all").click(function(){

            $("#select2 option").appendTo("#select1");

        });

        $("#select1").dblclick(function(){

            $("#select1 option:selected").appendTo("#select2");

        });

        $("#select2").dblclick(function(){

            $("#select2 option:selected").appendTo("#select1");

        });


    });
</script>