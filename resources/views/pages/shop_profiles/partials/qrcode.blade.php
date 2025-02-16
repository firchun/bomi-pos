<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ $shopName }} - QR Code Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 210mm;
            height: 297mm;
            display: flex;
            flex-direction: column; /* Membuat 2 baris */
            justify-content: space-between; /* Jarak antara baris */
            padding: 10mm;
            box-sizing: border-box;
        }

        .row {
            display: flex;
            justify-content: space-between; /* Jarak antara kolom */
            align-items: center;
            flex: 1; /* Membagi ruang menjadi 2 baris */
        }

        .qr-item {
            width: 60mm; /* Lebar sesuai kebutuhan */
            height: 90mm; /* Tinggi sesuai kebutuhan */
            background: rgba(255, 255, 255, 0.9);
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('/public/qrcodebg.png'); /* Background untuk setiap item */
            background-size: cover; /* Ukuran background sesuai dengan div */
            background-position: center;
        }

        .qr-box img {
            border-radius: 10px;
            margin-top: 2.2rem;
            margin-bottom: 1rem;
            width: 40mm; /* Ukuran QR Code */
            height: 40mm;
        }

        h6 {
            padding-top: 1.3rem;
            margin: 5px 0;
            font-weight: bold;
            color: white;
        }

        p {
            margin: 3px 0;
            font-size: 10px;
            color: white;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach (array_chunk($qrData, 6) as $qrPage)
        <div class="page">
            <!-- Baris Pertama (3 QR Code) -->
            <div class="row">
                @foreach (array_slice($qrPage, 0, 3) as $qr)
                    <div class="qr-item">
                        <h6>{{ $shopName }} - QR Code Menu</h6>
                        <p>Meja {{ $qr['table'] }}</p>
                        <div class="qr-box">
                            <img src="data:image/png;base64,{{ $qr['qrCode'] }}" alt="QR Code Meja {{ $qr['table'] }}">
                        </div>
                        <p>Arahkan kamera ke QR Code ini <br>untuk melihat menu.</p>
                    </div>
                @endforeach
            </div>

            <!-- Baris Kedua (3 QR Code) -->
            <div class="row">
                @foreach (array_slice($qrPage, 3, 3) as $qr)
                    <div class="qr-item">
                        <h6>{{ $shopName }} - QR Code Menu</h6>
                        <p>Meja {{ $qr['table'] }}</p>
                        <div class="qr-box">
                            <img src="data:image/png;base64,{{ $qr['qrCode'] }}" alt="QR Code Meja {{ $qr['table'] }}">
                        </div>
                        <p>Arahkan kamera ke QR Code ini <br>untuk melihat menu.</p>
                    </div>
                @endforeach
            </div>
        </div>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>