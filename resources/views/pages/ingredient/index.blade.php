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
                                    <div class="nav-link active"><i class="fa fa-folder"></i>
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

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Unit</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ingredient as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td><b>{{$data->qty .' '. $data->sub_unit .' /'.$data->unit}}</b></td>
                                                    <td class="text-primary">
                                                        <div class="p-2"><i class="fa-regular fa-folder"></i>
                                                            {{ $data->category->category }}</div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning"
                                                            data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </button>
                                                        <a href="{{ route('ingredient.destroy', $data->id) }}"
                                                            onclick="event.preventDefault(); 
                                                                            if(confirm('Are you sure you want to delete this data?')) {
                                                                                document.getElementById('delete-ingredient-{{ $data->id }}').submit();
                                                                            }"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash m-1"></i> {{ __('general.delete') }}
                                                        </a>
                                                        <form id="delete-ingredient-{{ $data->id }}"
                                                            action="{{ route('ingredient.destroy', $data->id) }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
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
    {{-- modal edit --}}
    @foreach ($ingredient as $data)
        <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('ingredient.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">Edit Ingredient</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ $data->name }}"
                                    placeholder="name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Unit</label>
                                <input type="text" name="unit"
                                    class="form-control @error('unit') is-invalid @enderror" value="{{ $data->unit }}"
                                    placeholder="unit : Pack/Dos/Cartoon" required>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="p-2 bg-light border rounded mt-2">
                                    @if (app()->getLocale() == 'en')
                                        Example: <strong>kg</strong>, <strong>liter</strong>, <strong>pcs</strong> — this is the main unit used for purchasing ingredients.
                                    @else
                                        Contoh: <strong>kg</strong>, <strong>liter</strong>, <strong>pcs</strong> — ini adalah satuan utama untuk pembelian bahan.
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Qty Sub Unit</label>
                                        <input type="number" name="qty"
                                            class="form-control @error('qty') is-invalid @enderror" value="{{ $data->qty }}"
                                             required>
                                        @error('qty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="p-2 bg-light border rounded mt-2">
                                            @if (app()->getLocale() == 'en')
                                                Example: <strong>12</strong> — means 1 <em>unit</em> contains 12 <em>sub-units</em>.
                                            @else
                                                Contoh: <strong>12</strong> — berarti 1 <em>unit</em> berisi 12 <em>sub unit</em>.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">

                                    <div class="form-group">
                                        <label for="name">Sub Unit</label>
                                        <input type="text" name="sub_unit"
                                            class="form-control @error('sub_unit') is-invalid @enderror" value="{{ $data->sub_unit }}"
                                            placeholder="sub unit : pcs/cup" required>
                                        @error('sub_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="p-2 bg-light border rounded mt-2">
                                            @if (app()->getLocale() == 'en')
                                                Example: <strong>pcs</strong>, <strong>cup</strong> — the smallest unit used in the kitchen.
                                            @else
                                                Contoh: <strong>pcs</strong>, <strong>cup</strong> — satuan terkecil yang digunakan di dapur.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Select Category</label>
                                <select class="form-control" name="id_category">
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}"
                                            @if ($cat->id == $data->id_category) selected @endif>{{ $cat->category }}</option>
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
    @endforeach
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
                                class="form-control @error('category') is-invalid @enderror"
                                value="{{ old('category') }}" placeholder="name category" required>
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
    <div class="modal fade" id="addIngredientModal" tabindex="-1" role="dialog"
        aria-labelledby="addCategoryModalLabel" aria-hidden="true">
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
                                value="{{ old('unit') }}" placeholder="unit : Pack/Dos/Cartoon"" required>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="p-2 bg-light border rounded mt-2">
                                @if (app()->getLocale() == 'en')
                                    Example: <strong>kg</strong>, <strong>liter</strong>, <strong>pcs</strong> — this is the main unit used for purchasing ingredients.
                                @else
                                    Contoh: <strong>kg</strong>, <strong>liter</strong>, <strong>pcs</strong> — ini adalah satuan utama untuk pembelian bahan.
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Qty Sub Unit</label>
                                    <input type="number" name="qty"
                                        class="form-control @error('qty') is-invalid @enderror"
                                        value="0" required>
                                    @error('qty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="p-2 bg-light border rounded mt-2">
                                        @if (app()->getLocale() == 'en')
                                            Example: <strong>12</strong> — means 1 <em>unit</em> contains 12 <em>sub-units</em>.
                                        @else
                                            Contoh: <strong>12</strong> — berarti 1 <em>unit</em> berisi 12 <em>sub unit</em>.
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">

                                <div class="form-group">
                                    <label for="name">Sub Unit</label>
                                    <input type="text" name="sub_unit"
                                        class="form-control @error('sub_unit') is-invalid @enderror"
                                        placeholder="sub unit : pcs/cup" required>
                                    @error('sub_unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="p-2 bg-light border rounded mt-2">
                                        @if (app()->getLocale() == 'en')
                                            Example: <strong>pcs</strong>, <strong>cup</strong> — the smallest unit used in the kitchen.
                                        @else
                                            Contoh: <strong>pcs</strong>, <strong>cup</strong> — satuan terkecil yang digunakan di dapur.
                                        @endif
                                    </div>
                                </div>
                            </div>
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
