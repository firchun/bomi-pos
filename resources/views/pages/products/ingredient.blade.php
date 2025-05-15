@extends('layouts.app')

@section('title', "Ingredients for : {$product->name}")

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>
            <div class="section-body">
                <a href="{{ route('products.index') }}" class="btn btn-secondary mr-3 mb-2">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addIngredientModal">
                    <i class="fas fa-plus"></i> Add Ingredient to list
                </button>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>@yield('title')</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ingredient</th>
                                                <th>qty</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($dish as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->ingredient->name ?? '' }}</td>
                                                    <td>{{ $data->qty }} <small>{{ $data->ingredient->unit }}</small>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Data Not found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Ingredient</th>
                                                <th>qty</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="float-right mt-3">
                                    {!! $dish->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Information of product</h5>
                            </div>
                            <div class="card-body">
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="card-img-top"
                                        style="height: 200px; object-fit: cover;"
                                        onerror="this.onerror=null; this.src='{{ asset('home2/assets/img/sample.png') }}';">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                        style="height: 200px;">
                                        <span class="badge badge-danger">No Image</span>
                                    </div>
                                @endif
                                <table class="table table-borderless">
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Price</b></td>
                                        <td>Rp {{ number_format($product->price) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- modal ingredient --}}
    <div class="modal fade" id="addIngredientModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('ingredient-dish.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add ingredient to list</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="{{ $product->id }}" name="id_product">
                        <div class="form-group">
                            <label>Select Ingredient</label>
                            <select class="form-control select2  @error('id_ingredient') is-invalid @enderror"
                                name="id_ingredient">

                                @foreach ($ingredient as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }} / {{ $data->unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" step="0.01" min="0"
                                class="form-control @error('qty') is-invalid @enderror" name="qty"
                                value="{{ old('qty') ?? 0 }}">
                                <small class="text-mutted">for decimal example = 0.5 not 0,5</small>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add to list</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi select2 pada modal ketika modal dibuka
            $('#addIngredientModal').on('shown.bs.modal', function() {
                $(this).find('.select2').select2({
                    dropdownParent: $('#addIngredientModal'),
                    width: '100%',
                    placeholder: 'Select an ingredient'
                });
            });
        });
    </script>
@endpush
