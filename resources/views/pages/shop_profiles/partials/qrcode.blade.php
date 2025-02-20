<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ $shopName }} - QR Code Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4 portrait;
            margin: 5px;
        }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .page {
            height: 210mm;
            weight: 297mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10mm;
            box-sizing: border-box;
            page-break-after: always;
        }

        .row {
            display: flex;
            justify-content: space-between;
            /* Jarak antara kolom */
            align-items: center;
            flex: 1;
            /* Membagi ruang menjadi 2 baris */
        }

        .qr-item {
            width: 90mm;
            /* Lebar sesuai kebutuhan */
            height: 130mm;
            /* Tinggi sesuai kebutuhan */
            background: rgba(255, 255, 255, 0.9);
            margin: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* background-image: url('/public/qrcodebg.png'); */
            background-image: url('{{ asset('qrcodebg.png') }}');
            background-size: cover;
            /* Ukuran background sesuai dengan div */
            background-position: center;
        }

        .qr-box img {
            border-radius: 10px;
            margin-top: 1rem;
            margin-bottom: 2rem;
            width: 57mm;
            /* Ukuran QR Code */
            height: 57mm;
        }

        h5 {
            /* padding-top: 0.3rem; */
            font-weight: bold;
            color: white;
        }

        p {
            /* margin: 3px 0; */
            font-size: 10px;
            color: white;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body onload="window.print()">
    @foreach (array_chunk($qrData, 4) as $qrPage)
        <div class="page">
            <!-- Baris Pertama (3 QR Code) -->
            <div class="row">
                @foreach ($qrPage as $qr)
                    <div class="qr-item">
                        <p>{{ $shopName }}</p>
                        <h5>Meja {{ $qr['table'] }}</h5>
                        <div class="qr-box">
                            <img src="{{ $qr['qrCode'] }}" alt="QR Code Meja {{ $qr['table'] }}">
                        </div>
                        <p>Arahkan kamera ke QR Code ini <br>untuk melihat menu.</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    {{-- <script>
        window.onload = function() {
            window.print();
        };
    </script> --}}
</body>

</html>
