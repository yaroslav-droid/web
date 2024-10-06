<!DOCTYPE html>
<html lang="en">
<head>
    <?php error_log(" \r\n", 3, 'data/layer7-logs'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rapidreset dstat</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.2/highcharts.js"
        integrity="sha512-PpL09bLaSaj5IzGNx6hsnjiIeLm9bL7Q9BB4pkhEvQSbmI0og5Sr/s7Ns/Ax4/jDrggGLdHfa9IbsvpnmoZYFA=="
        crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        :root {
            --primary-color: #8b5cf6;
            --background-color: #0f0f1e;
            --text-color: #ffffff;
            --accent-color: #8b5cf6;
        }
        
        body, html {
            height: 100%;
            width: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--background-color);
            font-family: 'Poppins', sans-serif;
        }
        
        .chart-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: rgba(30, 30, 46, 0.8);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <div id="simpleChart"></div>
    </div>

<script>
    $(document).ready(function () {
        setTimeout(function() {
            Highcharts.setOptions({
                chart: {
                    backgroundColor: 'transparent',
                    style: {
                        fontFamily: '\'Poppins\', sans-serif'
                    }
                },
                title: {
                    style: {
                        color: '#ffffff',
                        fontSize: '16px'
                    }
                },
                xAxis: {
                    gridLineColor: '#333333',
                    labels: {
                        style: {
                            color: '#e0e0e0'
                        }
                    },
                    lineColor: '#333333',
                    tickColor: '#333333'
                },
                yAxis: {
                    gridLineColor: '#333333',
                    labels: {
                        style: {
                            color: '#e0e0e0'
                        }
                    },
                    title: {
                        style: {
                            color: '#e0e0e0'
                        }
                    }
                },
                legend: {
                    itemStyle: {
                        color: '#e0e0e0'
                    },
                    itemHoverStyle: {
                        color: '#ffffff'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.85)',
                    style: {
                        color: '#f0f0f0'
                    }
                }
            });

            let simpleChart = Highcharts.chart('simpleChart', {
                chart: {
                    type: 'areaspline',
                    backgroundColor: 'transparent',
                    events: {
                        load: requestData(),
                    }
                },
                title: {
                    text: '',
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150,
                    labels: {
                        style: {
                            color: '#ffffff'
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: '',
                    },
                    labels: {
                        style: {
                            color: '#ffffff'
                        }
                    },
                    gridLineColor: '#333'
                },
                series: [{
                    name: "Requests/s",
                    data: [],
                    color: '#8b5cf6',
                    fillOpacity: 0.2,
                    marker: {
                        enabled: false
                    }
                }],
                plotOptions: {
                    areaspline: {
                        fillOpacity: 0.5
                    }
                },
                credits: {
                    enabled: false
                },
                legend: {
                    enabled: false
                }
            });

            function requestData() {
                $.ajax({
                    url: "data/layer7.php",
                    success: function (point) {
                        var series = simpleChart.series[0],
                            shift = series.data.length > 20; 
                        series.addPoint(point, true, shift);
                        setTimeout(requestData, 1000);
                    },
                    cache: false
                });
            }
        }, 2000); 
    });
</script>

</body>
</html>
