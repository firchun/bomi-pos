@extends('layouts.app')

@section('title', 'Income Report (Resto)')

@push('style')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .summary-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .summary-box i {
            font-size: 24px;
            margin-bottom: 10px;
            display: block;
            color: #4e73df;
        }

        .summary-box h5 {
            margin: 5px 0;
            font-size: 16px;
            color: #6c757d;
        }

        .summary-box p {
            font-size: 22px;
            font-weight: bold;
            color: #343a40;
        }

        .chart-container {
            width: 100%;
            height: 300px;
        }

        .badge {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .section-footer {
            margin-top: 40px;
            font-size: 13px;
            color: #6c757d;
            text-align: right;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Finance</a></div>
                    <div class="breadcrumb-item">Income</div>
                </div>
            </div>

            <div class="section-body">

                {{-- Summary --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="summary-box">
                            <i class="fas fa-money-bill-wave"></i>
                            <h5>Hari Ini (Total)</h5>
                            <p>Rp 3.650.000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-box">
                            <i class="fas fa-user-tie"></i>
                            <h5>Kasir Aktif</h5>
                            <p>2</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-box">
                            <i class="fas fa-receipt"></i>
                            <h5>Total Transaksi</h5>
                            <p>5</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                            data-target="#addIncomeModal">
                            <i class="fa fa-plus"></i> Add Income
                        </button>
                        <button type="button" class="btn btn-primary mb-3" id="btn-view"></i>View Summary</button>
                    </div>
                </div>
                {{-- Charts --}}
                <div class="row" id="charts">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Metode Pembayaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="paymentMethodChart" height="50px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Status Pembayaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="paymentStatusChart" height="50px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- Monthly Income Bar Chart --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Pendapatan Bulanan</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="monthlyIncomeChart" height="50px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Table --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Transaksi Pendapatan</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Kasir</th>
                                    <th>Subtotal</th>
                                    <th>Pajak</th>
                                    <th>Total</th>
                                    <th>Pembayaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Audit Footer --}}
            </div>
            <div class="section-footer">
                <p><strong>Audit Log:</strong> Generated on {{ now()->format('d M Y, H:i') }} | Auditor: <em>System
                        Administrator</em></p>
            </div>
        </section>
    </div>
    {{-- modal --}}
    <!-- Add Income Modal -->
    <div class="modal fade" id="addIncomeModal" tabindex="-1" role="dialog" aria-labelledby="addIncomeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addIncomeModalLabel">Add New Income</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount">Amount (Rp)</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories->where('type', 'income') as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description (optional)</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ now()->toDateString() }}"
                                required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Income</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const summaryIncome = document.getElementById('charts');
            const toggleButton = document.getElementById('btn-view');

            // Set awal: sembunyikan summary dan filter
            summaryIncome.style.display = 'none';

            toggleButton.addEventListener('click', function() {
                const isHidden = summaryIncome.style.display === 'none';

                summaryIncome.style.display = isHidden ? 'block' : 'none';

                toggleButton.innerHTML = isHidden ? '<i class="fa fa-eye-slash"></i> Hide Summary' :
                    '<i class="fa fa-eye"></i> View Summary';
            });
        });
    </script>
    <script>
        // Grafik Metode Pembayaran
        const ctxPayment = document.getElementById('paymentMethodChart').getContext('2d');
        new Chart(ctxPayment, {
            type: 'doughnut',
            data: {
                labels: ['QRIS', 'Cash', 'Card'],
                datasets: [{
                    label: 'Metode Pembayaran',
                    data: [2, 2, 1],
                    backgroundColor: ['#36b9cc', '#f6c23e', '#4e73df'],
                    hoverOffset: 6
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const total = [1550000, 1200000, 1500000];
                                return ctx.label + ': Rp ' + total[ctx.dataIndex].toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Grafik Status Pembayaran
        const ctxStatus = document.getElementById('paymentStatusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Paid', 'Pending', 'Void'],
                datasets: [{
                    label: 'Status Pembayaran',
                    data: [3, 1, 1],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    hoverOffset: 6
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const labels = ['Paid', 'Pending', 'Void'];
                                const total = [3050000, 950000, 250000];
                                return labels[ctx.dataIndex] + ': Rp ' + total[ctx.dataIndex].toLocaleString(
                                    'id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Grafik Pendapatan Bulanan
        const ctxMonthly = document.getElementById('monthlyIncomeChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Total Pendapatan',
                    data: [4500000, 5200000, 6100000, 7000000, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: '#4e73df',
                    borderRadius: 6
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return 'Rp ' + ctx.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
