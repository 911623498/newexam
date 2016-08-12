<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>成才率</title>
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

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">权限管理</a></li>
        <li><a href="#">角色管理</a></li>
    </ul>
</div>

<div class="rightinfo">
        <table class="tablelist">
            <tbody>
            <tr>
                <td>班级</td>
                <td>课程</td>
                <td>操作</td>
            </tr>
            @foreach($list as $k=>$v)
                <tr>
                    <td>{{$v['cla_name']}}</td>
                    <td>{{$v['cla_intro']}}</td>
                    <td><a href="JavaScript:void(0)" name="{{$v['cla_name']}}" id="{{$v['cla_id']}}" class="ck">查看</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
</div>
<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>
</body>
</html>
<script>
    $(function(){
       $(".ck").click(function(){
           var cla_id=$(this).attr('id');
           var cla_name=$(this).attr('name');
           location.href='{{URL('yield/yields')}}'+"?cla_id="+cla_id+"&cla_name="+cla_name;
       })
    });
</script>