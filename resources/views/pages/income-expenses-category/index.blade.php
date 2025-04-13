@extends('layouts.app')

@section('title', 'Categories')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Finance</a></div>
                    <div class="breadcrumb-item">Categories</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-primary mb-3" id="btn-view"></i>View Summary</button>
                    </div>
                    <div class="col-12 mb-3" id="filter">
                        <div class="p-2 bg-white rounded">
                            <b>Filter range date: </b>
                            <div class="d-flex">
                                <input type="date" class="form-control mr-2" id="startDate" name="startDate"
                                    value="{{ request('startDate') }}">
                                <input type="date" class="form-control mr-2" id="endDate" name="endDate"
                                    value="{{ request('endDate') }}">
                                <button type="button" class="btn btn-primary" id="filterButton">Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="summaryExpense">
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex">
                                    @foreach ($categories->where('type', 'expense') as $category)
                                        <div class="px-3 border-right">
                                            <b class="text-primary">{{ $category->category }}</b>
                                            <h4 class="text-danger">Rp 0</h4>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <small class="text-mutted">Total Expense : Rp 0</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="summaryIncome">
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex">

                                    <div class="px-3 border-right">
                                        <b class="text-primary">Orders</b>
                                        <h4 class="text-success">Rp
                                            {{ App\Models\Order::where('user_id', Auth::id())->sum('total') }}</h4>
                                    </div>
                                    @foreach ($categories->where('type', 'income') as $category)
                                        <div class="px-3 border-right">
                                            <b class="text-primary">{{ $category->category }}</b>
                                            <h4 class="text-success">Rp 0</h4>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <small class="text-mutted">Total Income : Rp 0</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        {{-- Form Tambah Kategori --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Category</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('financial.category-store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name Category</label>
                                        <input type="text" name="category"
                                            class="form-control @error('category') is-invalid @enderror"
                                            value="{{ old('category') }}" placeholder="name category" required>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Type</label>
                                        <select type="text" name="type"
                                            class="form-control @error('type') is-invalid @enderror" required>
                                            <option value="expense">expense</option>
                                            <option value="income">income</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Description</label>
                                        <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror" ">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        {{-- Tabel Daftar Kategori --}}
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>List Categories</h4>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#categoryHelpModal"><i class="fa fa-question"></i></button>
                            </div>
                            <div class="card-body">
                                @if ($categories->count())
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Category</th>
                                                    <th>Type</th>
                                                    <th>{{ __('general.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $key => $category)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $category->category }}</td>
                                                        <td><span
                                                                class="badge badge-{{ $category->type == 'income' ? 'primary' : 'warning' }}">{{ $category->type }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex form-group">
                                                                {{-- show --}}
                                                                <button type="button" class="btn btn-warning btn-sm m-1"
                                                                    data-toggle="modal"
                                                                    data-target="#editCategoryModal{{ $category->id }}">
                                                                    <i class="fa fa-edit"></i> {{ __('general.update') }}
                                                                </button>
                                                                {{-- delete --}}
                                                                <form
                                                                    action="{{ route('financial.category-destroy', $category->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure you want to delete this category? If you proceed, all related data will be permanently deleted.');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-danger btn-sm m-1"><i
                                                                            class="fa fa-trash"></i>
                                                                        {{ __('general.delete') }} </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>Category not yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @foreach ($categories as $category)
        <!-- Edit Modal -->
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('financial.category-update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category">Category Name</label>
                                <input type="text" class="form-control" name="category"
                                    value="{{ $category->category }}" required>
                            </div>
                            <div class="form-group">
                                <label for="type">Category Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="income" {{ $category->type == 'income' ? 'selected' : '' }}>Income
                                    </option>
                                    <option value="expense" {{ $category->type == 'expense' ? 'selected' : '' }}>Expense
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description (optional)</label>
                                <textarea name="description" class="form-control">{{ $category->description }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    {{-- modal --}}
    <div class="modal fade" id="categoryHelpModal" tabindex="-1" role="dialog"
        aria-labelledby="categoryHelpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="categoryHelpModalLabel">Guidelines & Category Examples</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (app()->getLocale() == 'en')
                        <h6 class="font-weight-bold text-success">Category <i>Income</i>:</h6>
                        <ul>
                            <li>Product Sales</li>
                            <li>Incoming Investments</li>
                            <li>Debt Repayments</li>
                            <li>Grants or Donations</li>
                        </ul>

                        <h6 class="font-weight-bold text-danger mt-4">Category <i>Expense</i>:</h6>
                        <ul>
                            <li>Operational Costs</li>
                            <li>Employee Salaries</li>
                            <li>Product Purchases</li>
                            <li>Rent</li>
                            <li>Electricity and Water</li>
                        </ul>

                        <div class="alert alert-info mt-4 mb-0">
                            Use appropriate categories to keep your financial reports clear and easy to analyze.
                        </div>
                    @else
                        <h6 class="font-weight-bold text-success">Kategori <i>Pemasukan</i>:</h6>
                        <ul>
                            <li>Penjualan Produk</li>
                            <li>Investasi Masuk</li>
                            <li>Pelunasan Utang</li>
                            <li>Hibah atau Donasi</li>
                        </ul>

                        <h6 class="font-weight-bold text-danger mt-4">Kategori <i>Pengeluaran</i>:</h6>
                        <ul>
                            <li>Biaya Operasional</li>
                            <li>Gaji Karyawan</li>
                            <li>Pembelian Produk</li>
                            <li>Sewa</li>
                            <li>Listrik dan Air</li>
                        </ul>

                        <div class="alert alert-info mt-4 mb-0">
                            Gunakan kategori yang sesuai agar laporan keuangan Anda tetap jelas dan mudah dianalisis.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const summaryIncome = document.getElementById('summaryIncome');
            const summaryExpense = document.getElementById('summaryExpense');
            const filter = document.getElementById('filter');
            const toggleButton = document.getElementById('btn-view');

            // Set awal: sembunyikan summary dan filter
            summaryIncome.style.display = 'none';
            summaryExpense.style.display = 'none';
            filter.style.display = 'none';

            toggleButton.addEventListener('click', function() {
                const isHidden = summaryIncome.style.display === 'none';

                summaryIncome.style.display = isHidden ? 'block' : 'none';
                summaryExpense.style.display = isHidden ? 'block' : 'none';
                filter.style.display = isHidden ? 'block' : 'none';

                toggleButton.innerHTML = isHidden ? '<i class="fa fa-eye-slash"></i> Hide Summary' :
                    '<i class="fa fa-eye"></i> View Summary';
            });
        });
    </script>
@endpush
