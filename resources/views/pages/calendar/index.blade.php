@extends('layouts.app')

@section('title', 'Calendar Order')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('library/fullcalendar/dist/fullcalendar.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        /* Mengubah tombol navigasi FullCalendar (Prev, Next, Today) */
        .fc-prev-button,
        .fc-next-button,
        .fc-today-button {
            background-color: #9900CC !important;
            /* Warna latar belakang */
            color: white !important;
            /* Warna teks */
            border: 2px solid white !important;
            /* Border putih */
            transition: background-color 0.3s ease;
            /* Efek transisi */
        }

        /* Efek hover untuk tombol navigasi */
        .fc-prev-button:hover,
        .fc-next-button:hover,
        .fc-today-button:hover {
            background-color: #7a00b3 !important;
            /* Warna saat hover */
            border-color: white !important;
        }

        /* Mengubah tombol untuk tampilan lebih baik di FullCalendar */
        .fc-button {
            background-color: #9900CC !important;
            color: white !important;
            border: 2px solid white !important;
            border-radius: 10px !important;
        }

        /* Efek hover untuk tombol di FullCalendar */
        .fc-button:hover {
            background-color: #7a00b3 !important;
            border-color: white !important;
        }

        .fc-daygrid-day-number {
            color: #9900CC !important;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .fc-col-header-cell-cushion {
            color: #9900CC !important;
            font-weight: bold;
            font-size: 1.2rem;
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
                    <div class="breadcrumb-item"><a href="#">Order</a></div>
                    <div class="breadcrumb-item">Calendar</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">@yield('title')</h2>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card" style="border-radius: 10px;">
                            <div class="card-body">
                                <div class="fc-overflow">
                                    <div id="myEvent"></div>
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
    {{-- <script src="{{ asset('library/fullcalendar/dist/fullcalendar.min.js') }}"></script> --}}
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-calendar.js') }}"></script>
    <!-- JS FullCalendar (v5+) -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('myEvent');
            const events = @json($events);

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: events,
                eventDidMount: function(info) {
                    // Mengatur warna event
                    info.el.style.backgroundColor = '#9900CC';
                    info.el.style.color = 'white';
                    info.el.style.border = '2px solid white';
                    info.el.style.padding = '3px 10px';
                    info.el.style.borderRadius = '10px';
                    // Menambahkan Tippy.js untuk menampilkan popover saat hover
                    tippy(info.el, {
                        content: info.event.title, // Atur konten popover
                        theme: 'light', // Bisa memilih tema, misalnya 'light' atau 'dark'
                        interactive: true, // Agar popover tetap aktif saat hover
                        arrow: true // Menambahkan arrow pada popover
                    });
                }
            });

            calendar.render();
        });
    </script>
@endpush
