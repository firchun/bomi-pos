<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Transaction Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            font-size: 12px;
            color: black;
            background: white;
        }

        /* Hapus semua margin default */
        @page {
            margin: 20px;
        }

        /* Styling tabel */
        #report-table thead th {
            background-color: #9900CC;
            color: white;
            text-align: center;
        }

        #report-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #report-table tbody tr:hover {
            background-color: rgba(153, 0, 204, 0.2);
        }

        /* Styling untuk baris Total Cost Overall */
        #report-table tfoot tr.bg-primary {
            background-color: #660078 !important;
            color: white !important;
        }

        /* CSS untuk mode print */
        @media print {
            .btn-print {
                display: none !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

          
            /* Warna latar belakang dan teks saat print */
            #report-table thead th {
                background-color: #9900CC !important;
                color: white !important;
            }

            #report-table tbody tr:nth-child(even) {
                background-color: #f9f9f9 !important;
            }

            #report-table tbody tr:hover {
                background-color: rgba(153, 0, 204, 0.2) !important;
            }

            /* Warna untuk Total Cost Overall */
            #report-table tfoot tr.bg-primary {
                background-color: #660078 !important;
                color: white !important;
            }

            /* Tetap tampilkan warna latar belakang pada baris dan kolom */
            td,
            th {
                color: #333;
                background-color: white;
            }

            .bg-primary {
                background-color: #660078 !important;
                color: white !important;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container mt-3">
        <div class="text-center mb-4">
            <h2>Transaction Report</h2>
        </div>

        <!-- Informasi Toko -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h4>Informasi Toko</h4>
                <table class="table table-borderless table-sm" style="border: none !important;">
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
                <table class="table  table-sm  table-borderless" style="border: none !important;">
                    <tr>
                        <th>No. Invoice</th>
                        <td>{{ $order->no_invoice }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Date</th>
                        <td>{{ \Carbon\Carbon::parse($order->transaction_time)->format('d/m/Y H:i') }}</td>
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
            <table class="table table-bordered table-sm table-hover" id="report-table">
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
                            <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-right">
                                Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total Product Price</th>
                        <th class="text-right">Rp{{ number_format($totalProduk, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Discount</th>
                        <th class="text-right">- Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Tax</th>
                        <th class="text-right">+ Rp{{ number_format($order->tax, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Service Charge</th>
                        <th class="text-right">+ Rp{{ number_format($order->service_charge, 0, ',', '.') }}</th>
                    </tr>
                    <tr class="bg-primary text-white">
                        <th colspan="4" class="text-right">Total Cost Overall</th>
                        <th class="text-right">Rp{{ number_format($totalFinal, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</body>

</html>
