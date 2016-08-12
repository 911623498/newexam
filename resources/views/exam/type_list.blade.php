<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="{{URL::asset('')}}css/lyz.calendar.css" rel="stylesheet" type="text/css" />

    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('')}}css/select.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}js/select-ui.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}editor/kindeditor.js"></script>

    <script src="{{URL::asset('')}}js/lyz.calendar.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        KE.show({
            id : 'content7',
            cssPath : "{{URL::asset('')}}index.css"
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(e) {
            $(".select1").uedSelect({
                width : 345
            });
            $(".select2").uedSelect({
                width : 167
            });
            $(".select3").uedSelect({
                width : 100
            });
        });
    </script>
</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">考试周期录入</a></li>
    </ul>
</div>

<div class="formbody">


    <div id="usual1" class="usual">

        <div class="itab">
            <ul>
                <li><a href="#tab1">考试周期录入</a></li>
                <li><a href="#tab2" class="selected">考试类型录入</a></li>
            </ul>
        </div>

        <div id="tab1" class="tabson">
            <ul class="forminfo">
                <li>考试周期录入:
                    <input id="txtBeginDate" style="width:170px;padding:7px 10px;border:1px solid #ccc;margin-right:10px;"/>
                    <input id="txtEndDate" style="width:170px;padding:7px 10px;border:1px solid #ccc;" />
                </li>
                <input type="hidden" name="_token" value="<?php echo csrf_token();?>"/>
                <li><label>&nbsp;</label><input name="" onclick="save()" type="button" class="btn" value="开始录入"/></li>
            </ul>


        </div>
        <div id="tab2" class="tabson">
            <form action="{{URL('exam/exam_status')}}" method="post">
                <table class="tablelist">
                    <thead>
                    <tr>
                        <th>编号<i class="sort"><img src="{{URL::asset('')}}images/px.gif" /></i></th>
                        <th>日期</th>
                        <th>星期</th>
                        <th>考试类型</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($arr as $kk=>$vv){?>
                    <tr>
                        <td id="date_status_<?php echo $vv['date_id'];?>" value="<?php echo $vv['date_id'];?>">
                            <?php echo $vv['date_id'];?>
                            <input  type="hidden" id="zt" name="zt[]" value="<?php echo $vv['date_id'];?>" /></td>
                        <td><?php echo $vv['date_time'];?></td>
                        <td><?php echo $vv['date_xingqi'];?></td>
                        <td>
                            <?php
                            $count=count($arr);
                            $key=$kk+1;
                            if($key==$count)
                            {
                            ?>
                            <input  type="radio" checked="checked" id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="3"/>月考
                            <?php }elseif($vv['date_status']==1){?>
                            <input  type="radio" checked="checked" id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="1"/>日考
                            <input  type="radio" id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="2"/>周考
                            <input  type="radio" id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="0"/>无考试
                            <?php }elseif($vv['date_status']==2){?>
                            <input  type="radio"  id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="1"/>日考
                            <input  type="radio" checked="checked" id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="2"/>周考
                            <input  type="radio" id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="0"/>无考试
                            <?php }else{?>
                            <input  type="radio"  id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="1"/>日考
                            <input  type="radio"  id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="2"/>周考
                            <input  type="radio" checked="checked" id="date_status_<?php echo $vv['date_id'];?>" name="date_status[<?php echo $vv['date_id']; ?>]" value="0"/>无考试
                            <?php }?>
                        </td>
                    </tr>
                    <input type="hidden" name="_token" value="<?php echo csrf_token();?>"/>
                    <?php }?>
                    </tbody>
                </table>
                <input style="margin-left: 500px"   type="submit" class="btn" value="确定录入"/>
            </form>
        </div>
    </div>
    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>

        <div class="tipinfo">
            <span><img src="{{URL::asset('')}}images/ticon.png" /></span>
            <div class="tipright">
                <p>考试周期录入会清空上次所录入信息，是否确定? </p>
                <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
            </div>
        </div>
        <div class="tipbtn">
            <input name="" type="button"  class="sure" value="确定" />&nbsp;
            <input name="" type="button"  class="cancel" value="取消" />
        </div>
    </div>
    <script>
        $(function () {
            $("#txtBeginDate").calendar({});
            $("#txtEndDate").calendar({});
        });
        $(".sure").click(function(){
            $(".tip").fadeOut(100);
            var start_date=$("#txtBeginDate").val();
            var end_date=$("#txtEndDate").val();
            var url="{{URL('exam/save')}}";
            if(start_date=="")
            {
                alert("你必须选择开始日期")
            }else if(end_date=="")
            {
                alert("你必须选择结束日期")

            }else{
                var data={"start_date":start_date,"end_date":end_date};
                $.get(url,data,function(msg){
                    //alert(msg)
                    if(msg==1)
                    {
                        location.href="{{URL('exam/type_list')}}?start_date="+start_date+'&end_date='+end_date;
                    }else if(msg==2)
                    {
                        alert("考试周期录入必须大于等于21天")
                    }else
                    {
                        alert("考试周期尚未结束，你不能进行录入")
                    }
                })
            }
        });
        $(".cancel").click(function(){
            $(".tip").fadeOut(100);
        });
        $(".tiptop a").click(function(){
            $(".tip").fadeOut(200);
        });
        function save(){
            var start_date=$("#txtBeginDate").val();
            var end_date=$("#txtEndDate").val();
            if(start_date=="")
            {
                alert("你必须选择开始日期")
            }else if(end_date=="")
            {
                alert("你必须选择结束日期")

            }else
            {
                $(".tip").fadeIn(100);
            }
        }
    </script>
    <script type="text/javascript">
        $("#usual1 ul").idTabs();
    </script>

    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>

</div>

</body>
</html>
