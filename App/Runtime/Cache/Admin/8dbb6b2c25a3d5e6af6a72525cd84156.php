<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title></title>


    <link rel="shortcut icon" href="/duomi/Public/favicon.ico">
    <link href="/duomi/Public/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/duomi/Public/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="/duomi/Public/css/animate.css" rel="stylesheet">
    <link href="/duomi/Public/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>推广商数据分析</h2>
        <ol class="breadcrumb">
            <li>
                <a href=""></a>
            </li>
            <li>
                <strong>投资额数据</strong>
            </li>
            <li><?php echo ($noResult); ?>
                <a class="btn-primary btn" href="">刷新</a>
            </li>

        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">

        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox-content">
        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-5">
                <div id="main" style="width: 800px;height:600px;"></div>
                <div id="line" style="width: 800px;height:600px;"></div>


            </div>
        </div>
    </div>
</div>


<!-- 全局js -->
<script src="/duomi/Public/js/jquery.min.js?v=2.1.4"></script>
<script src="/duomi/Public/js/bootstrap.min.js?v=3.3.6"></script>


<script type="text/javascript" src="/duomi/Public/uploadify/jquery.uploadify.min.js"></script>

<!-- 自定义js -->
<script src="/duomi/Public/js/content.js?v=1.0.0"></script>
<script src="/duomi/Public/js/echarts.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    var option = {
        backgroundColor: '#2c343c',

        title: {
            text: '投资总额饼状图',
            left: 'center',
            top: 20,
            textStyle: {
                color: '#ccc'
            }
        },

        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },

        visualMap: {
            show: false,
            min: 80,
            max: 600,
            inRange: {
                colorLightness: [0, 1]
            }
        },
        series : [
            {
                name:'投资总额',
                type:'pie',
                radius : '55%',
                center: ['50%', '50%'],
                data:[
                    {value:<?php echo ($investSumDianle); ?>, name:'点乐'},
                    {value:<?php echo ($investSumWanpu); ?>, name:'万普'},
                    {value:<?php echo ($investSumYoumi); ?>, name:'有米'}

                ].sort(function (a, b) { return a.value - b.value}),
                roseType: 'angle',
                label: {
                    normal: {
                        textStyle: {
                            color: 'rgba(255, 255, 255, 0.3)'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        lineStyle: {
                            color: 'rgba(255, 255, 255, 0.3)'
                        },
                        smooth: 0.2,
                        length: 10,
                        length2: 20
                    }
                },
                itemStyle: {
                    normal: {
                        color: '#c23531',
                        shadowBlur: 200,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

    // 基于准备好的dom，初始化echarts实例
    var lineChart = echarts.init(document.getElementById('line'));

    // 指定图表的配置项和数据
    var lineOption = {
        title: {
            text: '每日新增用户投资总额变化'
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['有米','点乐','万普']
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : [<?php echo ($date); ?>]
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'有米',
                type:'line',
                stack: '总额',
                areaStyle: {normal: {}},
                data:[<?php echo ($youmiData); ?>]
            },
            {
                name:'点乐',
                type:'line',
                stack: '总额',
                areaStyle: {normal: {}},
                data:[<?php echo ($dianleData); ?>]
            },
            {
                name:'万普',
                type:'line',
                stack: '总额',
                areaStyle: {normal: {}},
                data:[<?php echo ($wanpuData); ?>]
            }

        ]
    };


    // 使用刚指定的配置项和数据显示图表。
    lineChart.setOption(lineOption);
</script>


</body>

</html>