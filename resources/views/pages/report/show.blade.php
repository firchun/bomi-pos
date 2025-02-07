@extends('layouts.app')

@section('title', 'Report')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        .shop-info,
        .transaction-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .03);
        }

        .thead-dark th {
            background-color: #343a40;
            border-color: #454d55;
        }

        /* Header tabel */
        #report-table thead th {
            background-color: #9900CC !important;
            /* Warna ungu */
            color: white !important;
            text-align: center;
            padding: 10px;
        }

        /* Warna latar belakang untuk baris genap */
        #report-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Efek hover pada baris tabel */
        #report-table tbody tr:hover {
            background-color: rgba(153, 0, 204, 0.2);
            transition: background-color 0.3s ease;
        }

        /* Penyesuaian padding & border */
        #report-table th,
        #report-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        /* Border untuk keseluruhan tabel */
        #report-table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Styling untuk baris Total Cost Overall */
        #report-table tfoot tr.bg-primary {
            background-color: #660078 !important;
            color: white !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Report</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Report</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('daily.report') }}" class="btn btn-secondary btn-sm float-right">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <a href="{{ route('report.printTransaction', $order->id) }}" class="btn btn-primary btn-sm ml-2" target="_blank">
                                    <i class="fas fa-print"></i> Print
                                </a>                                
                            </div>
                            <div class="card-body">
                                <!-- Bagian Info Toko -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h4>Informasi Toko</h4>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th>Shop Name</th>
                                                <td>{{ $shop->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ $shop->address ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Operating Hours</th>
                                                <td>{{ $shop->open_time ?? '-' }} - {{ $shop->close_time ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Transaction Information</h4>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th>No. Invoice</th>
                                                <td>{{ $order->no_invoice }}</td>
                                            </tr>
                                            <tr>
                                                <th>Transaction Date</th>
                                                <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('d/m/Y H:i') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Cashier</th>
                                                <td>{{ $order->nama_kasir }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tabel Produk -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="report-table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Product Name</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Unit Price</th>
                                                <th class="text-right">Total Product</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderItems as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-right">
                                                        Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="">
                                            <tr>
                                                <th colspan="4" class="text-right">Total Product Price</th>
                                                <th class="text-right">Rp{{ number_format($totalProduk, 0, ',', '.') }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">Discount</th>
                                                <th class="text-right">-
                                                    Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">Tax</th>
                                                <th class="text-right">+ Rp{{ number_format($order->tax, 0, ',', '.') }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">Service Charge</th>
                                                <th class="text-right">+
                                                    Rp{{ number_format($order->service_charge, 0, ',', '.') }}</th>
                                            </tr>
                                            <tr class="bg-primary text-white">
                                                <th colspan="4" class="text-right">Total Cost Overall</th>
                                                <th class="text-right">Rp{{ number_format($totalFinal, 0, ',', '.') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
