<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>PixelNexus | Form</title>

    @extends('components/layout')
    @section('listcss')
    @endsection
    {{--    had to link like this because after opening post it doesnt work--}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
    {{--    https://github.com/habibmhamadi/multi-select-tag--}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.0/dist/js/multi-select-tag.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>
<body>
@extends('components.navbar')
@section('content')
    <div class="containerGeneral">
        <canvas id="monthlySalesChart" width="400" height="200"></canvas>

        <script>
            var chartColors = ['#FF5733', '#FFC300', '#36A2EB', '#4BC0C0', '#9966FF'];
            var ctx = document.getElementById('monthlySalesChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyLabels) !!},
                    datasets: [{
                        label: 'Total Sales',
                        data: {!! json_encode($monthlyTotalSales) !!},
                        backgroundColor: chartColors,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of sold games per month (2024)',
                            color: 'white',
                            font: {
                                size: 20
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255,255,255, 0.5)'
                            }
                        },
                        y: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255,255,255, 0.5)'
                            }
                        }
                    },

                }
            });
        </script>
    </div>

    <div class="containerGeneral">
        <canvas id="salesChartPlatform" height="700" width="100" ></canvas>

        <script>
            var chartColors = ['#FF5733', '#FFC300', '#36A2EB', '#4BC0C0', '#9966FF'];
            var ctx = document.getElementById('salesChartPlatform').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($platformLabels) !!},
                    datasets: [{
                        label: 'Total Sales',
                        data: {!! json_encode($platformData) !!},
                        backgroundColor: chartColors,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of sold games by platform',
                            color: 'white',
                            font: {
                                size: 20
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255,255,255, 0.5)'
                            }
                        },
                        y: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255,255,255, 0.5)'
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    </div>
<div class="containerGeneral">
    <canvas id="mostSoldGenresChart" height="700" width="100"></canvas>

    <script>
        var chartColors = ['#FF5733', '#FFC300', '#36A2EB', '#4BC0C0', '#9966FF'];
        var ctx = document.getElementById('mostSoldGenresChart').getContext('2d');
        var genreLabels = {!! json_encode($mostSoldGenres->pluck('category')) !!};
        var totalSalesData = {!! json_encode($mostSoldGenres->pluck('total_sales')) !!};

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: genreLabels,
                datasets: [{
                    label: 'Total Sales',
                    data: totalSalesData,
                    backgroundColor: chartColors,
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Number of sold games by genre',
                        color: 'white',
                        font: {
                            size: 20
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255,255,255, 0.5)'
                        }
                    },
                    y: {
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255,255,255, 0.5)'
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</div>

    <x-footer>

    </x-footer>
@endsection
</body>
