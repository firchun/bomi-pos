@extends('layouts.app')

@section('title', $title)

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fa fa-gear"></i> @yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>

            <div class="section-body">
                <div class="section-body">
                    <form action="{{ route('settings.index') }}" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 d-flex justify-content-end mb-3">
                                <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-gear"></i>
                                    @if (app()->getLocale() == 'en')
                                        Apply change settings
                                    @else
                                        Terapkan perubahan
                                    @endif
                                </button>
                            </div>
                            <div class="col-lg-8">

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="text-dark"><i class="fa fa-table"></i> Table Management</h5>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="my-2 p-2 border rounded bg-light text-dark">
                                                    @if (app()->getLocale() == 'en')
                                                        you can activate or deactivate the table management feature.
                                                        If activated, you can manage tables for your restaurant. You can add
                                                        new tables, edit existing ones, or delete them if they are no longer
                                                        needed.
                                                    @else
                                                        Anda dapat mengaktifkan atau menonaktifkan fitur manajemen meja.
                                                        Jika diaktifkan, Anda dapat mengelola meja untuk restoran Anda. Anda
                                                        dapat menambahkan meja baru, mengedit yang sudah ada, atau
                                                        menghapusnya
                                                        jika sudah tidak diperlukan.
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="tables" value="1"
                                                        class="custom-switch-input"
                                                        {{ old('tables', $setting_table->tables ?? false) ? 'checked' : '' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">
                                                        Feature
                                                        {{ old('tables', $setting_table->tables ?? false) ? 'Active' : 'Non-active' }}
                                                    </span>
                                                </label>
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="order_on_table" value="1"
                                                        class="custom-switch-input"
                                                        {{ old('order_on_table', $setting_table->order_on_table ?? false) ? 'checked' : '' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">
                                                        Order On Table
                                                    </span>
                                                </label>
                                                <div class="my-2">
                                                    <label for="color_mode">Warna Nomor Meja</label>
                                                    <select id="color_mode" class="form-select mb-2"
                                                        onchange="toggleColorInput(this.value)">
                                                        <option value="solid" selected>Warna Solid</option>
                                                        <option value="gradient">Gradient CSS</option>
                                                        <option value="none">Default</option>
                                                    </select>

                                                    <input type="color" class="form-control mb-2" id="color_solid"
                                                        name="color_number_table"
                                                        value="{{ old('color_number_table', $setting_table->color_number_table ?? '#000000') }}">

                                                    <input type="text" class="form-control mb-2 d-none"
                                                        id="color_gradient" name="color_number_table_gradient"
                                                        placeholder="Contoh: linear-gradient(to right, #ff512f, #dd2476)">

                                                    <input type="hidden" id="final_color" name="color_number_table"
                                                        value="{{ old('color_number_table', $setting_table->color_number_table ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="text-dark"><i class="fa fa-folder"></i> Ingredient Management</h5>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="my-2 p-2 border rounded bg-light text-dark">
                                                    @if (app()->getLocale() == 'en')
                                                        you can activate or deactivate the ingredient management feature.
                                                        If activated, you can manage ingredients for each product. You can
                                                        add
                                                        new ingredients, edit existing ones, or delete them if they are no
                                                        longer
                                                        needed.
                                                    @else
                                                        Anda dapat mengaktifkan atau menonaktifkan fitur manajemen bahan.
                                                        Jika
                                                        diaktifkan, Anda dapat mengelola bahan untuk setiap produk. Anda
                                                        dapat
                                                        menambahkan bahan baru, mengedit yang sudah ada, atau menghapusnya
                                                        jika
                                                        sudah tidak diperlukan.
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="ingredient" value="1"
                                                        class="custom-switch-input"
                                                        {{ old('ingredient', $setting_table->ingredient ?? false) ? 'checked' : '' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">
                                                        Feature
                                                        {{ old('ingredient', $setting_table->ingredient ?? false) ? 'Active' : 'Non-active' }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="text-dark"><i class="fa fa-calendar"></i> Calendar Order</h5>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="my-2 p-2 border rounded bg-light text-dark">
                                                    @if (app()->getLocale() == 'en')
                                                        you can activate or deactivate the calendar order
                                                        feature. If activated, you can manage orders using a calendar view.
                                                        You can add new orders, edit existing ones, or delete them if they
                                                        are
                                                        no longer needed.
                                                    @else
                                                        Anda dapat mengaktifkan atau menonaktifkan fitur kalender pesanan.
                                                        Jika diaktifkan, Anda dapat mengelola pesanan menggunakan tampilan
                                                        kalender. Anda dapat menambahkan pesanan baru, mengedit yang sudah
                                                        ada,
                                                        atau menghapusnya jika sudah tidak diperlukan.
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="calendar" value="1"
                                                        class="custom-switch-input"
                                                        {{ old('calendar', $setting_table->calendar ?? true) ? 'checked' : '' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">
                                                        Feature
                                                        {{ old('calendar', $setting_table->calendar ?? false) ? 'Active' : 'Non-active' }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="text-dark"><i class="fa fa-rectangle-ad"></i> Advertisement Management
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="my-2 p-2 border rounded bg-light text-dark">
                                                    @if (app()->getLocale() == 'en')
                                                        You can activate or deactivate the advertisement
                                                        management feature. If activated, you can manage advertisements for
                                                        your restaurant. You can add new advertisements, edit existing ones,
                                                        or delete them if they are no longer needed.
                                                    @else
                                                        Anda dapat mengaktifkan atau menonaktifkan fitur manajemen iklan.
                                                        Jika diaktifkan, Anda dapat mengelola iklan untuk restoran Anda.
                                                        Anda
                                                        dapat menambahkan iklan baru, mengedit yang sudah ada, atau
                                                        menghapusnya
                                                        jika sudah tidak diperlukan.
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="ads" value="1"
                                                        class="custom-switch-input"
                                                        {{ old('ads', $setting_table->ads ?? false) ? 'checked' : '' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">
                                                        Feature
                                                        {{ old('ads', $setting_table->ads ?? false) ? 'Active' : 'Non-active' }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="text-dark"><i class="fa fa-server"></i> Local Server</h5>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="my-2 p-2 border rounded bg-light text-dark">
                                                    @if (app()->getLocale() == 'en')
                                                        You can activate or deactivate the local server
                                                        feature. If activated, you can manage your local server settings.
                                                        You can add new servers, edit existing ones, or delete them if they
                                                        are no longer needed.
                                                    @else
                                                        Anda akan mengaktifkan atau menonaktifkan fitur server lokal.
                                                        Jika diaktifkan, Anda dapat mengelola pengaturan server lokal Anda.
                                                        Anda dapat menambahkan server baru, mengedit yang sudah ada, atau
                                                        menghapusnya jika sudah tidak diperlukan.
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="local_server" value="1"
                                                        class="custom-switch-input"
                                                        {{ old('local_server', $setting_table->local_server ?? false) ? 'checked' : '' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">
                                                        Feature
                                                        {{ old('local_server', $setting_table->local_server ?? false) ? 'Active' : 'Non-active' }}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </form>
                </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        function toggleColorInput(mode) {
            const colorSolid = document.getElementById('color_solid');
            const colorGradient = document.getElementById('color_gradient');
            const finalColor = document.getElementById('final_color');

            if (mode === 'solid') {
                colorSolid.classList.remove('d-none');
                colorGradient.classList.add('d-none');
                finalColor.value = colorSolid.value;
                colorSolid.oninput = () => finalColor.value = colorSolid.value;
            } else if (mode === 'gradient') {
                colorSolid.classList.add('d-none');
                colorGradient.classList.remove('d-none');
                colorGradient.oninput = () => finalColor.value = colorGradient.value;
            } else {
                colorSolid.classList.add('d-none');
                colorGradient.classList.add('d-none');
                finalColor.value = '';
            }
        }

        // Inisialisasi nilai awal (jika dari DB berupa gradient atau kosong)
        document.addEventListener('DOMContentLoaded', () => {
            const currentValue = "{{ old('color_number_table', $setting_table->color_number_table ?? '') }}";
            const modeSelect = document.getElementById('color_mode');
            if (!currentValue) {
                modeSelect.value = 'none';
            } else if (currentValue.includes('gradient')) {
                modeSelect.value = 'gradient';
            } else {
                modeSelect.value = 'solid';
            }
            toggleColorInput(modeSelect.value);
        });
    </script>
@endpush
