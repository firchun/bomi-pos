<div class="text-center mt-5 text-sm text-zinc-500 dark:text-zinc-400">
    &copy; {{ date('Y') }} <span class="font-semibold">Bomi POS</span>
    @if (App::environment('local'))
        | <!-- Tombol Sync -->
        <button onclick="openSyncModal()" type="button" class="text-purple-600 hover:underline">Sync Data</button>

        <!-- Modal Sinkronisasi -->
        <div id="syncModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50 backdrop-blur-sm">
            <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Sinkronisasi Data</h2>
                <p class="text-gray-600 mb-4">
                    Anda akan mengirim data dari perangkat lokal ke <span class="font-semibold text-purple-700">Bomi POS
                        Cloud Server</span>.
                    Pastikan koneksi internet tersedia. Proses ini akan memperbarui data transaksi, stok, atau
                    pengaturan yang belum tersinkron.
                </p>
                <!-- Input Token -->
                <div class="mb-4">
                    <label for="syncToken" class="block text-sm font-medium text-gray-700 mb-1">Token Server</label>
                    <div
                        class="flex items-center border rounded-lg px-3 py-2 bg-white shadow-sm focus-within:ring-2 ring-purple-500 relative">
                        <i class="fas fa-key text-gray-400 mr-2"></i>
                        <input type="text" id="syncToken" name="syncToken"
                            class="w-full border-0 focus:ring-0 focus:outline-none text-sm text-gray-800 pr-6"
                            placeholder="Masukkan token dari server cloud" />
                        <i id="checkIcon" class="fas fa-check-circle text-green-500 absolute right-3 hidden"></i>
                    </div>
                </div>
                <table class="w-full text-sm text-left text-gray-600 mb-4 border">
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2 px-2 font-medium">Status Jaringan</td>
                            <td class="py-2 px-2" id="networkStatus">Mengecek...</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 px-2 font-medium">Kecepatan Internet</td>
                            <td class="py-2 px-2" id="internetSpeed">Mengecek...</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 px-2 font-medium">Cloud Server</td>
                            <td class="py-2 px-2" id="connectedServer">Mengecek...</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 px-2 font-medium">Terakhir Sinkron</td>
                            <td class="py-2 px-2" id="lastSyncTime">Belum pernah</td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex justify-center space-x-2 mt-6">
                    <button onclick="closeSyncModal()"
                        class="px-4 py-2 bg-gray-300 rounded-xl hover:bg-red-500 text-gray-800 hover:text-white">
                        Batal
                    </button>
                    <button onclick="confirmSync()" id="confirmSyncButton"
                        class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 opacity-50 cursor-not-allowed"
                        disabled>
                        Mengecek...
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts')
    @if (App::environment('local'))
        <script>
            const input = document.getElementById('syncToken');
            const checkIcon = document.getElementById('checkIcon');

            // UUID v4 pattern: 8-4-4-4-12 dan harus mulai dengan versi 4 dan varian [89ab]
            const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;

            input.addEventListener('input', () => {
                let value = input.value.replace(/[^a-fA-F0-9]/g, ''); // hapus selain hex
                let formatted = '';

                // Format UUID v4: 8-4-4-4-12
                if (value.length > 8) {
                    formatted += value.substring(0, 8) + '-';
                    if (value.length > 12) {
                        formatted += value.substring(8, 12) + '-';
                        if (value.length > 16) {
                            formatted += value.substring(12, 16) + '-';
                            if (value.length > 20) {
                                formatted += value.substring(16, 20) + '-';
                                formatted += value.substring(20, 32);
                            } else {
                                formatted += value.substring(16);
                            }
                        } else {
                            formatted += value.substring(12);
                        }
                    } else {
                        formatted += value.substring(8);
                    }
                } else {
                    formatted = value;
                }

                input.value = formatted.toLowerCase();

                // Validasi dan tampilkan centang atau popup
                if (uuidRegex.test(input.value)) {
                    checkIcon.classList.remove('hidden');
                } else {
                    checkIcon.classList.add('hidden');

                    // Jika user sudah ketik 36 karakter (UUID lengkap tapi salah)
                    if (input.value.length === 36) {
                        // Cek apakah popup sudah muncul sebelumnya
                        if (!document.getElementById('uuidErrorPopup')) {
                            const popup = document.createElement('div');
                            popup.id = 'uuidErrorPopup';
                            popup.className =
                                'fixed bottom-4  bg-red-100 text-red-700 px-4 py-2 rounded shadow-lg z-50';
                            popup.innerText = '❌ Token tidak sesuai, harap menghubungi teknisi Bomi POS';

                            document.body.appendChild(popup);

                            setTimeout(() => {
                                popup.remove();
                            }, 4000);
                        }
                    }
                }
            });
        </script>
        <script>
            function openSyncModal() {
                document.getElementById('syncModal').classList.remove('hidden');
            }

            function closeSyncModal() {
                document.getElementById('syncModal').classList.add('hidden');
            }

            function checkNetworkStatus() {
                fetch('/check-network')
                    .then(res => res.json())
                    .then(data => {
                        const statusElement = document.getElementById('networkStatus');
                        const conSyncButton = document.getElementById('confirmSyncButton');
                        conSyncButton.disabled = true;
                        conSyncButton.classList.add('opacity-50', 'cursor-not-allowed');

                        if (data.online) {
                            statusElement.innerHTML =
                                '<i class="fas fa-wifi text-green-500 mr-1"></i> <span class="text-green-600 font-semibold">Online</span>';
                            // Aktifkan tombol
                            conSyncButton.disabled = false;
                            conSyncButton.classList.remove('opacity-50', 'cursor-not-allowed');
                            conSyncButton.innerHTML =
                                '<i class="fas fa-cloud-arrow-up mr-1"></i> Konfirmasi Sinkronisasi';
                        } else {
                            statusElement.innerHTML =
                                '<i class="fas fa-wifi text-red-500 mr-1"></i> <span class="text-red-600 font-semibold">Offline</span>';
                            // Nonaktifkan tombol
                            conSyncButton.disabled = true;
                            conSyncButton.classList.add('opacity-50', 'cursor-not-allowed');
                            conSyncButton.innerHTML = 'Menunggu Internet...';
                        }

                    })
                    .catch(() => {
                        document.getElementById('networkStatus').textContent = '🔴 Tidak terdeteksi';
                    });
            }


            function checkInternetAndSpeed() {
                const speedElement = document.getElementById('internetSpeed');

                // Cek apakah browser mendukung Network Information API
                if ('connection' in navigator) {
                    const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
                    const downlink = connection.downlink; // Mbps

                    if (downlink) {
                        const speedKbps = downlink * 1000;
                        speedElement.textContent = `${speedKbps.toFixed(0)} Kbps`;

                        if (speedKbps < 500) {
                            speedElement.classList.add('text-red-600');
                            speedElement.classList.remove('text-green-600');
                        } else {
                            speedElement.classList.add('text-green-600');
                            speedElement.classList.remove('text-red-600');
                        }
                        return; // Stop di sini jika berhasil dapat downlink
                    }
                }

                // Jika tidak didukung, lanjut dengan metode fetch file kecil
                const testUrl = 'https://www.google.com/favicon.ico'; // File kecil (~1KB)
                const start = new Date().getTime();

                fetch(testUrl, {
                        method: 'GET',
                        cache: 'no-cache',
                        mode: 'no-cors'
                    })
                    .then(() => {
                        const end = new Date().getTime();
                        const duration = (end - start) / 1000;

                        const fileSizeMB = 0.001; // ~1KB
                        const speedMbps = (fileSizeMB * 8) / duration; // Mbps
                        const speedKbps = speedMbps * 1000;

                        speedElement.textContent = `${speedKbps.toFixed(0)} Kbps`;

                        if (speedKbps < 500) {
                            speedElement.classList.add('text-red-600');
                            speedElement.classList.remove('text-green-600');
                        } else {
                            speedElement.classList.add('text-green-600');
                            speedElement.classList.remove('text-red-600');
                        }
                    })
                    .catch(() => {
                        speedElement.textContent = 'Tidak ada koneksi';
                        speedElement.classList.add('text-red-600');
                        speedElement.classList.remove('text-green-600');
                    });
            }

            function checkConecctedServer() {
                const testUrl = '{{ config('app.server') }}'; // file kecil dan cepat di-load
                const start = new Date().getTime();

                fetch(testUrl, {
                        method: 'GET',
                        cache: 'no-cache',
                        mode: 'no-cors'
                    })
                    .then(() => {
                        const end = new Date().getTime();
                        const duration = (end - start) / 1000;

                        // Ukuran file dalam MB dan konversi ke Kbps
                        const fileSizeMB = 0.001; // ~1KB
                        const speedMbps = (fileSizeMB * 8) / duration; // Mbps
                        const speedKbps = speedMbps * 1000; // Kbps

                        const speedText = `${speedKbps.toFixed(0)} Kbps`;

                        const speedElement = document.getElementById('connectedServer');
                        speedElement.innerHTML = '<i class="fa fa-server"></i> Connected';

                        speedElement.classList.add('text-green-600');
                        speedElement.classList.remove('text-red-600');

                    })
                    .catch(() => {
                        document.getElementById('connectedServer').classList.add('text-red-600');
                        document.getElementById('connectedServer').classList.remove('text-green-600');
                        document.getElementById('connectedServer').textContent = 'Not Connected';
                    });
            }


            function confirmSync() {
                document.getElementById('lastSyncTime').textContent = new Date().toLocaleString();

                // Tambahkan logika sync di sini
                alert('Sinkronisasi berjalan...');
            }

            // Interval pengecekan setiap 5 detik
            setInterval(() => {
                checkNetworkStatus();
                checkInternetAndSpeed();
                checkConecctedServer();
            }, 5000);

            // Inisialisasi awal saat modal dibuka
            document.getElementById('syncModal').addEventListener('transitionstart', () => {
                checkNetworkStatus();
                checkInternetAndSpeed();
                checkConecctedServer();
            });
        </script>
    @endif
@endpush
