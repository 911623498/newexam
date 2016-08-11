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
    <link rel="stylesheet" type="text/css" href="{{URL::asset('')}}css/bootstrap.css" />
    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('')}}css/select.css" rel="stylesheet" type="text/css" />
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
        <li><a href="#">角色管理</a></li>
    </ul>
</div>

<div class="formbody">


    <div id="usual1" class="usual">

        <div class="itab">
            <ul>
                <li><a href="#tab1" class="selected">角色列表</a></li>
                <li><a href="#tab2">角色添加</a></li>
            </ul>
        </div>
        <div id="tab1" class="tabson">

            <table class="tablelist">
                <thead>
                <tr>
                    <th><input name="" type="checkbox" value="" checked="checked"/></th>
                    <th>编号</th>
                    <th>角色名称</th>
                    <th>是否启用</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $v)
                    <tr id="{{$v['role_id']}}">
                        <td><input name="" type="checkbox" value="" /></td>
                        <td>{{$v['role_id']}}</td>
                        <td class="role_name">{{$v['role_name']}}</td>
                        <td id="a{{$v['role_id']}}">
                            @if($v['role_status']==0)
                                <a href="javascript:void (0)"  onclick="role_status({{$v['role_id']}},1)">是</a>
                            @else
                                <a href="javascript:void (0)"style="color: red" onclick="role_status({{$v['role_id']}},0)">否</a>
                            @endif
                        </td>
                        <td class="role_intro">{{$v['role_intro']}}</td>
                        <td> <a href="{{URL('privilege/role_empower?role_id=')}}{{$v['role_id']}}" style="color: #056dae;" class="empower"> 赋权</a> | <a href="javascript:void (0)" class="tablelink"> 删除</a></td>
                    </tr>
                @endforeach
                </tbody>
                </tbody>
            </table>
            <center>{!! $data->render() !!}</center>
        </div>
        <div id="tab2" class="tabson">
            <form action="{{URL('privilege/role_add')}}" method="post">
            <ul class="forminfo">
                <li><label>角色名称<b>*</b></label><input name="role_name" type="text" class="dfinput" value=""  style="width:518px;"/></li>

                <li><label>是否启用<b>*</b></label>
                    &nbsp;&nbsp;<input type="radio" value="0" name="role_status">
                    &nbsp;&nbsp;是
                    &nbsp;&nbsp;<input type="radio" value="1" name="role_status">
                    &nbsp;&nbsp;否
                </li>
                <li><label>角色描述 <b>*</b></label>


                    <textarea id="content7" name="role_intro" style="width:700px;height:250px;visibility:hidden;"></textarea>

                </li>
                <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="角色添加"/></li>
            </ul>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $("#usual1 ul").idTabs();
    </script>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</div>
