@extends('layouts.app')

@section('title', 'Expenses Report')

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
            color: #e74a3b;
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
                    <div class="breadcrumb-item">Expenses</div>
                </div>
            </div>

            <div class="section-body">
                {{-- Summary --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="summary-box">
                            <i class="fas fa-coins"></i>
                            <h5>Hari Ini (Total)</h5>
                            <p>Rp 1.250.000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-box">
                            <i class="fas fa-wallet"></i>
                            <h5>Jumlah Pengeluaran</h5>
                            <p>Rp 4.500.000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-box">
                            <i class="fas fa-clipboard-list"></i>
                            <h5>Jumlah Transaksi</h5>
                            <p>3</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                            data-target="#addExpenseModal">
                            <i class="fa fa-plus"></i> Add Expense
                        </button>
                        <button type="button" class="btn btn-primary mb-3" id="btn-view"></i>View Summary</button>
                    </div>
                </div>

                {{-- Charts --}}
                <div class="row" id="charts">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Metode Pengeluaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="methodChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kategori Pengeluaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        {{-- Monthly Chart --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Pengeluaran Bulanan</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="monthlyChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Table --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Pengeluaran</h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Metode</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>2025-04-07</td>
                                    <td>Bahan</td>
                                    <td>Beli Ayam & Sayur</td>
                                    <td>Cash</td>
                                    <td>Rp 1.250.000</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2025-04-06</td>
                                    <td>Operasional</td>
                                    <td>Listrik & Air</td>
                                    <td>Transfer</td>
                                    <td>Rp 1.500.000</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2025-04-05</td>
                                    <td>Gaji</td>
                                    <td>Bayar Staff Dapur</td>
                                    <td>Transfer</td>
                                    <td>Rp 1.750.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Audit --}}
                <div class="section-footer">
                    <p><strong>Audit Log:</strong> Generated on {{ now()->format('d M Y, H:i') }} | Auditor: <em>System
                            Administrator</em></p>
                </div>
            </div>
        </section>
    </div>
    {{-- modal --}}
    <!-- Add expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addIncomeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addIncomeModalLabel">Add New Expense</h5>
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
                                @foreach ($categories->where('type', 'expense') as $category)
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
        // Chart: Metode Pengeluaran
        new Chart(document.getElementById('methodChart'), {
            type: 'doughnut',
            data: {
                labels: ['Cash', 'Transfer'],
                datasets: [{
                    data: [1250000, 3250000],
                    backgroundColor: ['#f6c23e', '#4e73df']
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ctx.label + ': Rp ' + ctx.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Chart: Kategori Pengeluaran
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: ['Bahan', 'Operasional', 'Gaji'],
                datasets: [{
                    data: [1250000, 1500000, 1750000],
                    backgroundColor: ['#e74a3b', '#36b9cc', '#1cc88a']
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ctx.label + ': Rp ' + ctx.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Chart: Pengeluaran Bulanan
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pengeluaran',
                    data: [3000000, 4000000, 4500000, 5000000, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: '#e74a3b',
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
