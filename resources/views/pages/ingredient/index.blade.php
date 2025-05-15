@extends('layouts.app')

@section('title', $title ?? 'Ingredient ')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">{{ $title }}</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">{{ $title }}</h2>
                <div class="my-2 p-2 border rounded bg-light text-dark">
                    @if (app()->getLocale() == 'en')
                        You can add a new ingredient by clicking the ‘Add New Ingredient’ button. You can also edit the
                        ingredient if there are any changes, or delete it if it’s no longer needed.
                    @else
                        Anda dapat menambahkan bahan baku dengan mengklik tombol ‘Tambah Bahan Baku Baru’. Anda juga dapat
                        mengedit bahan baku jika ada perubahan, atau menghapusnya jika sudah tidak diperlukan.
                    @endif
                </div>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addCategoryModal">
                    <i class="fas fa-plus"></i> {{ __('general.add') }} {{ __('general.category') }}
                </button>
                <a href="{{ route('ingredient-category') }}" class="btn btn-outline-primary mb-2">
                    <i class="fas fa-box"></i> {{ __('general.all') }} {{ __('general.category') }}
                </a>
                <div class="card mb-0 flex-grow-1 me-3">
                    <div class="card-body py-2 px-3">
                        <ul class="nav nav-pills mb-0">
                            @foreach ($category as $cat)
                                <li class="nav-item mx-1">
                                    <div class="nav-link active">
                                        {{ $cat->category }} <span
                                            class="badge bg-white text-dark">{{ App\Models\Ingredient::where('id_category', $cat->id)->count() }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addIngredientModal">
                    <i class="fas fa-plus"></i> Add new Ingredient
                </button>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Ingredients</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Unit</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ingredient as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->unit }}</td>
                                                    <td>{{ $data->created_at->format('d F Y') }}</td>
                                                    <td>
                                                        <a href="" class="btn-sm btn btn-warning"><i
                                                                class="fa fa-edit"></i> Edit</a>
                                                        <a href="" class="btn-sm btn btn-danger"><i
                                                                class="fa fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right mt-3">
                                    {!! $ingredient->withQueryString()->links() !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- modal category --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('ingredient-category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name Category</label>
                            <input type="text" name="category"
                                class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}"
                                placeholder="name category" required>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- modal ingredient --}}
    <div class="modal fade" id="addIngredientModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('ingredient.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add new ingredient</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Unit</label>
                            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                                value="{{ old('unit') }}" placeholder="unit : kg/pcs/cup" required>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Select Category</label>
                            <select class="form-control" name="id_category">
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
