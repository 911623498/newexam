<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="{{URL::asset('')}}css/lyz.calendar.css" rel="stylesheet" type="text/css" />

    <link href="{{URL::asset('')}}css/style.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('')}}css/select.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}js/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}js/select-ui.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('')}}editor/kindeditor.js"></script>

    <script src="{{URL::asset('')}}js/lyz.calendar.min.js" type="text/javascript"></script>
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
        <li><a href="#">考试周期列表</a></li>
    </ul>
</div>

<div class="formbody">

        <div id="tab2" class="tabson">
            <form action="{{URL('exam/exam_status')}}" method="post">
                <table class="tablelist">
                    <thead>
                    <tr>
                        <th>编号<i class="sort"><img src="{{URL::asset('')}}images/px.gif" /></i></th>
                        <th>日期</th>
                        <th>星期</th>
                        <th>考试类型</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $num=1;?>
                    <?php foreach($arr as $kk=>$vv){?>
                    <tr>
                        <td>第<?php echo $kk+1;?>天考试
                         </td>
                        <td><?php echo $vv['date_time'];?></td>
                        <td><?php echo $vv['date_xingqi'];?></td>
                        <td>
                            <?php
                               if($vv['date_status']==1)
                               {
                                    echo "日考";
                               }else if($vv['date_status']==2)
                               {
                                   echo "周考".$num++;
                               }else
                               {
                                   echo "月考";
                               }
                            ?>
                        </td>
                    </tr>
                    <input type="hidden" name="_token" value="<?php echo csrf_token();?>"/>
                    <?php }?>
                    </tbody>
                </table>
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
