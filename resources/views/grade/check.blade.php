<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<style type="text/css">
    #bg{ display: none; position: absolute; top: 0%; left: 0%; width: 100%; height: 100%; background-color: black; z-index:1001; -moz-opacity: 0.7; opacity:.70; filter: alpha(opacity=70);}
    #show{display: none; position: absolute; top: 25%; left: 22%; width: 53%; height: 49%; padding: 8px; border: 8px solid #E8E9F7; background-color: white; z-index:1002; overflow: auto;}
</style>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>成绩审核</title>
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
<div id="bg"></div>
    <div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">成绩管理</a></li>
    <li><a href="#">成绩审核</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar1">
                <li><label>&nbsp;</label><input name="" type="button" class="btn" id='look' value="查看"/></li>
                <li><label>&nbsp;</label><input name="" type="button" class="btn" id='check' value="审核通过"/></li>
                <li><label>&nbsp;</label><input name="" type="button" class="btn" id='no_check' value="审核不通过"/></li>
            </ul>

        </div>
    <table class="tablelist">
        <thead>
        <tr>
            <th>选择</th>
            <th>小组<i class="sort"><img src="{{URL::asset('')}}images/px.gif" /></i></th>
            <th>考试日期</th>
            <th>审核状态</th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach($check as $k=>$v){
        ?>
        <tr id="{{$v['che_id']}}">
            <th><input name="radio" type="RADIO" value="{{$v['grade']}}" tian="{{$v['exam_day']}}" sign="{{$v['che_id']}}"/></th>
            <th><?php echo "第".$v['grou_id']."组"?></th>
            <th>
            @if($v['exam_day']=='yuekao')
                        月考
                @else
                    <?php echo "第".$v['exam_day']."天"?>
                @endif
            </th>
            <th class="{{$v['che_id']}}">
                @if($v['status']==0)
                    未审核
                @elseif($v['status']==1)
                    未通过
                @endif
            </th>
        </tr>
        <?php
        }
        ?>
        </tbody>

        {{--<HR style="border:3 double #987cb9" width="80%" color=#987cb9 SIZE=3>--}}
        {{--<HR style="border:1 dashed #987cb9" width="80%" color=#987cb9 SIZE=1>--}}
        {{--<HR style="FILTER: alpha(opacity=0,finishopacity=100,style=1)" width="80%" color=#987cb9 SIZE=3>--}}

    </table>
    <div class="tip">
        <div class="tiptop"><img src="{{URL::asset('')}}images/px.gif" /><span>分数列表</span><a id="close"></a></div>
        <table class="tablelist">
            <thead>
            <tr>
                <th>姓名<i class="sort"><img src="{{URL::asset('')}}images/px.gif" /></i></th>
                <th>学号</th>
                <th>理论成绩</th>
                <th>机试成绩</th>
            </tr>
            </thead>

            <tbody id="tbody">

            </tbody>

        </table>
        <div class="tipbtn">
        {{--<input name="" type="button"  class="cancel" value="取消" id="close" />--}}
        </div>
    <script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
    </script>

</body>
</html>
<script src="{{URL::asset('')}}js/jquery-1.9.1.min.js"></script>
<script src="{{URL::asset('')}}js/jquery.selectlist.js"></script>
<script type="text/javascript">
    /** 审核通过 */
    $("#check").click(function(){
       var grade = $('input:radio:checked').val();
       var day = $('input:radio:checked').attr('tian');
       var id = $('input:radio:checked').attr('sign');
       if(!grade){
           return;
       }else{
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
           $.ajax({
               type: "POST",
               url: "{{url('grade/exam_insert')}}",
               data:{grade:grade,day:day,id:id},
               success: function(msg){
                   $("#"+id).remove();
               }
           });
       }
    })

    /** 审核不通过 */
    $("#no_check").click(function(){
        var id = $('input:radio:checked').attr('sign');
        if(!id){
            return;
        }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{url('grade/exam_update')}}",
                data:{id:id},
                success: function(msg){
                    if(msg==1){
                        $("."+id).html("未通过");
                    }
                    //alert(msg)
                    //$("#"+id).remove();
                }
            });
        }
    })

    //显示遮罩层
    $("#look").click(function(){
        var id = $('input:radio:checked').attr('sign');
        if(!id){
            return;
        }else{
            var str = "";
            $.get("{{url('grade/exam_info')}}",{id:id},function(msg){
                var data = eval("("+msg+")")
                $.each(data,function(key,val){
                    str+="<tr>";
                    str+="<th>"+val.stu_name+"</th>";
                    str+="<th>"+val.stu_care+"</th>";
                    str+="<th>"+val.chengji[0]+"分</th>";
                    str+="<th>"+val.chengji[1]+"分</th>";
                    str+="</tr>";
                });
                $("#tbody").html(str)
                $(".tip").show();
                $("#bg").show();
            });
//            $(".tip").show();
//            $("#bg").show();
        }
    })
    //关闭遮罩层
    $("#close").click(function(){
        $(".tip").hide();
        $("#bg").hide();
    })
</script>
