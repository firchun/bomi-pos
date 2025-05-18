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
                    <div class="breadcrumb-item"><a href="#">Ingredient</a></div>
                    <div class="breadcrumb-item">Categories</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                    <div class="col-12 mb-3">
                        <a href="{{ route('ingredient.index') }}" class="btn btn-secondary"><i
                                class="fa fa-arrow-left"></i> {{__('general.back')}}</a>
                    </div>
                    <div class="col-lg-4">
                        {{-- Form Tambah Kategori --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>{{__('general.add')}} {{__('general.category')}}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('ingredient-category.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name {{__('general.category')}}</label>
                                        <input type="text" name="category"
                                            class="form-control @error('category') is-invalid @enderror"
                                            value="{{ old('category') }}" placeholder="name category" required>
                                        @error('category')
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
                                <h4>List {{__('general.category')}}</h4>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#categoryHelpModal"><i class="fa fa-question"></i></button>
                            </div>
                            <div class="card-body">
                                @if ($categories->count())
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{__('general.category')}}</th>
                                                    <th>{{__('general.ingredient')}}</th>
                                                    <th>{{ __('general.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $key => $category)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $category->category }}</td>
                                                        <td class="text-center"><span class="badge badge-success">{{App\Models\Ingredient::where('id_category',$category->id)->count()}}</span></td>
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
                                                                    action="{{ route('ingredient-category.delete', $category->id) }}"
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
                <form action="{{ route('ingredient-category.update', $category->id) }}" method="POST">
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
    <div class="modal fade" id="categoryHelpModal" tabindex="-1" role="dialog" aria-labelledby="categoryHelpModalLabel"
        aria-hidden="true">
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
                        <h6 class="font-weight-bold text-primary">Category <i>Ingredient</i>:</h6>
                        <ul>
                            <li>Meat & Poultry</li>
                            <li>Seafood</li>
                            <li>Vegetables</li>
                            <li>Fruits</li>
                            <li>Grains & Pasta</li>
                            <li>Dairy Products</li>
                            <li>Spices & Seasonings</li>
                            <li>Beverage Supplies</li>
                            <li>Bakery Items</li>
                            <li>Condiments & Sauces</li>
                        </ul>

                        <div class="alert alert-info mt-4 mb-0">
                            Group ingredients properly to simplify stock management and purchasing.
                        </div>
                    @else
                        <h6 class="font-weight-bold text-primary">Kategori <i>Bahan Baku</i>:</h6>
                        <ul>
                            <li>Daging & Unggas</li>
                            <li>Makanan Laut</li>
                            <li>Sayuran</li>
                            <li>Buah-buahan</li>
                            <li>Serealia & Pasta</li>
                            <li>Produk Susu</li>
                            <li>Rempah & Bumbu</li>
                            <li>Perlengkapan Minuman</li>
                            <li>Produk Roti & Kue</li>
                            <li>Saus & Pelengkap</li>
                        </ul>

                        <div class="alert alert-info mt-4 mb-0">
                            Kelompokkan bahan baku dengan baik untuk memudahkan pengelolaan stok dan pembelian.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
