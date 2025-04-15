@extends('layouts.app')

@section('title', 'Report')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />

    <style>
        /* #report-table thead th {
                                                    background-color: #9900CC;
                                                    color: white;
                                                    text-align: center;
                                                } */

        /* #report-table tbody tr:nth-child(even) {
                                                background-color: #f9f9f9;
                                            }

                                            #report-table tbody tr:hover {
                                                background-color: rgba(153, 0, 204, 0.2);
                                            } */
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Report</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Report</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white" style="border-radius: 10px;">
                            <div class="card-body">
                                <h4>Cash : Rp. <span id="total-revenue">0</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
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

                                <div class="table-responsive">
                                    <table class="table-striped table-hover table table-sm" id="report-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>No Invoice</th>
                                                <th>Date</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>No Invoice</th>
                                                <th>Date</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Action</th>
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
                        d.date = $('#date-filter').val();
                    },
                    dataSrc: function(json) {
                        $('#total-revenue').text('Rp' + new Intl.NumberFormat('id-ID').format(json
                            .totalRevenue));
                        return json.data;
                    }
                },
                order: [
                    [2, 'desc']
                ],
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-left'
                    },
                    {
                        data: 'no_invoice',
                        name: 'no_invoice',
                        className: 'text-left'
                    },
                    {
                        data: 'tanggal_transaksi',
                        name: 'transaction_time',
                        className: 'text-left'
                    },
                    {
                        data: 'jumlah_beli',
                        name: 'total_item',
                        className: 'text-left'
                    },
                    {
                        data: 'total_keseluruhan',
                        name: 'total',
                        className: 'text-left',
                        render: function(data) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: 'detail_button',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#date-filter-form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });
        });
    </script>
@endpush
