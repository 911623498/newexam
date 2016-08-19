<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="{{URL::asset('')}}css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('')}}css/select.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}js/select-ui.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}editor/kindeditor.js"></script>

    <script type="text/javascript">
        KE.show({
            id : 'content7',
            cssPath : './index.css'
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
        <li><a href="#">班级列表</a></li>
    </ul>
</div>

<div class="formbody">


    <div id="usual1" class="usual">
        <div class="itab">
            <ul>
                <li><a href="#tab1" class="selected">{{$cla_name}}</a></li>
            </ul>
        </div>
        <div id="tab1" class="tabson">
            <input type="hidden" id="hid" value="{{$cla_id}}">
            <ul class="seachform">
                <li><label>班级名称：</label><input name="" type="text"  id='key' class="scinput" placeholder="请输入班级名称"/></li>
                <li><label>&nbsp;</label><input name="" type="button" id='btn' class="scbtn" value="查询"/></li>

                <form action="{{URL('grade/dcxq')}}" method="post">
                    <li style="float: right">
                        <label></label>
                        <div class="vocation">
                            <select class="select1" name="day">
                                <?php $num=1;?>
                                @foreach($table as $vv)
                                    @if($vv['stu_zduan']=='yuekao')
                                        <option value="{{$vv['stu_zduan']}}">|--月考成绩</option>
                                    @else
                                        @if($vv['date_status']=='2')
                                            <option value="{{$vv['stu_zduan']}}"><font style="font-weight: bold;"> |--第<?php echo $num++;?>周考</font></option>
                                        @else
                                            <option value="{{$vv['stu_zduan']}}">第{{$vv['stu_zduan']}}天考试</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                            <input type="hidden" value="{{$cla_id}}" name="cla_id"/>
                        </div>
                    </li>
                    <li  style="float: right">
                        <label>&nbsp;</label><input name="" type="submit" class="scbtn" value="导出考试详情"/>
                    </li>
                </form>

                <span id='sp'></span>
            </ul>
            <table class="tablelist">
                <thead>
                <tr>
                    <th>班级<i class="sort"><img src="{{URL::asset('')}}images/px.gif" /></i></th>
                    <th>备注</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody id="tr">
                @foreach($data as $k=>$v)
                    <tr>
                        <td>{{$v['cla_name']}}</td>
                        <td>{{$v['cla_intro']}}</td>
                        <td>
                            <a href="{{URL('grade/look_class')}}?id={{$v['cla_id']}}" class="tablelink">查看</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{URL('grade/dc')}}?id={{$v['cla_id']}}" class="tablelink">导出</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div id="display">{!! $data->render() !!}</div>
        </div>
    </div>
    <script type="text/javascript">
        $("#usual1 ul").idTabs();
    </script>

    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>

    <script>
        $("#btn").click(function(){
            var key = $("#key").val();
            var cla_id = $("#hid").val();
            if(key == ""){
                $("#sp").html("<font color='red'>*请输入班级名称</font>");
                return;
            }else{
                $.get("{{URL('grade/sel_class')}}",{key:key,cla_id:cla_id},function(msg){
                    var str = "";
                    var data = eval("("+msg+")");
                    $.each(data,function(i,item){
                        $("#sp").html("<font color='red'></font>");
                        str += "<tr>";
                        str += "<td>"+item.cla_name+"</td>";
                        str += "<td>"+item.cla_intro+"</td>";
                        str += "<td>"
                        str += "<a href={{URL('grade/look_class')}}?id="+item.cla_id+" class='tablelink'>查看</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        str += "<a href={{URL('grade/dc')}}?id="+item.cla_id+" class='tablelink'>导出</a>";
                        str += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                        str += "</td>"
                        str += "</tr>"
                    });
                    $("#tr").html(str);
                    $("#display").hide();
                })
            }
        })
    </script>

    <script type="text/javascript">
        //全选
        $("#box").click(function(){
            if(this.checked){
                $("input[name='chk_list']").attr("checked", true);
            }else{
                $("input[name='chk_list']").attr("checked", false);
            }
        });

        //审核通过
        $("#check").click(function(){
            var ids = "";
            var check = $(":input[name='chk_list']");
            for( var i=0;i<check.length;i++ )
            {
                if(check[i].checked==true)
                {
                    ids +=','+check[i].value;
                }
            }
            ids = ids.substr(1);
            if(ids==""){
                $("#sp").html("<font color='red'>*请选择审核班级</font>");
            }else{
                $("#sp").html("<font color='red'></font>");
                $.get("{{URL('grade/check')}}",{ids:ids},function(msg){
                    if(msg==1){
                        window.location.reload();
                    }
                })
            }
        });

        //审核不通过
        $("#no_check").click(function(){
            var ids = "";
            var check = $(":input[name='chk_list']");
            for( var i=0;i<check.length;i++ )
            {
                if(check[i].checked==true)
                {
                    ids +=','+check[i].value;
                }
            }
            ids = ids.substr(1);
            if(ids==""){
                $("#sp").html("<font color='red'>*请选择审核班级</font>");
            }else{
                $("#sp").html("<font color='red'></font>");
                $.get("{{URL('grade/no_check')}}",{ids:ids},function(msg){
                    if(msg==1){
                        window.location.reload();
                    }
                })
            }
        })

    </script>
</div>
</body>
</html>
