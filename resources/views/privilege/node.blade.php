<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>权限管理</title>
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
        <li><a href="#">权限管理</a></li>
    </ul>
</div>

<div class="formbody">


    <div id="usual1" class="usual">

        <div class="itab">
            <ul>
                <li><a href="#tab1" class="selected">权限列表</a></li>
                <li><a href="#tab2">添加权限</a></li>
            </ul>
        </div>


        <div id="tab1" class="tabson">


            <table class="tablelist">
                <thead>
                <tr>
                    <th><input name="" type="checkbox" value="" checked="checked"/></th>
                    <th>编号</th>
                    <th>节点名称</th>
                    <th>控制器</th>
                    <th>方法</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $v)

                    <tr id="{{$v['pow_id']}}">
                    <td><input name="" type="checkbox" value="" /></td>
                    <td>{{$v['pow_id']}}</td>
                        @if($v['pow_pid']==0)
                            <td class="pow_name">{{$v['pow_name']}}</td>
                        @else
                            <td class="pow_name">{{$v['pow_name']}}</td>
                        @endif
                    <td  class="controller">
                       {{$v['controller']}}
                    </td>
                    <td class="action">{{$v['action']}}</td>
                    <td class="pow_intro">{{$v['pow_intro']}}</td>
                    <td> <a href="#" class="tablelink"> 删除</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <center>{!! $data->render() !!}</center>
        </div>

        <div id="tab2" class="tabson">
            <form action="{{URL('privilege/node_add')}}" method="post">
            <ul class="forminfo">
                <li><label>节点名称<b>*</b></label><input name="pow_name" type="text" class="dfinput" value=""  style="width:518px;"/></li>

                <li><label>父节点<b>*</b></label>


                    <div class="vocation">
                        <select class="select1" name="pow_pid" id="pid" >
                            <option value="0">请选择</option>
                            <?php
                                foreach($power as $k=>$v){
                                    ?>
                            <option value="{{$v['pow_id']}}" controller="{{$v['controller']}}">{{$v['pow_name']}}</option>
                                <?php
                                    foreach($v['son'] as $kk=>$vv){
                                ?>
                            <option value="{{$vv['pow_id']}}" controller="{{$vv['controller']}}">|--{{$vv['pow_name']}}</option>
                            <?php
                                    }
                                }
                            ?>
                        </select>

                    </div>

                </li>

                <li><label>控制器<b>*</b></label>

                    <input name="controller" type="text" class="dfinput" value=""  style="width:518px;" id="controller"/>



                </li>
                <li><label>方法<b>*</b></label>

                    <input name="action" type="text" class="dfinput" value=""  style="width:518px;"/>



                </li>
                <li><label>描述<b>*</b></label>


                    <textarea id="content7" name="pow_intro" style="width:700px;height:250px;visibility:hidden;"></textarea>

                </li>
                <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="添加权限"/></li>
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
    $(".tablelink").click(function(){
       var pow_id=$(this).parent().parent().attr('id');
        $.ajax({
            type: "POST",
            url: "{{URL('privilege/node_delete')}}",
            data: "pow_id="+pow_id,
            success: function(msg){
                if(msg==1){
                    $("#"+pow_id).empty();
                }
            }
        });
    });

    $("#pid").change(function(){
        var controller=$("#pid").find("option:selected").attr("controller");
        $("#controller").val(controller);
    });
    //在页面装载时，让所有的pow_name都拥有点击事件
    $(document).ready(function(){
        //找到所有td节点
        //var tds = $("td");
        //var tds = $("#sampleName");
        //找到节点
        var tds = $(".pow_name");
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
        var pow_id = $(this).parent().attr('id');
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
            var inputext = inputnode.val();
            //清空td里边的内容,然后将内容填充到里边
            var tdNode = inputnode.parent();
            tdNode.html(inputext);
            //让td重新拥有点击事件
            tdNode.click(nameclick);
            if(inputext != text){                    //只有当内容不一样时才进行保存
                //调用该方法与后台交互
                $.ajax({
                    type: "POST",
                    url: "{{URL('privilege/node_update_name')}}",
                    data: "pow_id="+pow_id+"&inputext="+inputext,
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
                var inputext = inputnode.val();
                //清空td里边的内容,然后将内容填充到里边
                var tdNode = inputnode.parent();
                tdNode.html(inputext);
                //让td重新拥有点击事件
                tdNode.click(nameclick);
                if(inputext != text){                    //只有当内容不一样时才进行保存
                    //调用该方法与后台交互
                    $.ajax({
                        type: "POST",
                        url: "{{URL('privilege/node_update_name')}}",
                        data: "pow_id="+pow_id+"&inputext="+inputext,
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
    //在页面装载时，让所有的controller都拥有点击事件
    $(document).ready(function(){
        //找到所有td节点
        //var tds = $("td");
        //var tds = $("#sampleName");
        //找到节点
        var tds = $(".controller");
        //alert(tds);
        //给所有的td节点增加点击事件
        tds.click(contrclick);
    });
    //即点击改
    function contrclick(){
        var clickfunction = this;
        //0,获取当前的td节点
        var td = $(this);
        //获取id
        var pow_id = $(this).parent().attr('id');
        //alert(pow_id);
        //1,取出当前td中的文本内容保存起来
        var text = $(this).text();
        //2，清空td里边内同
        td.html("");
        //3,建立一个文本框，也就是建一个input节点
        var input = $("<input>");
        //4,设置文本框中值是保存起来的文本内容
        input.attr("value",text);
        //4.5让文本框可以相应键盘按下的事件
        input.blur(function(event){
            var inputnode = $(this);
            //获取当前文本框的内容
            var controller = inputnode.val();
            //清空td里边的内容,然后将内容填充到里边
            var tdNode = inputnode.parent();
            tdNode.html(controller);
            //让td重新拥有点击事件
            tdNode.click(contrclick);
            if(controller != text){                    //只有当内容不一样时才进行保存
                //调用该方法与后台交互
                $.ajax({
                    type: "POST",
                    url: "{{URL('privilege/node_update_controller')}}",
                    data: "pow_id="+pow_id+"&controller="+controller,
                    success: function(msg){
                        if(msg==0){
                            alert("修改失败");
                        }
                    }
                });
            }
        });
        input.keyup(function(event){
            //记牌器当前用户按下的键值
            var myEvent = event || window.event;//获取不同浏览器中的event对象
            var kcode = myEvent.keyCode;
            //判断是否是回车键按下
            if(kcode == 13 ){
                var inputnode = $(this);
                //获取当前文本框的内容
                var controller = inputnode.val();
                //清空td里边的内容,然后将内容填充到里边
                var tdNode = inputnode.parent();
                tdNode.html(controller);
                //让td重新拥有点击事件
                tdNode.click(contrclick);
                if(controller != text){                    //只有当内容不一样时才进行保存
                    //调用该方法与后台交互
                    $.ajax({
                        type: "POST",
                        url: "{{URL('privilege/node_update_controller')}}",
                        data: "pow_id="+pow_id+"&controller="+controller,
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
    //在页面装载时，让所有的action都拥有点击事件
    $(document).ready(function(){
        //找到所有td节点
        //var tds = $("td");
        //var tds = $("#sampleName");
        //找到节点
        var tds = $(".action");
        //alert(tds);
        //给所有的td节点增加点击事件
        tds.click(actionclick);
    });
    //即点击改
    function actionclick(){
        var clickfunction = this;
        //0,获取当前的td节点
        var td = $(this);
        //获取id
        var pow_id = $(this).parent().attr('id');
        //alert(pow_id);
        //1,取出当前td中的文本内容保存起来
        var text = $(this).text();
        //2，清空td里边内同
        td.html("");
        //3,建立一个文本框，也就是建一个input节点
        var input = $("<input>");
        //4,设置文本框中值是保存起来的文本内容
        input.attr("value",text);
        //4.5让文本框可以相应键盘按下的事件
        input.blur(function(event){
            var inputnode = $(this);
            //获取当前文本框的内容
            var action = inputnode.val();
            //清空td里边的内容,然后将内容填充到里边
            var tdNode = inputnode.parent();
            tdNode.html(action);
            //让td重新拥有点击事件
            tdNode.click(actionclick);
            if(action != text){                    //只有当内容不一样时才进行保存
                //调用该方法与后台交互
                $.ajax({
                    type: "POST",
                    url: "{{URL('privilege/node_update_action')}}",
                    data: "pow_id="+pow_id+"&action="+action,
                    success: function(msg){
                        if(msg==0){
                            alert("修改失败");
                        }
                    }
                });
            }
        });
        input.keyup(function(event){
            //记牌器当前用户按下的键值
            var myEvent = event || window.event;//获取不同浏览器中的event对象
            var kcode = myEvent.keyCode;
            //判断是否是回车键按下
            if(kcode == 13 ){
                var inputnode = $(this);
                //获取当前文本框的内容
                var action = inputnode.val();
                //清空td里边的内容,然后将内容填充到里边
                var tdNode = inputnode.parent();
                tdNode.html(action);
                //让td重新拥有点击事件
                tdNode.click(actionclick);
                if(action != text){                    //只有当内容不一样时才进行保存
                    //调用该方法与后台交互
                    $.ajax({
                        type: "POST",
                        url: "{{URL('privilege/node_update_action')}}",
                        data: "pow_id="+pow_id+"&action="+action,
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
    //在页面装载时，让所有的action都拥有点击事件
    $(document).ready(function(){
        //找到所有td节点
        //var tds = $("td");
        //var tds = $("#sampleName");
        //找到节点
        var tds = $(".pow_intro");
        //alert(tds);
        //给所有的td节点增加点击事件
        tds.click(pow_introclick);
    });
    //即点击改
    function pow_introclick(){
        var clickfunction = this;
        //0,获取当前的td节点
        var td = $(this);
        //获取id
        var pow_id = $(this).parent().attr('id');
        //alert(pow_id);
        //1,取出当前td中的文本内容保存起来
        var text = $(this).text();
        //2，清空td里边内同
        td.html("");
        //3,建立一个文本框，也就是建一个input节点
        var input = $("<input>");
        //4,设置文本框中值是保存起来的文本内容
        input.attr("value",text);
        //4.5让文本框可以相应键盘按下的事件
        input.blur(function(event){
            var inputnode = $(this);
            //获取当前文本框的内容
            var pow_intro = inputnode.val();
            //清空td里边的内容,然后将内容填充到里边
            var tdNode = inputnode.parent();
            tdNode.html(pow_intro);
            //让td重新拥有点击事件
            tdNode.click(pow_introclick);
            if(pow_intro != text){                    //只有当内容不一样时才进行保存
                //调用该方法与后台交互
                $.ajax({
                    type: "POST",
                    url: "{{URL('privilege/node_update_intro')}}",
                    data: "pow_id="+pow_id+"&pow_intro="+pow_intro,
                    success: function(msg){
                        if(msg==0){
                            alert("修改失败");
                        }
                    }
                });
            }
        });
        input.keyup(function(event){
            //记牌器当前用户按下的键值
            var myEvent = event || window.event;//获取不同浏览器中的event对象
            var kcode = myEvent.keyCode;
            //判断是否是回车键按下
            if(kcode == 13 ){
                var inputnode = $(this);
                //获取当前文本框的内容
                var action = inputnode.val();
                //清空td里边的内容,然后将内容填充到里边
                var tdNode = inputnode.parent();
                tdNode.html(action);
                //让td重新拥有点击事件
                tdNode.click(actionclick);
                if(action != text){                    //只有当内容不一样时才进行保存
                    //调用该方法与后台交互
                    $.ajax({
                        type: "POST",
                        url: "{{URL('privilege/node_update_action')}}",
                        data: "pow_id="+pow_id+"&action="+action,
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
