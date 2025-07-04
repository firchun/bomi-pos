@extends('layouts.app')

@section('title', 'Product Report')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    {{-- href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fa fa-chart-line"></i> @yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>
            <div class="my-2 p-2 border rounded bg-light text-dark">
                @if (app()->getLocale() == 'en')
                    Manage your product report easily, you can download the report in PDF or Excel format and filter the
                    report by date and product category.
                @else
                    Kelola laporan produk anda dengan mudah, anda dapat mengunduh laporan dalam format PDF atau Excel serta
                    filter laporan berdasarkan tanggal dan kategori produk.
                @endif
            </div>
            <div class="section-body">
                <div class="row mb-3 align-items-end justify-content-center mx-2 p-2 bg-white rounded shadow-sm">
                    <div class="col-md-4 mb-2">
                        <label for="from-date">Date Range</label>
                        <div class="input-group">
                            <button class="btn btn-sm btn-outline-success" id="today-btn">Today</button>
                            <button class="btn btn-sm btn-outline-success" id="week-btn">Week</button>
                            <input type="date" class="form-control datepicker" name="from-date" id="from-date"
                                value="{{ date('Y-m-d', strtotime('-7 day')) }}" placeholder="From Date">
                            <input type="date" class="form-control datepicker" name="to-date" id="to-date"
                                value="{{ date('Y-m-d') }}" placeholder="To Date">
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control select2">
                            <option value="">All Category</option>
                            @foreach (App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <button type="button" class="btn btn-primary w-100" id="filter-button">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="report-table" class="table  table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Orders</th>
                                                <th>Total</th>
                                                <th>Profit</th>

                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr class="bg-light">
                                                <th colspan="4" class="text-right">TOTAL : </th>
                                                <th id="total">Total</th>
                                                <th id="profit">Profit</th>
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
    {{-- <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script> --}}

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <!-- JS DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const todayBtn = document.getElementById('today-btn');
            const weekBtn = document.getElementById('week-btn');
            const fromDate = document.getElementById('from-date');
            const toDate = document.getElementById('to-date');

            // Fungsi format tanggal ke yyyy-mm-dd
            function formatDate(date) {
                return date.toISOString().split('T')[0];
            }

            // Saat tombol "Today" diklik
            todayBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const today = new Date();
                fromDate.value = formatDate(today);
                toDate.value = formatDate(today);
            });

            // Saat tombol "Week" diklik
            weekBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const today = new Date();
                const sevenDaysAgo = new Date();
                sevenDaysAgo.setDate(today.getDate() - 6); // total 7 hari termasuk hari ini
                fromDate.value = formatDate(sevenDaysAgo);
                toDate.value = formatDate(today);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#report-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('product-report-datatable') }}",
                    type: 'GET',
                    cache: false,
                    data: function(d) {
                        d['from-date'] = $('#from-date').val();
                        d['to-date'] = $('#to-date').val();
                        d['category'] = $('#category').val();
                    }
                },
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-left'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-left',
                    },
                    {
                        data: 'category.name',
                        name: 'category',
                        className: 'text-left',
                        render: function(data) {
                            return '<span class="text-primary"><i class="fa-regular fa-folder"></i> ' +
                                data + '</span>';
                        }
                    },
                    {
                        data: 'total_order',
                        name: 'total_order',
                        className: 'text-center',
                        render: function(data) {
                            return data + ' Item';
                        }
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        className: 'text-left',
                        render: function(data) {
                            return '<span class="text-danger font-weight-bold">Rp ' + data +
                                '</span>';
                        }
                    },
                    {
                        data: 'profit',
                        name: 'profit',
                        className: 'text-left',
                        render: function(data) {
                            return '<span class="text-success font-weight-bold">+ Rp ' + data +
                                '</span>';
                        }
                    },

                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Helper untuk menghilangkan format dan parse angka
                    var parseVal = function(i) {
                        return typeof i === 'string' ?
                            parseFloat(i.replace(/[\Rp, ]/g, '')) || 0 : typeof i === 'number' ? i :
                            0;
                    };

                    // Hitung total kolom total_price dan profit
                    var totalPrice = api.column(4, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return parseVal(a) + parseVal(b);
                    }, 0);

                    var totalProfit = api.column(5, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return parseVal(a) + parseVal(b);
                    }, 0);

                    // Tampilkan hasil di tfoot
                    $(api.column(4).footer()).html(
                        '<span class="text-danger font-weight-bold">Rp ' + totalPrice
                        .toLocaleString('id-ID', {
                            minimumFractionDigits: 2
                        }) + '</span>'
                    );
                    $(api.column(5).footer()).html(
                        '<span class="text-success font-weight-bold">+ Rp ' + totalProfit
                        .toLocaleString('id-ID', {
                            minimumFractionDigits: 2
                        }) + '</span>'
                    );
                },
                // dom: 'Blfrtip',
                dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rt<"d-flex justify-content-between align-items-center mt-3"lip>',
                buttons: [{
                        text: '<i class="fa fa-sync"></i> Refresh',
                        className: 'btn btn-secondary',
                        action: function(e, dt, node, config) {
                            dt.ajax.reload(null, false); // Reload datatable tanpa reset halaman
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger mx-3',
                        orientation: 'portrait',
                        title: 'BOMI POS - @yield('title') - {{ now()->format('d-m-Y') }}',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 10;
                            doc.styles.tableHeader.fontSize = 12;
                            doc.styles.tableHeader.fillColor = '#9900CC';

                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length)
                                .fill('*');
                        },
                        header: true
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-export"></i> Excel',
                        title: 'BOMI POS - @yield('title') - {{ now()->format('d-m-Y') }}',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            modifier: {
                                page: 'all'
                            }
                        }
                    }
                ]
            });

            $('.refresh').click(function() {
                $('#report-table').DataTable().ajax.reload();
            });
            $('#filter-button').click(function() {
                $('#report-table').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
