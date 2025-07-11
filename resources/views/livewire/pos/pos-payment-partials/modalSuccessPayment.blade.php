<div x-cloak x-show="$wire.showSuccessModal" x-transition.opacity
    class="fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">

        {{-- BAGIAN YANG TERLIHAT DI LAYAR --}}
        <div id="receipt-display" class="p-6">
            <div class="text-center">
                {{-- Bagian Header (Checkmark & Judul) tidak diubah --}}
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-10 w-10 text-green-600" viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Payment Successful</h3>
                <p class="text-gray-500 text-sm">Order #{{ $lastTransactionDetails['no_invoice'] ?? '' }} has been
                    processed.</p>
            </div>

            {{-- Status Pesanan dengan Ikon --}}
            @if (!empty($lastTransactionDetails['status']))
                <div class="mt-4 text-center">
                    @if ($lastTransactionDetails['status'] == 'Dine In')
                        <span
                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Dine In
                        </span>
                    @elseif($lastTransactionDetails['status'] == 'To Go')
                        <span
                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.658-.463 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            To Go
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 013.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5a3.375 3.375 0 013.375-3.375H15M12 14.25h.008v.008H12v-.008z" />
                            </svg>
                            Delivery
                        </span>
                    @endif
                </div>
            @endif

            {{-- Daftar Produk yang Dibeli --}}
            <div class="max-h-32 overflow-y-auto border-t border-b border-gray-200 py-2 my-4 text-left">
                @if (!empty($lastTransactionDetails['items']))
                    @foreach ($lastTransactionDetails['items'] as $item)
                        <div class="text-sm py-1 border-b border-gray-100 last:border-b-0">
                            <div class="flex justify-between items-center">
                                <div class="flex-grow pr-2">
                                    <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp.
                                        {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <span class="font-semibold w-24 text-right">Rp.
                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </div>
                            @if (!empty($item['notes']))
                                <p class="text-xs text-purple-700 italic pl-2 mt-1">Catatan: {{ $item['notes'] }}</p>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Rincian Biaya yang Baru --}}
            <div class="text-left text-sm mt-6 space-y-3">
                <div class="flex justify-between items-center text-gray-500">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($lastTransactionDetails['sub_total'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-500">
                    <span>Diskon</span>
                    <span class="text-red-600">- Rp
                        {{ number_format($lastTransactionDetails['discount'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-500">
                    <span>Pajak</span>
                    <span>+ Rp {{ number_format($lastTransactionDetails['tax'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-500">
                    <span>Layanan</span>
                    <span>+ Rp {{ number_format($lastTransactionDetails['service_charge'] ?? 0, 0, ',', '.') }}</span>
                </div>

                <hr class="border-dashed">

                <div class="flex justify-between items-center font-bold text-gray-800">
                    <span>Total Tagihan</span>
                    <span>Rp {{ number_format($lastTransactionDetails['total_bill'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center font-bold text-gray-800">
                    <span>Jumlah Bayar</span>
                    <span>Rp {{ number_format($lastTransactionDetails['amount_paid'] ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center font-bold text-green-600 text-lg">
                    <span>Kembalian</span>
                    <span>Rp {{ number_format($lastTransactionDetails['change'] ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-8">
                <button onclick="printReceipt()"
                    class="py-2.5 px-4 border border-gray-300 text-gray-800 rounded-lg hover:bg-gray-100 transition font-semibold">
                    Print Receipt
                </button>
                <button wire:click="newOrder"
                    class="py-2.5 px-4 bg-resto-purple text-white rounded-lg hover:bg-resto-purple-dark transition font-semibold">
                    New Order
                </button>
            </div>
        </div>

        {{-- BAGIAN STRUK YANG AKAN DI-PRINT (TERSEMBUNYI DARI LAYAR) --}}
        <div id="printable-receipt" class="receipt-for-print">
            <style>
                /* Gaya dasar untuk struk thermal */
                .receipt-text {
                    font-family: 'Courier New', Courier, monospace;
                    font-size: 9pt;
                    line-height: 1.4;
                    color: #000;
                }

                .receipt-header {
                    text-align: center;
                    margin-bottom: 10px;
                }

                .receipt-header h4 {
                    margin: 0;
                    font-size: 12pt;
                }

                .receipt-header p {
                    margin: 0;
                    font-size: 9pt;
                }

                .receipt-divider {
                    border-top: 1px dashed #000;
                    margin: 8px 0;
                }

                .receipt-table {
                    width: 100%;
                    font-size: 9pt;
                }

                .receipt-table td {
                    padding: 1px 0;
                }

                .receipt-table .item {
                    text-align: left;
                }

                .receipt-table .qty {
                    text-align: left;
                    padding-right: 8px;
                    vertical-align: top;
                }

                .receipt-table .price {
                    text-align: right;
                }

                .receipt-footer {
                    text-align: center;
                    margin-top: 10px;
                    font-size: 9pt;
                }
            </style>
            @if ($lastTransactionDetails)
                <div class="receipt-text">
                    <div class="receipt-header">
                        <h4>BOMI RESTO</h4>
                        <p>Jl. Resto Bahagia No. 123, Merauke</p>
                        <p>Tel: (021) 123-4567</p>
                    </div>
                    <div class="receipt-divider"></div>
                    <p>No: {{ $lastTransactionDetails['no_invoice'] }}<br>
                        Kasir: {{ Auth::user()->name }}<br>
                        Tanggal:
                        {{ \Carbon\Carbon::parse($lastTransactionDetails['transaction_time'])->translatedFormat('d M Y, H:i') }}<br>
                        {{-- TAMBAHAN: Menampilkan status pesanan --}}
                        Tipe: {{ $lastTransactionDetails['status'] }}
                    </p>
                    <div class="receipt-divider"></div>
                    <table class="receipt-table">
                        <tbody>
                            @foreach ($lastTransactionDetails['items'] as $item)
                                <tr>
                                    <td colspan="3" class="item">{{ $item['name'] }}</td>
                                </tr>
                                <tr>
                                    <td class="qty">{{ $item['quantity'] }}x</td>
                                    <td class="price">@ {{ number_format($item['price']) }}</td>
                                    <td class="price">{{ number_format($item['price'] * $item['quantity']) }}</td>
                                </tr>
                                @if (!empty($item['notes']))
                                    <tr>
                                        <td colspan="3" class="note">- {{ $item['notes'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class="receipt-divider"></div>
                    <table class="receipt-table">
                        <tbody>
                            <tr>
                                <td>Subtotal:</td>
                                <td class="price">Rp {{ number_format($lastTransactionDetails['sub_total']) }}</td>
                            </tr>
                            <tr>
                                <td>Diskon:</td>
                                <td class="price">- Rp {{ number_format($lastTransactionDetails['discount']) }}</td>
                            </tr>
                            <tr>
                                <td>Pajak:</td>
                                <td class="price">+ Rp {{ number_format($lastTransactionDetails['tax']) }}</td>
                            </tr>
                            {{-- TAMBAHAN: Menampilkan biaya layanan --}}
                            <tr>
                                <td>Layanan:</td>
                                <td class="price">+ Rp {{ number_format($lastTransactionDetails['service_charge']) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="receipt-divider"></div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>TOTAL:</b></td>
                                <td class="price"><b>Rp {{ number_format($lastTransactionDetails['total_bill']) }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>BAYAR:</td>
                                <td class="price">Rp {{ number_format($lastTransactionDetails['amount_paid']) }}</td>
                            </tr>
                            <tr>
                                <td>KEMBALI:</td>
                                <td class="price">Rp {{ number_format($lastTransactionDetails['change']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="receipt-divider"></div>
                    <div class="receipt-footer">
                        <p>Terima Kasih Atas Kunjungan Anda!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <style>
        /* 1. Sembunyikan struk dari layar dengan cara yang lebih andal */
        .receipt-for-print {
            height: 0;
            overflow: hidden;
        }

        /* 2. Aturan CSS yang hanya aktif saat mode print */
        @media print {

            /* Reset margin & padding halaman */
            body,
            html {
                margin: 0;
                padding: 0;
            }

            /* Sembunyikan semua elemen di body saat print */
            body * {
                visibility: hidden;
            }

            /* Tampilkan hanya area struk dan isinya */
            .receipt-for-print,
            .receipt-for-print * {
                visibility: visible;
            }

            /* Atur posisi dan ukuran struk untuk kertas thermal */
            .receipt-for-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 58mm;
                /* <-- UKURAN KERTAS KASIR (bisa diubah ke 80mm) */
                height: auto;
                overflow: visible;
            }
        }
    </style>
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
@endpush
