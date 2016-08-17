<?php error_reporting(0);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
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
        <li><a href="#">成绩列表</a></li>
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
            <ul class="seachform">
                <li>
                    <div style="margin-right: 0px;">
                        <span style="height: 30px;width: 50px; float: left;font-size: 20px; color: red">机试</span> &nbsp;
                        <span style="height: 30px;width: 50px;  float: right;font-size: 20px; color: blue" >理论</span>
                    </div>
                </li>
                <div id="info1">
                    <li style="float: right"><input name="" type="button"  value="成才率:"/>{{$arr1['chengcaikv']}}</li>
                    <li style="float: right"><input name="" type="button"  value="出勤率:"/>{{$arr1['chuqin']}}</li>
                    <li style="float: right"><input name="" type="button"  value="作弊人数:"/>{{$arr1['zuobi_ll']}}人</li>
                    <li style="float: right"><input name="" type="button"  value="请假/休学人数:"/>{{$arr1['qingxiu']}}人</li>
                    <li style="float: right"><input name="" type="button"  value="机试不及格人数:"/>{{$arr1['bujige_js']}}人</li>
                    <li style="float: right"><input name="" type="button"  value="理论不及格人数:"/>{{$arr1['bujige_ll']}}人</li>
                    <li style="float: right"><input name="" type="button"  value="班级人数:"/>{{$arr1['renshu']}}人</li>
                </div>
            </ul>
            <table class="tablelist">
                <thead>
                <?php $num=1;?>
                <tr id="btn3">
                    <th>姓名</th>
                    @foreach($table as $k=>$v)
                        @if($v['date_status']==1)
                            <th><a href="javascript:" onclick="click_day({{$v['stu_zduan']}})">{{$v['stu_zduan']}}天</a></th>
                        @elseif($v['date_status']==2)
                            <th><a href="javascript:" onclick="click_day({{$v['stu_zduan']}})">周考{{$num++}}</a></th>
                        @elseif($v['date_status']==3)
                            <th><a href="javascript:" onclick='click_day("{{$v['stu_zduan']}}")'>月考</a></th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($data as $k=>$v)
                    <tr>
                        <td>
                            @if($v['stu_pid'] == 1)
                                <font style="font-size: 16px;font-weight:bold;">{{$v['stu_name']}} ( {{$v['stu_group']}})</font>
                            @else
                                {{$v['stu_name']}}
                            @endif
                        </td>
                        {{--<td>{{$v['stu_care']}}</td>--}}
                        <td><p><font style="color:#0000ff"><?php echo $v[1][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[1][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[2][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[2][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[3][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[3][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[4][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[4][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[5][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[5][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[6][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[6][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[7][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[7][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[8][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[8][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[9][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[9][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[10][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[10][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[11][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[11][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[12][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[12][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[13][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[13][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[14][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[14][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[15][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[15][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[16][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[16][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[17][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[17][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[18][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[18][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[19][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[19][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v[20][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v[20][0]?></font></p></td>
                        <td><p><font style="color:#0000ff"><?php echo $v['yueekao'][0]?></font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red"><?php echo $v['yueekao'][0]?></font></p></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" value="{{$cla_id}}" id="hid1"/>
    <script type="text/javascript">
        $("#usual1 ul").idTabs();
    </script>

    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>

    <!-- 固定悬浮 -->
    <script>
        $(document).ready(function(){
            //得到截止部分到顶部距离
            var btn3top=$("#btn3").offset().top;
            //alert(btn3top);
            //获取浏览器对象（window） 滚动属性（scroll）
            $(window).scroll(function (){
                //获取滚动条滚动距离
                var WT = $(this).scrollTop();
                //alert(WT);
                //判断滚动条滚动距离是否大于或等于截止距离
                if(WT  >= btn3top)
                {
                    //如果大于或等于截止距离 那么截止距离就等于滚动条距离
                    $("#btn3").offset({'top':WT});
                }
                else
                {
                    $("#btn3").offset({'top':btn3top});
                }
            });
        });

        /* 本班考试成才详情 */
        function click_day(day)
        {
            var cla_id = $("#hid1").val();
            $.get("{{URL('grade/sel_info')}}",{cla_id:cla_id,day:day},function(msg){
                $("#info1").html(msg);
            })
        }
    </script>
</div>
</body>
</html>

