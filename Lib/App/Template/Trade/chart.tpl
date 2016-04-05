<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>订单汇总报表图形化</title>
    {webcontrol type='LoadJsCss' src="Resource/Script/chart/esl.js"}
    
    <script type="text/javascript">
    var json = {$json};
    {literal}
        // 路径配置
        require.config({
            paths:{ 
                'echarts' : 'Resource/Script/chart/echarts',
                'echarts/chart/bar' : 'Resource/Script/chart/echarts-map',
                'echarts/chart/line': 'Resource/Script/chart/echarts-map',
                'echarts/chart/map': 'Resource/Script/chart/echarts-map'
            }
        });

        require(
		    [
		        'echarts',
		        'echarts/chart/line',   // 按需加载所需图表
		        'echarts/chart/bar',
		        'echarts/chart/map'
		    ],
		    function (ec) {
		        var myChart = ec.init(document.getElementById('main')); 
                
                var option = {
				    title : {
				        text: '客户下单汇总统计图形化报表',
				        subtext: ''
				    },
				    tooltip : {
				        trigger: 'axis'
				    },
				    legend: {
				        data:['金额','数量(M)']
				    },
				    toolbox: {
				        show : true,
				        feature : {
				            // mark : {show: true},
				            // dataView : {show: true, readOnly: false},
				            // magicType : {show: true, type: ['line', 'bar']},
				            // restore : {show: true},
				            // saveAsImage : {show: true}
				        }
				    },
				    calculable : true,
				    xAxis : [
				        {
				            type : 'category',
				            data : json.client
				        }
				    ],
				    yAxis : [
				        {
				            type : 'value'
				        }
				    ],
				    series : [
				        {
				            name:'金额',
				            type:'bar',
				            data:json.money,
				            // markLine : {
				            //     data : [
				            //         {type : 'average', name : '平均值'}
				            //     ]
				            // }
				        },
				        {
				            name:'数量(M)',
				            type:'bar',
				            data:json.cntM,
				            // markLine : {
				            //     data : [
				            //         {type : 'average', name : '平均值'}
				            //     ]
				            // }
				        }
				    ]
				};
				        
                // 为echarts对象加载数据 
                myChart.setOption(option); 


                //饼状图
                var myChart2 = ec.init(document.getElementById('map_chart'));
                var option_map =  {
				    title : {
				        text: '客户下单汇总金额饼状图',
				        subtext: '',
				        x:'center'
				    },
				    tooltip : {
				        trigger: 'item',
				        formatter: "{a} <br/>{b} : {c} ({d}%)"
				    },
				    legend: {
				        orient : 'vertical',
				        x : 'left',
				        data:json.client
				    },
				    // toolbox: {
				    //     show : true,
				    //     feature : {
				    //         mark : {show: true},
				    //         dataView : {show: true, readOnly: false},
				    //         restore : {show: true},
				    //         saveAsImage : {show: true}
				    //     }
				    // },
				    calculable : true,
				    series : [
				        {
				            name:'客户名称',
				            type:'pie',
				            radius : '70%',
				            center: ['50%', '50%'],
				            data:json.pieData
				        }
				    ]
				};
                myChart2.setOption(option_map); 
		    }
		);
    </script>
    {/literal}
</head>
<body>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" style="height:500px"></div>

    <div id="map_chart" style="height:600px; position:relative"></div>
</body>