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
                    text: "<?php echo $b_name?>"
                },
                subtitle: {
                    text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '13px',
                            fontFamily: '日考'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '成才率(%)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: ' <b>{point.y:.1f}</b>'
                },
                series: [{
                    name: 'Population',
                    data:  <?php echo $bs?>,
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        format: '{point.y:.1f}', // one decimal
                        y: 10, // 10 pixels down from the top
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            });
        });
    </script>
</head>
<body>
<script src="{{URL::asset('')}}js/highcharts.js"></script>
<script src="{{URL::asset('')}}js/exporting.js"></script>

<div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
</body>