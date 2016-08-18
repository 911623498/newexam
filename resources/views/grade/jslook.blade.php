<?php error_reporting(0);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
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
        <li><a href="#">成绩管理</a></li>
        <li><a href="#">查看成绩</a></li>
    </ul>
</div>

<div class="formbody">
    <div id="usual1" class="usual">

        <div class="itab">
            <ul>
                <li><a href="#tab1" class="selected">{{$cla_name}}</a></li>
                @if($pkid==1)
                    <li><a href="#tab2" style="display: none">{{$pk_name}}</a></li>
                @else
                    <li><a href="#tab2" >{{$pk_name}}</a></li>
                @endif
            </ul>
        </div>
        {{--<div class="tools">--}}
            {{--<ul class="toolbar">--}}
                {{--<li class="click" style="float: left">审核</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        <div id="tab1" class="tabson">
            <ul class="seachform">
                <li>
                    <div style="margin-right: 0px;">
                        <span style="height: 30px;width: 50px; float: left;font-size: 20px; color: red">机试</span> &nbsp;
                        <span style="height: 30px;width: 50px;  float: right;font-size: 20px; color: blue" >理论</span>
                    </div>
                </li>
                <li style="float: right"><label>&nbsp;</label><input name="" type="button" id='check' class="scbtn" value="查看未审核"/></li>
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
                <?php $num=1?>
                <?php $day=1?>
                <thead>
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
                @foreach($cla_class as $k=>$v)
                <tr>
                    <td>
                        @if($v['stu_pid'] == 1)
                            <font style="font-size: 16px;font-weight:bold;">{{$v['stu_name']}} ({{$v['stu_group']}})</font>
                        @else
                            {{$v['stu_name']}}
                        @endif
                    </td>
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
        <div id="tab2" class="tabson">
            <ul class="seachform">
                <li>
                    <div style="margin-right: 0px;">
                        <span style="height: 30px;width: 50px; float: left;font-size: 20px; color: red">机试</span> &nbsp;
                        <span style="height: 30px;width: 50px;  float: right;font-size: 20px; color: blue" >理论</span>
                    </div>
                </li>
                {{--<li style="float: right"><label>&nbsp;</label><input name="" type="button" id='check' class="scbtn" value=""/></li>--}}
                <div id="info2">
                    <li style="float: right"><input name="" type="button"  value="成才率:"/>{{$arr2['chengcaikv']}}</li>
                    <li style="float: right"><input name="" type="button"  value="出勤率:"/>{{$arr2['chuqin']}}</li>
                    <li style="float: right"><input name="" type="button"  value="作弊人数:"/>{{$arr2['zuobi_ll']}}人</li>
                    <li style="float: right"><input name="" type="button"  value="请假/休学人数:"/>{{$arr2['qingxiu']}}人</li>
                    <li style="float: right"><input name="" type="button"  value="机试不及格人数:"/>{{$arr2['bujige_js']}}人</li>
                    <li style="float: right"><input name="" type="button"  value="理论不及格人数:"/>{{$arr2['bujige_ll']}}人</li>
                    <li style="float: right"><input name="" type="button"  value="班级人数:"/>{{$arr2['renshu']}}人</li>
                </div>
            </ul>
            <table class="tablelist">
                <thead>
                <?php $number=1;?>
                <tr id="btn3">
                    <th>姓名</th>
                    @foreach($table as $k=>$v)
                        @if($v['date_status']==1)
                            <th><a href="javascript:" onclick="click_day1({{$v['stu_zduan']}})">{{$v['stu_zduan']}}天</a></th>
                        @elseif($v['date_status']==2)
                            <th><a href="javascript:" onclick="click_day1({{$v['stu_zduan']}})">周考{{$num++}}</a></th>
                        @elseif($v['date_status']==3)
                            <th><a href="javascript:" onclick='click_day1("{{$v['stu_zduan']}}")'>月考</a></th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($pk_class as $k=>$v)
                    <tr>
                        <td>
                            @if($v['stu_pid'] == 1)
                                <font style="font-size: 16px;font-weight:bold;">{{$v['stu_name']}} ( {{$v['stu_group']}})</font>
                            @else
                                {{$v['stu_name']}}
                            @endif
                        </td>
                        <td><p><font style="color:#0000ff">{{$v[1][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[1][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[2][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[2][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[3][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[3][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[4][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[4][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[5][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[5][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[6][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[6][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[7][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[7][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[8][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[8][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[9][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[9][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[10][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[10][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[11][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[11][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[12][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[12][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[13][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[13][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[14][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[14][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[15][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[15][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[16][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[16][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[17][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[17][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[18][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[18][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[19][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[19][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v[20][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v[20][1]}}</font></p></td>
                        <td><p><font style="color:#0000ff">{{$v['yuekao'][0]}}</font><br/>&nbsp;&nbsp;&nbsp;<font style="color:red">{{$v['yuekao'][1]}}</font></p></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <input type="hidden" value="{{$cla_id}}" id="hid1"/>
        <input type="hidden" value="{{$pkid}}" id="hid2"/>
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
<!-- 固定悬浮 -->
<script type="text/javascript">
    $(document).ready(function(){
        //offset偏移坐标 //top悬浮窗距离顶部距离
        var btn3top=$("#btn3").offset().top;
        //获取浏览器对象（window） 滚动属性（scroll）
        $(window).scroll(function (){
            //获取滚动条滚动距离顶部的距离
            var WT = $(this).scrollTop();
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
	
	//审核通过
	$("#check").click(function(){

		$.get("{{URL('grade/look_check')}}",{},function(msg){
			if(msg==0){
                alert("暂无未审核成绩");
            }else{
                location.href="{{URL('grade/check_exam')}}";
            }
		})
	})
	

    /* 本班考试成才详情 */
    function click_day(day)
    {
        var cla_id = $("#hid1").val();
        $.get("{{URL('grade/sel_info')}}",{cla_id:cla_id,day:day},function(msg){
           $("#info1").html(msg);
        })
    }

    /* PK考试成才详情 */
    function click_day1(day)
    {
        var cla_id = $("#hid2").val();
        $.get("{{URL('grade/sel_info')}}",{cla_id:cla_id,day:day},function(msg){
            $("#info2").html(msg);
        })
    }
</script>
