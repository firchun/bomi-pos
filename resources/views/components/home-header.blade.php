<!-- navigation -->
<header class="navigation">
    <nav class="navbar navbar-expand-xl navbar-light text-center">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img loading="prelaod" decoding="async" class="img-fluid" width="100"
                    src="{{ asset('home/images/logo_kasir.png') }}" alt="Bomi-Pos">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"> <a class="nav-link " href="{{ route('homepage') }}">Home</a>
                    </li>
                    <li class="nav-item "> <a class="nav-link" href="{{ route('shop-page') }}">Restaurant</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Product
                        </a>
                    </li>
                    {{-- <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">About</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item " href="blog.html">Profile Company</a>
                            </li>
                            <li><a class="dropdown-item " href="blog-details.html">Contact Us</a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
                <div class="d-flex justify-content-center mb-3 mb-lg-0">
                    <div class="search-container px-3">
                        <div class="search-input-wrapper">
                            <input type="text" id="search-input" class="search-input" placeholder="Search Products"
                                autocomplete="off">
                        </div>

                        <!-- Hasil Pencarian -->
                        <div id="search-results" class="search-dropdown mx-3">
                            <!-- Hasil pencarian dinamis akan dimasukkan di sini -->
                        </div>
                    </div>
                </div>
                <!-- Input untuk mencari produk -->

                @if (auth()->check())
                    <a href="{{ route('home') }}" class="btn btn-primary ms-2 ms-lg-3 px-5">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary px-5">Log in</a>
                @endif

            </div>
        </div>
    </nav>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search-input').on('input', function() {
            let query = $(this).val().toLowerCase(); // Ambil input dan ubah menjadi huruf kecil
            let resultsDropdown = $('#search-results');

            // Jika input kosong, sembunyikan hasil pencarian
            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('ajax.search') }}", // Pastikan URL sesuai dengan route
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        resultsDropdown.empty(); // Kosongkan dropdown sebelumnya
                        let uniqueResults =
                    new Set(); // Menggunakan Set untuk menyimpan nama unik

                        if (response.products.length > 0) {
                            response.products.forEach(function(product) {
                                if (!uniqueResults.has(product.name)) {
                                    uniqueResults.add(product
                                    .name); // Tambahkan nama unik ke Set
                                    // Tambahkan item pencarian ke dalam dropdown
                                    resultsDropdown.append(`
                                    <div class="search-item" data-id="${product.id}">${product.name}</div>
                                `);
                                }
                            });

                            resultsDropdown.show(); // Tampilkan dropdown
                        } else {
                            resultsDropdown.append(
                                '<div class="search-item text-muted">No results found</div>'
                            );
                            resultsDropdown.show(); // Tampilkan dropdown
                        }
                    },
                    error: function() {
                        resultsDropdown.html(
                            '<div class="search-item text-danger">Error fetching results</div>'
                        ).show();
                    }
                });
            } else {
                resultsDropdown.hide(); // Sembunyikan dropdown jika input kosong
            }
        });

        // Klik pada item pencarian
        $(document).on('click', '.search-item', function() {
            $('#search-input').val($(this).text()); // Menampilkan teks yang dipilih
            $('#search-results').hide(); // Sembunyikan dropdown

            // Arahkan ke halaman hasil pencarian
            window.location.href = "/search?q=" + $('#search-input').val();
        });

        // Menangani tombol Enter untuk pengalihan ke halaman pencarian
        $('#search-input').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Mencegah form submit
                let query = $(this).val();
                if (query.length > 0) {
                    // Arahkan ke halaman pencarian
                    window.location.href = "/search?q=" + query;
                }
            }
        });

        // Menyembunyikan dropdown jika klik di luar
        $(document).click(function(e) {
            if (!$(e.target).closest('.search-container').length) {
                $('#search-results').hide();
            }
        });
    });
</script>
