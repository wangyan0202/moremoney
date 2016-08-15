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
                <strong>转化率数据</strong>
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
                <div id="main" style="width: 600px;height:400px;"></div>

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
        title: {
            text: '转化率漏斗图',
            subtext: '',
            left: 'left',
            top: 'bottom'
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}%"
        },
        toolbox: {
            orient: 'vertical',
            top: 'center',
            feature: {
                dataView: {readOnly: false},
                restore: {},
                saveAsImage: {}
            }
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['点击', '注册转化率', '投资转化率']
        },
        calculable: true,
        series: [

            /*{
             name: '有米转化率漏斗图',
             type:'funnel',
             width: '40%',
             height: '45%',
             left: '55%',
             top: '5%',
             label: {
             normal: {
             position: 'left'
             }
             },
             data:[
             {value: 100, name: '点击'},
             {value: <?php echo ($regPercentYoumi); ?>, name: '注册转化率'},
             {value:<?php echo ($investPercentYoumi); ?>, name: '投资转化率'}
             ]
             },
             {
             name: '万普转化率漏斗图',
             type:'funnel',
             width: '40%',
             height: '45%',
             left: '55%',
             top: '5%',
             label: {
             normal: {
             position: 'left'
             }
             },
             data:[
             {value: 100, name: '点击'},
             {value: <?php echo ($regPercentWanpu); ?>, name: '注册转化率'},
             {value:<?php echo ($investPercentWanpu); ?>, name: '投资转化率'}
             ]
             },
             {
             name: '点乐转化率漏斗图',
             type:'funnel',
             width: '40%',
             height: '45%',
             left: '55%',
             top: '5%',
             label: {
             normal: {
             position: 'left'
             }
             },
             data:[
             {value: 100, name: '点击'},
             {value: <?php echo ($regPercentDianle); ?>, name: '注册转化率'},
             {value:<?php echo ($investPercentDianle); ?>, name: '投资转化率'}
             ]
             }*/
            {
                name: '有米转化率漏斗图',
                type: 'funnel',
                width: '30%',
                height: '80%',
                left: '5%',
                top: '20%',
                data: [
                    {value: 100, name: '点击'},
                    {value: <?php echo ($regPercentYoumi); ?>, name: '有米注册转化率'},
                    {value: <?php echo ($investPercentYoumi); ?>, name: '有米投资转化率'}
                    ]
            },
            {
                name: '点乐转化率漏斗图',
                type: 'funnel',
                width: '30%',
                height: '80%',
                left: '35%',
                top: '20%',
                data: [
                    {value: 100, name: '点击'},
                    {value: <?php echo ($regPercentDianle); ?>, name: '点乐注册转化率'},
                    {value: <?php echo ($investPercentDianle); ?>, name: '点乐投资转化率'}
                ]
            },

            {
                name: '万普转化率漏斗图',
                type: 'funnel',
                width: '30%',
                height: '80%',
                left: '65%',
                top: '20%',
                data:[
                    {value: 100, name: '点击'},
                    {value: <?php echo ($regPercentWanpu); ?>, name: '万普注册转化率'},
                    {value:<?php echo ($investPercentWanpu); ?>, name: '万普投资转化率'}
                ]
            },


        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>


</body>

</html>