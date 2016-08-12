<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Highcharts Example</title>

    <script type="text/javascript" src="{{URL::asset('')}}js/jquery-1.9.1.min.js"></script>
    <style type="text/css">
        ${demo.css}
    </style>
    <script type="text/javascript">
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '每日成才率'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [
                        <?php echo $a_ks;?>
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '成才率(%)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">考试{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">班级{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                    <?php echo $str?>
                ]
            });
        });
    </script>
</head>
<body>
<script src="{{URL::asset('')}}/js/highcharts.js"></script>
<script src="{{URL::asset('')}}/js/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<?php
if($role_id==7){
?>
<center><a href="{{URL("yield/yields")}}?cla_id={{$cla_id}}&role_id={{$role_id}}">查看</a></center>
<center><a href="{{URL("yield/index")}}?cla_id={{$cla_id}}&role_id={{$role_id}}">返回</a></center>
<?php
}
?>

</body>
</html>
