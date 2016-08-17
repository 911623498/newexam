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
        <li><a href="#">专业列表</a></li>
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
                <span id='sp'></span>
            </ul>
            <table class="tablelist">
                <thead>
                <tr>
                    <th>专业<i class="sort"><img src="{{URL::asset('')}}images/px.gif" /></i></th>
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
                            <a href="{{URL('grade/sel_classs')}}?id={{$v['cla_id']}}&cla_name={{$v['cla_name']}}" class="tablelink">查看班级</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--<div>{!! $data->render() !!}</div>--}}
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
                $.get("{{URL('grade/sel_class1')}}",{key:key,cla_id:cla_id},function(msg){
//                    alert(msg)
//                    return;
                    var str = "";
                    var data = eval("("+msg+")");
                    $.each(data,function(i,item){
                        $("#sp").html("<font color='red'></font>");
                        str += "<tr>";
                        str += "<td><input name='chk_list' type='checkbox' value='' /></td>";
                        str += "<td>"+item.cla_name+"</td>";
                        str += "<td>"+item.cla_intro+"</td>";
                        str += "<td>"
                        str += "<a href={{URL('grade/look_class')}}?id="+item.cla_id+" class='tablelink'>查看</a>";
                        str += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                        str += "</td>"
                        str += "</tr>"
                    });
                    $("#tr").html(str);
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
    </script>
</div>
</body>
</html>
