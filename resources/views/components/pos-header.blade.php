<nav class="navbar navbar-expand-lg" style="background-color: #9900CC;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button id="hamburger-menu" class="navbar-toggler d-block me-3 border-0 bg-transparent text-white"
                type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent"
                aria-expanded="false" aria-label="Toggle navigation" style="outline: none;">
                <span class="fa fa-bars" style="color: white; font-size: 1.5rem;"></span>
            </button>

            <div class="d-flex flex-column">
                <strong class="text-white">{{ Auth::user()->name }}</strong>
                <small class="text-white" id="tanggal-sekarang">
                    {{-- tanggal di javascript --}}
                </small>
            </div>
        </div>

        <div class="flex-grow-1 text-center">
            <!-- Kosong -->
        </div>

        <!-- Tombol Fullscreen -->
        <div class="me-3">
            <div onclick="toggleFullScreen()"
                class="d-flex justify-content-center align-items-center border-0 text-white"
                style="width: 40px; height: 40px; cursor: pointer;" title="Fullscreen">
                <i id="fullscreen-icon" class="fa-solid fa-expand" style="font-size: 1.3rem;"></i>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <div class="border rounded px-3 py-1 me-3 bg-white text-dark" id="jam-sekarang">
                {{-- jam di javascript --}}
            </div>

            <div class="me-3">
                <div id="wifi-icon"
                    class="d-flex justify-content-center align-items-center border rounded p-2 bg-success border-success text-white"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-wifi" style="font-size: 1.2rem;"></i>
                </div>
            </div>

            {{-- <form method="get" action="{{ route('home') }}">
                @csrf
                <button type="submit" class="btn p-1 border border-danger bg-danger text-white rounded" title="Logout"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-box-arrow-right" style="font-size: 1.2rem;"></i>
                </button>
            </form> --}}
            <a href="{{route('home')}}" class="btn p-1 border border-danger bg-danger text-white rounded" title="Logout"
                style="width: 40px; height: 40px;">
                <i class="bi bi-box-arrow-right" style="font-size: 1.2rem;"></i>
            </a>
        </div>
    </div>
</nav>

<script>
    window.onload = () => {
        setInterval(() => {
            const now = new Date();
            const optionsDate = {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
            };
            document.getElementById('tanggal-sekarang').innerText = new Intl.DateTimeFormat('id-ID',
                optionsDate).format(now);

            const optionsTime = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            };
            document.getElementById('jam-sekarang').innerText = new Intl.DateTimeFormat('id-ID',
                optionsTime).format(now);
        }, 1000);
    };

    function updateWifiStatus() {
        const wifiIcon = document.getElementById('wifi-icon');
        const isOnline = navigator.onLine;

        if (isOnline) {
            wifiIcon.classList.remove('bg-danger', 'border-danger', 'text-secondary');
            wifiIcon.classList.add('bg-success', 'border-success', 'text-white');
        } else {
            wifiIcon.classList.remove('bg-success', 'border-success', 'text-white');
            wifiIcon.classList.add('bg-danger', 'border-danger', 'text-secondary');
        }
    }
    updateWifiStatus();

    window.addEventListener('online', updateWifiStatus);
    window.addEventListener('offline', updateWifiStatus);

    function toggleFullScreen() {
        const elem = document.documentElement;
        const icon = document.getElementById('fullscreen-icon');

        if (!document.fullscreenElement) {
            elem.requestFullscreen().then(() => {
                icon.classList.remove('fa-expand');
                icon.classList.add('fa-compress');
            }).catch(err => {
                console.log(`Error attempting to enable full-screen mode: ${err.message}`);
            });
        } else {
            document.exitFullscreen().then(() => {
                icon.classList.remove('fa-compress');
                icon.classList.add('fa-expand');
            });
        }
    }

    // Optional: handle esc key or F11
    document.addEventListener('fullscreenchange', () => {
        const icon = document.getElementById('fullscreen-icon');
        if (!document.fullscreenElement) {
            icon.classList.remove('fa-compress');
            icon.classList.add('fa-expand');
        }
    });
</script>
