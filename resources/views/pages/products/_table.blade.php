<div class="mb-3">
    <ul class="nav nav-pills" id="myTab3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="table-tab" data-toggle="tab" href="#table" role="tab" aria-controls="table"
                aria-selected="true"><i class="fa fa-list"></i> List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list"
                aria-selected="false"><i class="fa fa-table"></i> Card</a>
        </li>
    </ul>
</div>

<div class="tab-content" id="viewTab">
    <!-- TAB TABLE -->
    <div class="tab-pane fade show active table-responsive" id="table" role="tabpanel" aria-labelledby="table-tab">
        <table class=" table table-sm table-hover">
            <tr class="bg-light">
                <th>No</th>
                <th>Photo</th>
                <th>Name</th>
                <th>HPP</th>
                <th>Price</th>
                <th>Discount</th>
                @if (!empty($setting) && $setting->ingredient)
                    <th>Ingredient</th>
                @endif
                <th>Status</th>
                <th>{{ __('general.action') }}</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="width: 110px;">
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" alt=""
                                style="width:100px; height:80px; object-fit:cover; cursor:pointer" class="img-thumbnail"
                                data-toggle="modal" data-target="#imageModal" data-image="{{ asset($product->image) }}"
                                onerror="this.onerror=null; this.src='{{ asset('home2/assets/img/sample.png') }}';">
                        @else
                            <span class="badge badge-danger">No Image</span>
                        @endif
                    </td>
                    <td>
                        <strong class="text-primary">{{ $product->name }}</strong><br>
                        {{ $product->category->name ?? '-' }}
                    </td>
                    <td>Rp {{ number_format($product->hpp, 0, ',', '.') }}</td>
                    <td>
                        @if ($product->discount != 0)
                            <del class="text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</del><br>
                            <strong class="text-success">Rp
                                {{ number_format($product->price_final, 0, ',', '.') }}</strong>
                        @else
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="text-center">
                        <strong class="text-warning">{{ $product->discount }} %</strong>
                        <button class="btn btn-sm text-warning" data-toggle="modal"
                            data-target="#discountModal{{ $product->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                    @if (!empty($setting) && $setting->ingredient)
                        <td class="font-weight-bold text-primary ">
                            {{ App\Models\IngredientDish::where('id_product', $product->id)->count() }}</td>
                    @endif
                    <td>
                        <span class="badge badge-{{ $product->status == 1 ? 'success' : 'warning' }}">
                            {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if (!empty($setting) && $setting->ingredient)
                                <a href="{{ route('products.ingredient', $product->id) }}"
                                    class="btn btn-sm btn-success d-flex align-items-center mr-2">
                                    <i class="fas fa-cookie-bite"> </i> {{ __('general.ingredient') }}
                                </a>
                            @endif
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="btn btn-sm btn-warning d-flex align-items-center mr-2">
                                <i class="fas fa-edit"></i> {{ __('general.edit') }}
                            </a>

                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- TAB LIST -->
    <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
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

                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text mb-2">
                                <strong>Kategori:</strong> {{ $product->category->name ?? '-' }}<br>
                                <strong>Harga:</strong> Rp{{ number_format($product->price, 0, ',', '.') }}<br>
                                <span class="badge badge-{{ $product->status ? 'success' : 'warning' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                            <div class="d-flex flex-wrap gap-1 text-center">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        @if (!empty($setting) && $setting->ingredient)
                                            <a href="{{ route('products.ingredient', $product->id) }}"
                                                class="btn btn-success">
                                                <i class="fas fa-cookie-bite"></i> {{ __('general.ingredient') }}
                                            </a>
                                        @endif
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> {{ __('general.edit') }}
                                        </a>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- PAGINATION -->
<div class="float-right mt-3">
    {!! $products->withQueryString()->links() !!}
</div>
