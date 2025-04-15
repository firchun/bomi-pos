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
                            data-toggle="modal" data-target="#imageModal" data-image="{{ asset($product->image) }}">
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
                    <div class="d-flex form-group">
                        <a href='{{ route('products.edit', $product->id) }}' class="btn btn-sm btn-warning ">
                            <i class="fas fa-edit"></i>
                            {{ __('general.edit') }}
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="ml-2"
                            onsubmit="return confirm('Are you sure you want to delete this product? If you proceed, all related data will be permanently deleted.');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> {{ __('general.delete') }}
                            </button>
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
