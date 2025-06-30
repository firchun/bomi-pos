<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ $shopName }} - QR Code Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A5 portrait;
            margin: 0;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;

        }

        .page {
            width: 100%;
            height: 100%;
            page-break-after: always;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* background-image: url('{{ asset('qrcodebg.png') }}'); */
            background: {{ $setting->color_number_table ?? 'linear-gradient(135deg, #ff512f, #dd2476)' }};
            background-size: cover;
            background-position: center;
        }

        .qr-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 4px;
            border-radius: 12px;
        }

        h5 {
            font-weight: bold;
            color: white;
            margin-top: 20px;
        }

        p {
            font-size: 10px;
            color: white;
            margin: 4px 0;
        }
    </style>
</head>

<body>
    <div id="qr-content">
        @foreach ($qrData as $qr)
            <div class="page d-flex flex-column justify-content-center align-items-center text-center">
                <div class="mt-4 mb-3">
                    <h4 class="mb-0 text-white fw-semibold" style="font-family: 'DM Sans', sans-serif;">
                        {{ $shopName }}
                    </h4>
                </div>
                <h1 class="fw-bold text-white" style="font-size: 260px;line-height: 0.8;">
                    {{ strlen(preg_replace('/\D/', '', $qr['table'])) == 1 ? '0' . preg_replace('/\D/', '', $qr['table']) : preg_replace('/\D/', '', $qr['table']) }}
                </h1>

                <div class="qr-box my-4 d-flex flex-column align-items-center">
                    <img src="{{ $qr['qrCode'] }}" alt="QR Code Meja {{ $qr['table'] }}"
                        style="width: 300px; border-radius: 12px;">
                    <span class="fw-bold text-dark mt-2" style="font-size:30px;">SCAN ME!</span>
                </div>

                <div class="footer-text text-white fw-bold pb-3" style="font-size: 20px;">
                    Arahkan kamera ke QR Code ini untuk melihat menu dan melakukan pemesanan.
                </div>
            </div>
        @endforeach
    </div>

    {{-- Script untuk mengubah ke PDF dan auto-download --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        window.onload = function() {
            const element = document.getElementById('qr-content');
            const opt = {
                margin: 0,
                filename: '{{ $shopName ?? 'qr-code' }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'pt',
                    format: 'a5',
                    orientation: 'portrait'
                }
            };

            // html2pdf().set(opt).from(element).save();
            html2pdf().set(opt).from(element).save().then(() => {
                setTimeout(() => {
                    window.close();
                }, 600);
            });
        };
    </script>
</body>

</html>
