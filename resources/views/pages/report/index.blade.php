@extends('layouts.app')

@section('title', 'Report')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
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
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h4 class="mt-3"><strong>Cash: Rp. <span id="total-revenue">0</span></strong></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right">
                                    <form id="date-filter-form">
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="date" id="date-filter"
                                                value="{{ $date ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table" id="report-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Tanggal Transaksi</th>
                                                <th>Jumlah Beli</th>
                                                <th>Harga Satuan</th>
                                                <th>Total Harga</th>
                                                <th>Diskon</th>
                                                <th>Total Setelah Diskon</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
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
    
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#report-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('daily.report') }}",
                    type: 'GET',
                    data: function(d) {
                        d.date = $('#date-filter').val(); // Filter tanggal (jika ada)
                    },
                    dataSrc: function(json) {
                        // Update Total Revenue untuk keseluruhan data
                        $('#total-revenue').text('Rp' + new Intl.NumberFormat('id-ID').format(json
                            .totalRevenue));
                        return json.data;
                    }
                },
                columns: [{
                        data: 'nomor',
                        name: 'nomor',
                        className: 'text-left'
                    },
                    {
                        data: 'nama_product',
                        name: 'nama_product',
                        className: 'text-left'
                    },
                    {
                        data: 'tanggal_transaksi',
                        name: 'tanggal_transaksi',
                        className: 'text-left'
                    },
                    {
                        data: 'jumlah_beli',
                        name: 'jumlah_beli',
                        className: 'text-left'
                    },
                    {
                        data: 'harga_satuan',
                        name: 'harga_satuan',
                        className: 'text-left'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga',
                        className: 'text-left'
                    },
                    {
                        data: 'diskon',
                        name: 'diskon',
                        className: 'text-left'
                    },
                    {
                        data: 'total_setelah_diskon',
                        name: 'total_setelah_diskon',
                        className: 'text-left'
                    },
                ],
                columnDefs: [{
                    targets: [3, 4, 5, 6], // Format untuk kolom harga
                    render: function(data, type, row) {
                        return type === 'display' ? 'Rp' + new Intl.NumberFormat('id-ID')
                            .format(data) : data;
                    }
                }],
                // language: {
                //     url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
                // }
            });

            // Event saat filter tanggal dikirim
            $('#date-filter-form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload(); // Reload data sesuai filter
            });
        });
    </script>
@endpush
