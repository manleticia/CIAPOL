<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Plateforme CIAPOL">
    <meta name="keyword" content="Plateforme de CIAPOL ">
    <link rel="icon" href="{{ asset('photos/logo.png') }}" type="image/x-icon"> <!-- Favicon-->
    <title>{{ $title }}</title>
    @stack('css')
</head>

<body class="layout-1" data-luno="theme-blue">
    @include('partials.dashboard_partials.sidebar')
    <div class="wrapper">
        @include('partials.dashboard_partials.header')
        <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        @include('partials.dashboard_partials.footer')
    </div>
    @stack('js')
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/bundle/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/bundle/apexcharts.bundle.js') }}"></script>
    <script>
        // Apex-wc-1
        var apexwc1 = {
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true
                },
            },
            series: [{
                data: [47, 45, 54, 38, 56, 24, 65, 31]
            }],
            stroke: {
                width: 1
            },
            fill: {
                type: "gradient",
                gradient: {
                    gradientToColors: ['var(--chart-color1)'],
                    shadeIntensity: 2,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 100]
                },
            },
            colors: ['var(--chart-color1)'],
        }
        new ApexCharts(document.querySelector("#apex-wc-1"), apexwc1).render();
        // Apex-wc-2
        var apexwc2 = {
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true
                },
            },
            series: [{
                data: [47, 45, 54, 38, 56, 24, 65, 31]
            }],
            stroke: {
                width: 1
            },
            fill: {
                type: "gradient",
                gradient: {
                    gradientToColors: ['var(--chart-color2)'],
                    shadeIntensity: 2,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 100]
                },
            },
            colors: ['var(--chart-color2)'],
        }
        new ApexCharts(document.querySelector("#apex-wc-2"), apexwc2).render();
        // Apex-wc-3
        var apexwc3 = {
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true
                },
            },
            series: [{
                data: [47, 45, 54, 38, 56, 24, 65, 31]
            }],
            stroke: {
                width: 1
            },
            fill: {
                type: "gradient",
                gradient: {
                    gradientToColors: ['var(--chart-color3)'],
                    shadeIntensity: 2,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 100]
                },
            },
            colors: ['var(--chart-color3)'],
        }
        new ApexCharts(document.querySelector("#apex-wc-3"), apexwc3).render();
        // Apex-wc-4
        var apexwc4 = {
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true
                },
            },
            series: [{
                data: [47, 56, 24, 65, 31, 45, 54, 38]
            }],
            stroke: {
                width: 1
            },
            fill: {
                type: "gradient",
                gradient: {
                    gradientToColors: ['var(--chart-color4)'],
                    shadeIntensity: 2,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 100]
                },
            },
            colors: ['var(--chart-color4)'],
        }
        new ApexCharts(document.querySelector("#apex-wc-4"), apexwc4).render();
        // Apex-wc-5
        var apexwc5 = {
            chart: {
                type: 'line',
                width: 160,
                height: 35,
                sparkline: {
                    enabled: true
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                }
            },
            stroke: {
                width: 3,
                curve: 'smooth',
                colors: ['var(--chart-color1)']
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ["var(--chart-color2)"],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 100],
                    colorStops: []
                },
            },
            series: [{
                data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
            }],
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                },
                marker: {
                    show: false,
                }
            }
        }
        new ApexCharts(document.querySelector("#apex-wc-5"), apexwc5).render();
        // Apex-wc-6
        var apexwc6 = {
            chart: {
                type: 'line',
                width: 160,
                height: 35,
                sparkline: {
                    enabled: true
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            stroke: {
                width: 3,
                curve: 'smooth',
                colors: ['var(--chart-color2)']
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ["var(--chart-color3)"],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 100],
                    colorStops: []
                },
            },
            series: [{
                data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
            }],
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                },
                marker: {
                    show: false,
                }
            }
        }
        new ApexCharts(document.querySelector("#apex-wc-6"), apexwc6).render();
        // Apex-wc-7
        var apexwc7 = {
            chart: {
                type: 'line',
                width: 160,
                height: 35,
                sparkline: {
                    enabled: true
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            stroke: {
                width: 3,
                curve: 'smooth',
                colors: ['var(--chart-color3)']
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ["var(--chart-color4)"],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 100],
                    colorStops: []
                },
            },
            series: [{
                data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
            }],
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                },
                marker: {
                    show: false,
                }
            }
        }
        new ApexCharts(document.querySelector("#apex-wc-7"), apexwc7).render();
        // Apex-wc-8
        var apexwc8 = {
            chart: {
                type: 'line',
                width: 160,
                height: 35,
                sparkline: {
                    enabled: true
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            stroke: {
                width: 3,
                curve: 'smooth',
                colors: ['var(--chart-color1)']
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ["var(--chart-color2)"],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 100],
                    colorStops: []
                },
            },
            series: [{
                data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
            }],
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                },
                marker: {
                    show: false,
                }
            }
        }
        new ApexCharts(document.querySelector("#apex-wc-8"), apexwc8).render();
        // Analytics
        var analytics = {
            series: [{
                name: 'Users',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }, {
                name: 'Sessions',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }, {
                name: 'Bounce Rate',
                data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
            }],
            colors: ['var(--chart-color1)', 'var(--chart-color2)', 'var(--chart-color3)'],
            chart: {
                type: 'bar',
                height: 280,
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    //endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            legend: {
                position: 'bottom', // left, right, top, bottom
                horizontalAlign: 'left', // left, right, top, bottom
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val + " thousands"
                    }
                }
            },
        };
        new ApexCharts(document.querySelector("#analytics"), analytics).render();
        // Sales
        var sales = {
            series: [{
                name: 'Ordered',
                data: [44, 55, 41, 67, 22, 43, 21, 49, 33, 29, 44, 38]
            }, {
                name: 'On Call',
                data: [13, 23, 20, 8, 13, 27, 21, 49, 33, 29, 33, 12]
            }, {
                name: 'Pending',
                data: [11, 17, 21, 49, 33, 29, 15, 15, 21, 14, 15, 13]
            }],
            chart: {
                type: 'bar',
                height: 280,
                stacked: true,
                stackType: '100%',
                toolbar: {
                    show: false,
                },
            },
            colors: ['var(--chart-color4)', 'var(--chart-color5)', 'var(--chart-color1)'],
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetX: -10,
                        offsetY: 0
                    }
                }
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'March', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            },
            fill: {
                opacity: 1
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
            },
        };
        new ApexCharts(document.querySelector("#sales"), sales).render();
        // Revenue Sales
        var revenue_sales = {
            series: [{
                name: "Revenue",
                data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
            }, {
                name: 'Sales',
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
            }],
            chart: {
                height: 280,
                type: 'line', // line, bar, area
                toolbar: {
                    show: false,
                },
                zoom: {
                    enabled: false
                },
            },
            colors: ['var(--chart-color1)', 'var(--chart-color3)'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [5, 7],
                curve: 'smooth', // straight, smooth
                dashArray: [8, 5]
            },
            legend: {
                tooltipHoverFormatter: function(val, opts) {
                    return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                }
            },
            markers: {
                size: 0,
                hover: {
                    sizeOffset: 6
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'March', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            },
            tooltip: {
                y: [{
                    title: {
                        formatter: function(val) {
                            return val + " (Hours)"
                        }
                    }
                }, {
                    title: {
                        formatter: function(val) {
                            return val + " (Hours)"
                        }
                    }
                }, {
                    title: {
                        formatter: function(val) {
                            return val + " (Session)"
                        }
                    }
                }]
            },
        };
        new ApexCharts(document.querySelector("#revenue_sales"), revenue_sales).render();
    </script>
</body>

</html>
