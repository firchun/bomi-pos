<div class="table-responsive">
    <table class="table-striped table table-sm table-hover">
        <tr>
            <th>No</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Price</th>
            <th>Status</th>
            <th>{{ __('general.action') }}</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $loop->iteration }}
                </td>
                <td style="width: 110px;">
                    @if ($product->image)
                        <img src="{{ asset($product->image) }}" alt=""
                            style="width:100px; height:80px; object-fit:cover; cursor:pointer" class="img-thumbnail"
                            data-toggle="modal" data-target="#imageModal" data-image="{{ asset($product->image) }}" onerror="this.onerror=null; this.src='{{ asset('home2/assets/img/sample.png') }}';">
                    @else
                        <span class="badge badge-danger">No Image</span>
                    @endif
                </td>
                <td><strong class="text-primary">{{ $product->name }}</strong><br>{{ $product->category->name ?? '-' }}
                </td>
                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td><span
                        class="badge badge-{{ $product->status == 1 ? 'success' : 'warning' }}">{{ $product->status == 1 ? 'Active' : 'Inactive' }}</span>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <a href="" class="btn btn-sm btn-success d-flex align-items-center mr-2">
                            <i class="fas fa-cookie-bite "> </i> 
                          {{__('general.ingredient') }}
                        </a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning d-flex align-items-center mr-2">
                            <i class="fas fa-edit "></i>
                            {{ __('general.edit') }}
                        </a>
                        <a href="{{ route('products.destroy', $product->id) }}"
                           onclick="event.preventDefault(); 
                                    if(confirm('Are you sure you want to delete this product?')) {
                                        document.getElementById('delete-product-{{ $product->id }}').submit();
                                    }"
                           class="btn btn-sm btn-danger d-flex align-items-center">
                            <i class="fas fa-trash m-1"></i>
                            {{ __('general.delete') }}
                        </a>
                        <form id="delete-product-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</div>

<div class="float-right">
    {!! $products->withQueryString()->links() !!}
</div>
