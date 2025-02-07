@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard {{ Auth::user()->role == 'admin' ? 'Administrator' : 'Penjualan' }}</h1>
            </div>

            <div class="section-body">
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
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik Transaksi</h4>
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
                                        <div class="detail-value" id="todaySales">Rp 0</div>
                                        <div class="detail-name">Penjualan Hari Ini</div>
                                        <span class="text-muted">
                                            <i class="fas fa-caret-up text-primary"></i>
                                            <span id="todayPercentage">0%</span>
                                        </span>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value" id="weekSales">Rp 0</div>
                                        <div class="detail-name">Penjualan Minggu Ini</div>
                                        <span class="text-muted">
                                            <i class="fas fa-caret-up text-primary"></i>
                                            <span id="weekPercentage">0%</span>
                                        </span>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value" id="monthSales">Rp 0</div>
                                        <div class="detail-name">Penjualan Bulan Ini</div>
                                        <span class="text-muted">
                                            <i class="fas fa-caret-up text-primary"></i>
                                            <span id="monthPercentage">0%</span>
                                        </span>
                                    </div>
                                    <div class="statistic-details-item">
                                        <div class="detail-value" id="yearSales">Rp 0</div>
                                        <div class="detail-name">Penjualan Tahun Ini</div>
                                        <span class="text-muted">
                                            <i class="fas fa-caret-up text-primary"></i>
                                            <span id="yearPercentage">0%</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Card produk terpopuler -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Produk Terpopuler per Kategori</h4>
                            </div>
                            <div class="card-body">
                                @forelse($popularCategories as $category)
                                    @if ($category->products->count() > 0)
                                        <div class="mb-4">
                                            <h5 class="badge bg-primary rounded-pill text-white">{{ $category->name }}</h5>
                                            <ul class="list-group">
                                                @foreach ($category->products as $product)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0">
                                                        {{ $product->name }}
                                                        {{-- <span class="badge bg-primary rounded-pill">
                                                            {{ $product->total_ordered ?? 0 }} Terjual
                                                        </span> --}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @empty
                                    <div class="alert alert-info">Tidak ada data produk terpopuler.</div>
                                @endforelse
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
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    {{-- chart js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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
                            label: 'Total Pendapatan',
                            data: data,
                            borderColor: '#6777ef',
                            tension: 0.4,
                            fill: true,
                            backgroundColor: 'rgba(103, 119, 239, 0.1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: (context) => formatRupiah(context.raw)
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: (value) => formatRupiah(value)
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading chart data:', error);
            }
        }

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
