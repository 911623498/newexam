<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    {{--<link href="css/style.css" rel="stylesheet" type="text/css" />--}}
    {{--<link href="css/select.css" rel="stylesheet" type="text/css" />--}}
    {{--<script type="text/javascript" src="js/jquery.js"></script>--}}
    {{--<script type="text/javascript" src="js/jquery.idTabs.min.js"></script>--}}
    {{--<script type="text/javascript" src="js/select-ui.min.js"></script>--}}
    {{--<script type="text/javascript" src="editor/kindeditor.js"></script>--}}

    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('')}}css/select.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('')}}css/bootstrap.css" />
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}js/select-ui.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}editor/kindeditor.js"></script>
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
        <li><a href="#">用户管理</a></li>
    </ul>
</div>

<div class="formbody">

    <div id="usual1" class="usual">

        <div class="itab">
            <ul>

                <li><a href="#tab1" >添加用户</a></li>
                <li><a href="#tab2" class="selected">用户列表</a></li>
            </ul>
        </div>

        <div id="tab1" class="tabson">
            <form action="{{URL('privilege/userInfo')}}" method="post">
            <ul class="forminfo">
                <li><label><b>*</b> 用户名</label><input name="use_name" type="text" class="dfinput"  value=""/></li>
                <li><label><b>*</b> 密码</label><input name="use_pwd" type="password" class="dfinput" value=""  /></li>
                <li><label><b>*</b> 姓名</label><input name="use_names" type="text" class="dfinput" value=""/></li>
                 <li><label>&nbsp;</label><input id = 'sbt' type="submit" class="scbtn" value="马上添加"/></li>
            </ul>
            </form>
        </div>
        <div id="tab2" class="tabson">

            <table class="tablelist">
                <thead>
                <tr>
                    <th><input name="" type="checkbox" value="" checked="checked"/></th>
                    <th>编号</th>
                    <th>用户名</th>
                    <th>姓名</th>
                    <th>所属</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $v)

                    <tr id="{{$v['use_id']}}">
                        <td><input name="" type="checkbox" value="" /></td>
                        <td>{{$v['use_id']}}</td>
                        <td>
                            {{$v['use_name']}}
                        </td>
                        <td>{{$v['use_names']}}</td>
                        <td>{{$v['cla_name']}}</td>
                        <td><a href="javascript:void(0)" class="ini">初始化密码</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="del"> 删除</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <center>{!! $data->render() !!}</center>

        </div>
    </div>
    <script>
        $(function(){
            $('.del').click(function () {
                var use_id =  $(this).parents('tr').attr('id');
                var last_id = $(this).parents('table tr:last').attr('id');
               if(confirm('确定要删除吗?')){
                   $.ajax({
                       type:"post",
                       url:"{{URL('privilege/userDel')}}",
                       data:{
                           use_id:use_id,
                           last_id:last_id
                       },
                       success:function(msg){
                           var data = eval('('+msg+')');
                           if(data.status == 0){
                               alert('删除失败')
                           }else if(data.status== 1){
                               $('#'+use_id).remove();
                               var str = ''
                               $.each(data.msg, function (k,v) {
                                   str+= '<tr id="'+v.use_id+'">'
                                   str+='<td><input name="" type="checkbox" value="" /></td>'
                                   str+='<td>'+v.use_id+'</td>'
                                   str+='<td>'+v.use_name+'</td>'
                                   str+='<td>'+v.use_names+'</td>'
                                   str+='<td>'+v.cla_name+'</td>'
                                   str+='<td><a href="javascript:void(0)" class="ini">初始化密码</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="del"> 删除</a></td>'
                                   str+='</tr>'
                               })
                               $('tbody').append(str);
                           }else if(data.status== 2){
                               $('#'+use_id).remove();
                           }
                       }
                   })
               }
            })

            $('.ini').click(function (){
                var use_id =  $(this).parents('tr').attr('id');
                if(confirm('确定初始化吗?')){
                    $.ajax({
                        type:"post",
                        url:"{{URL('privilege/userIni')}}",
                        data:{
                            use_id:use_id
                        },
                        dataType:'json',
                        success:function(msg){
                            if(msg.status == 1){
                                alert(msg.msg);
                            }else{
                                alert(msg.error);
                            }
                        }
                    })
                }
            })
        })
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
