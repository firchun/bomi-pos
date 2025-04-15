@extends('layouts.app')

@section('title', 'Dashboard')


@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/flag-icon-css/css/flag-icon.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-stats">
                            <div class="card-stats-title">Order Statistics -
                                <div class="dropdown d-inline">
                                    <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#"
                                        id="orders-month" aria-expanded="false">August</a>
                                    <ul class="dropdown-menu dropdown-menu-sm" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 18px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <li class="dropdown-title">Select Month</li>
                                        <li><a href="#" class="dropdown-item">January</a></li>
                                        <li><a href="#" class="dropdown-item">February</a></li>
                                        <li><a href="#" class="dropdown-item">March</a></li>
                                        <li><a href="#" class="dropdown-item">April</a></li>
                                        <li><a href="#" class="dropdown-item">May</a></li>
                                        <li><a href="#" class="dropdown-item">June</a></li>
                                        <li><a href="#" class="dropdown-item">July</a></li>
                                        <li><a href="#" class="dropdown-item active">August</a></li>
                                        <li><a href="#" class="dropdown-item">September</a></li>
                                        <li><a href="#" class="dropdown-item">October</a></li>
                                        <li><a href="#" class="dropdown-item">November</a></li>
                                        <li><a href="#" class="dropdown-item">December</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-stats-items">
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count-pending">0</div>
                                    <div class="card-stats-item-label">Pending</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count-shipping">0</div>
                                    <div class="card-stats-item-label">Shipping</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count-completed">0</div>
                                    <div class="card-stats-item-label">Completed</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-archive"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Orders</h4>
                            </div>
                            <div class="card-body">
                                59
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <div class="chartjs-size-monitor"
                                style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            <canvas id="balance-chart" height="132" width="562" class="chartjs-render-monitor"
                                style="display: block; height: 66px; width: 281px;"></canvas>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-rupiah-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Balance</h4>
                            </div>
                            <div class="card-body">
                                $187,13
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <div class="chartjs-size-monitor"
                                style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            <canvas id="sales-chart" height="132" width="562" class="chartjs-render-monitor"
                                style="display: block; height: 66px; width: 281px;"></canvas>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Sales</h4>
                            </div>
                            <div class="card-body">
                                4,732
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @if (Auth::user()->role == 'admin')
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4> Admin</h4>
                                </div>
                                <div class="card-body">
                                    {{ $admin }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>User</h4>
                                </div>
                                <div class="card-body">
                                    {{ $user }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-sitemap"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Category</h4>
                                </div>
                                <div class="card-body">
                                    {{ $categories }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-folder-open"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Product</h4>
                            </div>
                            <div class="card-body">
                                {{ $product }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Transaction Statistics</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary" id="weekFilter">Minggu</a>
                                    <a href="#" class="btn" id="monthFilter">Bulan</a>
                                    <a href="#" class="btn" id="yearFilter">Tahun</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="Chart" style="min-height: 400px; width: 100%"></canvas>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <div class="detail-value text-primary" id="todaySales">Rp 0</div>
                                    <div class="detail-name">Today's Sales</div>
                                    <span class="text-muted">
                                        <i class="fas fa-caret-up text-primary"></i>
                                        <span id="todayPercentage">0%</span>
                                    </span>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value text-primary" id="weekSales">Rp 0</div>
                                    <div class="detail-name">Last 7 Days Sales</div>
                                    <span class="text-muted">
                                        <i class="fas fa-caret-up text-primary"></i>
                                        <span id="weekPercentage">0%</span>
                                    </span>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value text-primary" id="monthSales">Rp 0</div>
                                    <div class="detail-name">Last 31 Days Sales</div>
                                    <span class="text-muted">
                                        <i class="fas fa-caret-up text-primary"></i>
                                        <span id="monthPercentage">0%</span>
                                    </span>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value text-primary" id="yearSales">Rp 0</div>
                                    <div class="detail-name">Last 12 Months Sales</div>
                                    <span class="text-muted">
                                        <i class="fas fa-caret-up text-primary"></i>
                                        <span id="yearPercentage">0%</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card gradient-bottom">
                        <div class="card-header">
                            <h4>Top 5 Products</h4>

                        </div>
                        <div class="card-body" id="top-5-scroll" tabindex="2"
                            style="height: 315px; overflow: hidden; outline: currentcolor;">
                            <ul class="list-unstyled list-unstyled-border">
                            </ul>
                        </div>
                        <div class="card-footer pt-3 d-flex justify-content-center">
                            <div class="budget-price justify-content-center">
                                <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
                                <div class="budget-price-label">Selling Price</div>
                            </div>
                            <div class="budget-price justify-content-center">
                                <div class="budget-price-square bg-danger" data-width="20" style="width: 20px;"></div>
                                <div class="budget-price-label">Budget Price</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="far fa-star"></i>
                            </div>
                            <h4>{{ App\Models\Rating::where('shop_profile_id', Auth::id())->count() }}</h4>
                            <div class="card-description">Customers reviews</div>
                        </div>
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                <a href="#" class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>My order hasn't arrived yet</h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div>Laila Tazkiah</div>
                                        <div class="bullet"></div>
                                        <div class="text-primary">1 min ago</div>
                                    </div>
                                </a>
                                <a href="#" class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>Please cancel my order</h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div>Rizal Fakhri</div>
                                        <div class="bullet"></div>
                                        <div>2 hours ago</div>
                                    </div>
                                </a>
                                <a href="#" class="ticket-item">
                                    <div class="ticket-title">
                                        <h4>Do you see my mother?</h4>
                                    </div>
                                    <div class="ticket-info">
                                        <div>Syahdan Ubaidillah</div>
                                        <div class="bullet"></div>
                                        <div>6 hours ago</div>
                                    </div>
                                </a>
                                <a href="features-tickets.html" class="ticket-item ticket-more">
                                    View All <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.js') }}"></script>
    <script src="{{ asset('library/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index.js') }}"></script>

    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/index-0.js') }}"></script> --}}
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    {{-- chart js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('dashboard.data') }}')
                .then(response => response.json())
                .then(data => {
                    // Order Stats
                    document.querySelector(".card-stats-item-count-pending").innerText = data.order
                        .pending;
                    document.querySelector(".card-stats-item-count-shipping").innerText = data.order
                        .shipping;
                    document.querySelector(".card-stats-item-count-completed").innerText = data.order
                        .completed;
                    document.querySelector(".card-body").innerText = data.order.total;

                    // Balance
                    document.querySelectorAll(".card-body")[1].innerText = 'Rp ' + data.balance;

                    // Sales
                    document.querySelectorAll(".card-body")[2].innerText = data.sales;

                    // Ratings
                    document.querySelector(".card-hero .card-header h4").innerText = data.ratings;

                    // Top Products (optional render ulang list)
                    let productList = '';
                    data.top_products.forEach(product => {
                        productList += `
                        <li class="media">
                            <img class="mr-3 rounded" width="55" height="55" src="${product.image} " alt="product">
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small">${product.orders_count} Sales</div>
                                </div>
                                <div class="media-title">${product.name}</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-primary" style="width: 35%;"></div>
                                        <div class="budget-price-label">Rp ${product.price}</div>
                                    </div>
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-danger" style="width: 28%;"></div>
                                        <div class="budget-price-label">Rp 0</div>
                                    </div>
                                </div>
                            </div>
                        </li>`;
                    });
                    document.querySelector("#top-5-scroll ul").innerHTML = productList;
                });
        });


        // Inisialisasi Chart
        const chartContext = document.getElementById('Chart').getContext('2d');
        let transactionChart;
        let lastFilter = 'week';

        // Format Rupiah
        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }

        // Update tombol filter
        const updateFilterButtons = (activeFilter) => {
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('btn-primary');
            });
            document.getElementById(`${activeFilter}Filter`).classList.add('btn-primary');
        }

        // Load data chart
        const loadChartData = async (filterType) => {
            lastFilter = filterType;
            try {
                const response = await fetch(`/dashboard/transaction-data?filter=${filterType}`);
                const {
                    labels,
                    data
                } = await response.json();

                if (transactionChart) transactionChart.destroy();

                transactionChart = new Chart(chartContext, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Income',
                            data: data,
                            borderWidth: 0,
                            backgroundColor: "#9900CC",
                            borderColor: "#9900CC",
                            pointBorderWidth: 0,
                            pointRadius: 2,
                            pointBackgroundColor: "#9900CC",
                            pointHoverBackgroundColor: "rgba(63,82,227,0.8)",
                            fill: true,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1500,
                                    callback: function(value) {
                                        return "Rp " + value;
                                    }
                                },
                                grid: {
                                    color: "#f2f2f2",
                                    drawBorder: false,
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    tickLength: 15,
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.formattedValue;
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading chart data:', error);
            }
        };

        // Load statistik penjualan
        const loadSalesStatistics = async () => {
            try {
                const response = await fetch('/dashboard/sales-statistics');
                const {
                    today,
                    week,
                    month,
                    year
                } = await response.json();

                document.getElementById('todaySales').textContent = formatRupiah(today);
                document.getElementById('weekSales').textContent = formatRupiah(week);
                document.getElementById('monthSales').textContent = formatRupiah(month);
                document.getElementById('yearSales').textContent = formatRupiah(year);
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        // Event listeners
        document.getElementById('weekFilter').addEventListener('click', (e) => {
            e.preventDefault();
            updateFilterButtons('week');
            loadChartData('week');
        });

        document.getElementById('monthFilter').addEventListener('click', (e) => {
            e.preventDefault();
            updateFilterButtons('month');
            loadChartData('month');
        });

        document.getElementById('yearFilter').addEventListener('click', (e) => {
            e.preventDefault();
            updateFilterButtons('year');
            loadChartData('year');
        });

        // Inisialisasi awal
        window.addEventListener('DOMContentLoaded', () => {
            loadChartData('week');
            loadSalesStatistics();
        });
    </script>
@endpush
