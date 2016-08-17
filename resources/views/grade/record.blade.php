<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>
    <script language="javascript">
        $(function(){
            //导航切换
            $(".imglist li").click(function(){
                $(".imglist li.selected").removeClass("selected");
                $(this).addClass("selected");
            })
        });

        $(".click").click(function() {

            //获取当前网址，如： http://localhost:8083/uimcardprj/share/meun.jsp
            var curWwwPath=window.document.location.href;
            //获取主机地址之后的目录，如： uimcardprj/share/meun.jsp
            var pathName=window.document.location.pathname;
            var pos=curWwwPath.indexOf(pathName);
            //获取主机地址，如： http://localhost:8083
            var localhostPaht=curWwwPath.substring(0,pos);
            //获取带"/"的项目名，如：/uimcardprj
            var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
            //return(localhostPaht+projectName);

              var reg=/^\d\.([1-9]{1,2}|[0-9][1-9])$|^[1-9]\d{0,1}(\.\d{1,2}){0,1}$|^100(\.0{1,2}){0,1}$|^0{1}$/;

            var now_day= $("#select1  option:selected").val();
            var val= $(".grade");
            flog=1;
            flag=1;
                    for(var i=0;i<val.length;i++)
                    {
//                            //var reg=/^1?[1-9]?\d([.]\d{1,2})?$|^1[0]{2}$/;
//                            var reg=/^\d\.([1-9]{1,2}|[0-9][1-9])$|^[1-9]\d{0,1}(\.\d{1,2}){0,1}$|^100(\.0{1,2}){0,1}$|^0{1}$/;
//                            var r=reg.test(val[i].value);
//                            if(r==false)
//                            {
//                                flog=0;
//
                        inp= val[i].value;

                        if(inp=="监考")
                        {
                            flog=1;
                        }
                        else if(inp=="请假")
                        {
                            flog=1;
                        }
                        else if(inp=="休学")
                        {
                            flog=1;
                        }
                        else if(inp=="作弊")
                        {
                            flog=1;
                        }
                        else if(reg.test(inp)==true)
                        {
                            flog=1;
                        }
                        else
                        {
                            flog=0;
                        }

                        if(flog==0)
                        {
                            flag=0;
                        }
                    }
            if(flag==0)
            {

                $("#check").html("<font color='red'>请正确填入考试成绩！</font>");
               // alert('请正确填入考试成绩！');
            }
            else{

                var str="";
                for(var i=0;i<val.length;i++)
                {
                    str+=","+val[i].value;
                }
                var ne=str.substr(1);
                var name= $(".name");

                var st="";
                for(var j=0;j<name.length;j++)
                {
                    st+=","+name[j].value;
                }

                var user=st.substr(1);

                // alert(ne);
                var grup=$("#group").val();
                var cla_idd=$("#cla_id").val();
                $.ajax({
                    type: "POST",
                    url: "{{url('grade/addgrad')}}",
                    data: "day="+now_day+'&user='+user+"&grad="+ne+"&group="+grup+"&cla_id="+cla_idd,
                    success: function(msg){
                       // alert(msg);
                        if(msg=='1')
                        {
                            $("#check").html("");

                            window.location.href=localhostPaht+projectName+"/public/grade/look";
                        }
                        else
                        {
                            $("#check").html("<font color='red'>考试时间录入有误！</font>");
                        }
                    }
                });
            }
         });

        //获取下拉框的值
        $("#select1").change(function(){
            var new_val=$(this).val();
            var cla_idd=$("#cla_id").val();
            var grup=$("#group").val();
            $.ajax({
                type: "POST",
                url: "{{url('grade/upgrade')}}",
                data: "new_val="+new_val+'&cla_id='+cla_idd+'&group='+grup,
                success: function(msg){
                   // alert(msg);
                    if(msg!='1')
                    {
                        $(".classlist").html(msg);
                    }
                    else
                    {
                      // $(".select2").val("e");
                        $(".select2").find("option[text='正常']").attr("selected",true);
                        $(".select2").find("option[text='正常']").val("e");
                        $(".grade").val("");
                    }
                }
            });
        });

        function showMsg(obj,id) {
            var opt = obj.options[obj.selectedIndex];


            $("input[name='"+id+"']").val(opt.text);

            $("input[name='"+id+"']").text(opt.value);
            if(opt.text=="正常")
            {
                $("input[name='"+id+"']").val("");
            }
            //alert("The option you select is:"+opt.text+"("+opt.value+")");


        }
    </script>
</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">录入成绩</a></li>
        <li><a href="#">本次录入{{$data[0]['stu_group']}}组成绩</a></li>
        <input type="hidden"  id='group' value="{{$data[0]['stu_group']}}"/>
        <input type="hidden"  id='cla_id' value="{{$data[0]['cla_id']}}"/>
    </ul>
</div>
<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <li class="click"><span><img src="{{URL::asset('')}}images/t01.png" /></span>保存</li>
            {{--<li><span><img src="{{URL::asset('')}}images/t03.png" /></span>删除</li>--}}
            {{--<li><span><img src="{{URL::asset('')}}images/t04.png" /></span>统计</li>--}}
            {{--<li onclick="datasell()"><span><img src="{{URL::asset('')}}images/save.bmp"  style="height: 25px;width: 25px;" /></span>保存</li>--}}
        </ul>
        <span id="check"></span>
        <div style="float: right">
        <h3>考试时间</h3>
        <select name="" id="select1" style="width: 80px;height: 30px;border: dashed 1px #000000">
           <?php $num=1;?>
            @foreach($date as $vv)
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
    </div>
    </div>
    <style>
        .grade{width: 80px;height: 30px;border: dashed 1px #000000;}
    </style>
    <ul class="classlist">
        @foreach($data as $v)
        <li>
            <span></span>
            <div class="lright">
                <h2>姓名：{{$v['stu_name']}}</h2>
                <p>学号：{{$v['stu_care']}}</p>
               组员状态： <select name="" class="select2" onchange="showMsg(this,{{$v['stu_id']}})" style="width: 50px;height: 20px;border: solid  1px #000000;margin-top: 8px;">
                    <option value="e" selected ="selected">正常</option>
                    <option value="d">监考</option>
                    <option value="a">请假</option>
                    <option value="c">休学</option>
                    <option value="b">作弊</option>
                </select>
                <input type="hidden" class="name" value="{{$v['stu_id']}}"/>
                <div style="margin-top: 8px;">
                <p>理论：<input type="text" name="{{$v['stu_id']}}" class="grade"  />分</p><br>
                <p>机试：<input type="text"  name="{{$v['stu_id']}}" class="grade" />分</p>
            </div>
            </div>
        </li>
            @endforeach
       </ul>
    <div class="clear"></div>
    <div class="pagin">
        <div class="message">共<i class="blue">{{$num1}}</i>个组员</div>
    </div>
    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>
        <div class="tipinfo">
            <span><img src="{{URL::asset('')}}images/ticon.png" /></span>
            <div class="tipright">
                <p>是否确认对信息的修改 ？</p>
                <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
            </div>
        </div>
        <div class="tipbtn">
            <input name="" type="button"  class="sure" value="确定" />&nbsp;
            <input name="" type="button"  class="cancel" value="取消" />
        </div>
    </div>
</div>
</body>
</html>
