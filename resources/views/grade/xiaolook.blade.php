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
        <li><a href="#">学院</a></li>
    </ul>
</div>

<div class="formbody">


    <div id="usual1" class="usual">
        <div id="tab1" class="tabson">

            <table class="tablelist">
                <thead>
                <tr>
                    <th>学院<i class="sort"><img src="{{URL::asset('')}}images/px.gif" /></i></th>
                    <th>介绍</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody id="tr">
                @foreach($data as $k=>$v)
                    <tr>
                        <td>{{$v['cla_name']}}</td>
                        <td>{{$v['cla_intro']}}</td>
                        <td>
                            <a href="{{URL('grade/sel_xi')}}?id={{$v['cla_id']}}&cla_name={{$v['cla_name']}}" class="tablelink">查看专业</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