</body>
</html>
<script type="text/javascript">
    /**
     * 修改状态
     **/
    function role_status(role_id,role_status){
        $.ajax({
            type: "POST",
            url: "{{URL('privilege/role_update_status')}}",
            data: "role_id="+role_id+"&role_status="+role_status,
            success: function(msg){
                if(msg!=0){
                    $("#a"+role_id).html(msg);
                }
            }
        });
    }
    /**
     * 赋权
     **/
    {{--$(".empower").click(function(){--}}
        {{--var role_id=$(this).parent().parent().attr('id');--}}
        {{--$.ajax({--}}
            {{--type: "POST",--}}
            {{--url: "{{URL('privilege/role_empower')}}",--}}
            {{--data: "role_id="+role_id,--}}
            {{--success: function(msg){--}}

            {{--}--}}
        {{--});--}}
    {{--});--}}
    /**
     * 删除角色
     */
    $(".tablelink").click(function(){
        var role_id=$(this).parent().parent().attr('id');
        $.ajax({
            type: "POST",
            url: "{{URL('privilege/role_delete')}}",
            data: "role_id="+role_id,
            success: function(msg){
                if(msg==1){
                    $("#"+role_id).empty();
                }
            }
        });
    });
    //在页面装载时，让所有的角色名称都拥有点击事件
    $(document).ready(function(){
        //找到所有td节点
        //var tds = $("td");
        //var tds = $("#sampleName");
        //找到节点
        var tds = $(".role_name");
        //alert(tds);
        //给所有的td节点增加点击事件
        tds.click(nameclick);
    });
    //即点击改
    function nameclick(){
        var clickfunction = this;
        //0,获取当前的td节点
        var td = $(this);
        //获取id
        var role_id = $(this).parent().attr('id');
        //alert(pow_id);
        //1,取出当前td中的文本内容保存起来
        var text = $(this).text();
        //2，清空td里边内同
        td.html("");
        //3,建立一个文本框，也就是建一个input节点
        var input = $("<input>");
        //4,设置文本框中值是保存起来的文本内容
        input.attr("value",text);
        input.blur(function(event){
            var inputnode = $(this);
            //获取当前文本框的内容
            var role_name = inputnode.val();
            //清空td里边的内容,然后将内容填充到里边
            var tdNode = inputnode.parent();
            tdNode.html(role_name);
            //让td重新拥有点击事件
            tdNode.click(nameclick);
            if(role_name != text){                    //只有当内容不一样时才进行保存
                //调用该方法与后台交互
                $.ajax({
                    type: "POST",
                    url: "{{URL('privilege/role_update_name')}}",
                    data: "role_id="+role_id+"&role_name="+role_name,
                    success: function(msg){
                        if(msg==0){
                            alert("修改失败");
                        }
                    }
                });
            }
        });
        //4.5让文本框可以相应键盘按下的事件
        input.keyup(function(event){
            //记牌器当前用户按下的键值
            var myEvent = event || window.event;//获取不同浏览器中的event对象
            var kcode = myEvent.keyCode;
            //判断是否是回车键按下
            if(kcode == 13){
                var inputnode = $(this);
                //获取当前文本框的内容
                var role_name = inputnode.val();
                //清空td里边的内容,然后将内容填充到里边
                var tdNode = inputnode.parent();
                tdNode.html(role_name);
                //让td重新拥有点击事件
                tdNode.click(nameclick);
                if(role_name != text){                    //只有当内容不一样时才进行保存
                    //调用该方法与后台交互
                    $.ajax({
                        type: "POST",
                        url: "{{URL('privilege/role_update_name')}}",
                        data: "role_id="+role_id+"&role_name="+role_name,
                        success: function(msg){
                            if(msg==0){
                                alert("修改失败");
                            }
                        }
                    });
                }
            }
        });
        //5，把文本框加入到td里边去
        td.append(input);
        //5.5让文本框里边的文章被高亮选中
        //需要将jquery的对象转换成dom对象
        var inputdom = input.get(0);
        inputdom.select();
        //6,需要清楚td上的点击事件
        td.unbind("click");
    }

    //在页面装载时，让所有的角色名称都拥有点击事件
    $(document).ready(function(){
        //找到所有td节点
        //var tds = $("td");
        //var tds = $("#sampleName");
        //找到节点
        var tds = $(".role_intro");
        //alert(tds);
        //给所有的td节点增加点击事件
        tds.click(introclick);
    });
    //即点击改
    function introclick(){
        var clickfunction = this;
        //0,获取当前的td节点
        var td = $(this);
        //获取id
        var role_id = $(this).parent().attr('id');
        //alert(pow_id);
        //1,取出当前td中的文本内容保存起来
        var text = $(this).text();
        //2，清空td里边内同
        td.html("");
        //3,建立一个文本框，也就是建一个input节点
        var input = $("<input>");
        //4,设置文本框中值是保存起来的文本内容
        input.attr("value",text);
        input.blur(function(event){
            var inputnode = $(this);
            //获取当前文本框的内容
            var role_intro = inputnode.val();
            //清空td里边的内容,然后将内容填充到里边
            var tdNode = inputnode.parent();
            tdNode.html(role_intro);
            //让td重新拥有点击事件
            tdNode.click(introclick);
            if(role_intro != text){                    //只有当内容不一样时才进行保存
                //调用该方法与后台交互
                $.ajax({
                    type: "POST",
                    url: "{{URL('privilege/role_update_intro')}}",
                    data: "role_id="+role_id+"&role_intro="+role_intro,
                    success: function(msg){
                        if(msg==0){
                            alert("修改失败");
                        }
                    }
                });
            }
        });
        //4.5让文本框可以相应键盘按下的事件
        input.keyup(function(event){
            //记牌器当前用户按下的键值
            var myEvent = event || window.event;//获取不同浏览器中的event对象
            var kcode = myEvent.keyCode;
            //判断是否是回车键按下
            if(kcode == 13){
                var inputnode = $(this);
                //获取当前文本框的内容
                var role_intro = inputnode.val();
                //清空td里边的内容,然后将内容填充到里边
                var tdNode = inputnode.parent();
                tdNode.html(role_intro);
                //让td重新拥有点击事件
                tdNode.click(introclick);
                if(role_intro != text){                    //只有当内容不一样时才进行保存
                    //调用该方法与后台交互
                    $.ajax({
                        type: "POST",
                        url: "{{URL('privilege/role_update_intro')}}",
                        data: "role_id="+role_id+"&role_intro="+role_intro,
                        success: function(msg){
                            if(msg==0){
                                alert("修改失败");
                            }
                        }
                    });
                }
            }
        });
        //5，把文本框加入到td里边去
        td.append(input);
        //5.5让文本框里边的文章被高亮选中
        //需要将jquery的对象转换成dom对象
        var inputdom = input.get(0);
        inputdom.select();
        //6,需要清楚td上的点击事件
        td.unbind("click");
    }
</script>