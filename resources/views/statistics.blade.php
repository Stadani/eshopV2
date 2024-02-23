<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>PixelNexus | Form</title>

    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/statStyle.css">
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
    <div class="containerGeneral" style="flex-direction: column">
        <h2>Sale overtime</h2>
        <canvas id="monthlySalesChart" width="400" height="200"></canvas>

        <script>
            var ctx = document.getElementById('monthlySalesChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthlyLabels) !!},
                    datasets: [{
                        label: 'Total Sales',
                        data: {!! json_encode($monthlyTotalSales) !!},
                        backgroundColor: 'rgba(54, 162, 235, 1)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
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
                    }
                }
            });
        </script>
    </div>
    <div class="containerGeneral" style="flex-direction: column">
        <h2>Most sold games</h2>
        <canvas id="salesChart" height="100" style="max-height: 350px"></canvas>

        <script>
            var chartColors = ['#FF5733', '#FFC300', '#36A2EB', '#4BC0C0', '#9966FF'];
            var ctx = document.getElementById('salesChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($gameLabels) !!},
                    datasets: [{
                        label: 'Total Sales',
                        data: {!! json_encode($gameData) !!},
                        backgroundColor: chartColors,
                        borderColor: 'rgba(255, 255, 255, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    </div>

    <div class="containerGeneral" style="flex-direction: column">
        <h2>Game sales per platform</h2>
        <canvas id="salesChartPlatform" width="200" height="50"></canvas>

        <script>
            var ctx = document.getElementById('salesChartPlatform').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($platformLabels) !!},
                    datasets: [{
                        label: 'Total Sales',
                        data: {!! json_encode($platformData) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
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
                    }
                }
            });
        </script>
    </div>
<div class="containerGeneral twoPies">
    <canvas id="mostSoldGenresChart" style="max-height: 400px; max-width: 400px"></canvas>

    <script>
        var chartColors = ['#FF5733', '#FFC300', '#36A2EB', '#4BC0C0', '#9966FF'];
        var ctx = document.getElementById('mostSoldGenresChart').getContext('2d');
        var genreLabels = {!! json_encode($mostSoldGenres->pluck('category')) !!};
        var totalSalesData = {!! json_encode($mostSoldGenres->pluck('total_sales')) !!};

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: genreLabels,
                datasets: [{
                    label: 'Total Sales',
                    data: totalSalesData,
                    backgroundColor: chartColors,
                    borderColor: 'white',
                    borderWidth: 1
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
                        text: 'Most Sold Genres',
                        color: 'white',
                        font: {
                            size: 16
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

    <canvas id="leastSoldGenresChart" style="max-height: 400px; max-width: 400px"></canvas>

    <script>
        var chartColors = ['#FF5733', '#FFC300', '#36A2EB', '#4BC0C0', '#9966FF'];
        var ctx = document.getElementById('leastSoldGenresChart').getContext('2d');
        var genreLabels = {!! json_encode($leastSoldGenres->pluck('category')) !!};
        var totalSalesData = {!! json_encode($leastSoldGenres->pluck('total_sales')) !!};

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: genreLabels,
                datasets: [{
                    label: 'Total Sales',
                    data: totalSalesData,
                    backgroundColor: chartColors,
                    borderColor: 'white',
                    borderWidth: 1
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
                        text: 'Least Sold Genres',
                        color: 'white',
                        font: {
                            size: 16
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
