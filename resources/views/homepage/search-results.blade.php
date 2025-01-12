@extends('layouts.home')

@section('content')
<div class="container mt-4">
    <h2>Search Results for "{{ $query }}"</h2>
    <p>{{ $products->total() }} results found.</p>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
    
                        @php
                            $shop = $shops->firstWhere('user_id', $product->user_id);
                        @endphp
    
                        @if($shop)
                            <p class="card-text"><strong>Shop:</strong> {{ $shop->name }}</p>
                            <p class="card-text">Price: {{ number_format($product->price, 2) }}</p>
                            <a href="{{ route('shop.details', $shop->slug) }}" class="btn btn-primary">View Shop</a>
                        @else
                            <p class="text-muted">Shop not found</p>
                            <p class="card-text">Price: {{ number_format($product->price, 2) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No products found.</p>
            </div>
        @endforelse
    </div>    

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
