 @extends('layouts.app')

 @section('title', 'Products')

 @push('style')
     <!-- CSS Libraries -->
     <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
 @endpush

 @section('main')
     <div class="main-content">
         <section class="section">
             <div class="section-header">
                 <h1><i class="fa fa-folder"></i> Product</h1>

                 <div class="section-header-breadcrumb">
                     <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                     <div class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></div>
                     <div class="breadcrumb-item">All Products</div>
                 </div>
             </div>
             <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                 @if (app()->getLocale() == 'en')
                     Add New Product
                 @else
                     Tambah produk baru
                 @endif
             </a>
             <div class="my-2 p-2 border rounded bg-light text-dark">
                 @if (app()->getLocale() == 'en')
                     You can add a product by clicking the ‘Add New Product’ button, and don’t forget to assign the
                     ingredients by clicking the ‘Ingredients’ button. You can also edit the product if there are any
                     changes or delete it if it’s no longer needed.
                 @else
                     Anda dapat menambahkan produk dengan mengklik tombol 'Tambah Produk Baru', dan jangan lupa untuk
                     menetapkan bahan-bahannya dengan mengklik tombol 'Bahan'. Anda juga dapat mengedit produk jika ada
                     perubahan atau menghapusnya jika sudah tidak diperlukan.
                 @endif
             </div>
             <div class="section-body">
                 <div class="row">
                     <div class="col-12">
                         @include('layouts.alert')

                     </div>
                 </div>


                 <div class="row mt-4">
                     <div class="col-12">
                         <div class="card">

                             <div class="card-body">

                                 <div class="float-right">
                                     <form id="search-form" method="GET" action="{{ route('products.index') }}">
                                         <div class="input-group">
                                             <input type="search" class="form-control" placeholder="Search" name="name"
                                                 id="search-input">
                                             <div class="input-group-append">
                                                 <button class="btn btn-primary" type="button"><i
                                                         class="fas fa-search"></i></button>
                                             </div>
                                         </div>
                                     </form>
                                 </div>


                                 <!-- Table wrapper -->
                                 <div id="product-table-wrapper">
                                     @include('pages.products._table', ['products' => $products])
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
     </div>
     {{-- modal image --}}
     <!-- Modal for Image Preview -->
     <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
         aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                 <div class="modal-body text-center">
                     <img id="modal-image" src="" alt="Preview" class="img-fluid rounded"
                         onerror="this.onerror=null; this.src='{{ asset('home2/assets/img/sample.png') }}';">
                 </div>
             </div>
         </div>
     </div>
     <!-- MODAL -->
     @foreach ($products as $product)
         <div class="modal fade" id="discountModal{{ $product->id }}" tabindex="-1" role="dialog"
             aria-labelledby="discountModalLabel{{ $product->id }}" aria-hidden="true">
             <div class="modal-dialog modal-sm" role="document">
                 <form action="{{ route('products.updateDiscount') }}" method="POST">
                     @csrf
                     @method('POST')
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title">Discount : {{ $product->name }}</h5>

                         </div>
                         <div class="modal-body">
                             <input type="hidden" name="product_id" value="{{ $product->id }}">
                             <div class="form-group">
                                 <label for="discount">Discount (%)</label>
                                 <input type="number" min="0" max="100" class="form-control" name="discount"
                                     value="{{ $product->discount }}" required>
                             </div>
                             <div class="d-flex justify-content-center gap-3">
                                 <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                                 <button type="submit" class="btn btn-primary">Simpan</button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     @endforeach
 @endsection

 @push('scripts')
     <script>
         function fetchProducts(url = '{{ route('products.index') }}') {
             const keyword = $('#search-input').val();
             $.ajax({
                 url: url,
                 method: 'GET',
                 data: {
                     name: keyword
                 },
                 success: function(response) {
                     $('#product-table-wrapper').html(response);
                 },
                 error: function() {
                     alert('Failed to load data.');
                 }
             });
         }

         $(document).ready(function() {
             let searchTimeout;

             $('#search-input').on('keyup', function() {
                 clearTimeout(searchTimeout); // clear timeout sebelumnya
                 searchTimeout = setTimeout(function() {
                     fetchProducts();
                 }, 100);
             });

             // Pagination click (delegated)
             $(document).on('click', '.pagination a', function(e) {
                 e.preventDefault();
                 const url = $(this).attr('href');
                 fetchProducts(url);
             });

             // Modal image handler
             $('#imageModal').on('show.bs.modal', function(event) {
                 var button = $(event.relatedTarget);
                 var imageSrc = button.data('image');
                 $(this).find('#modal-image').attr('src', imageSrc);
             });
         });
     </script>
     <!-- JS Libraies -->
     <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

     <!-- Page Specific JS File -->
     <script src="{{ asset('js/page/features-posts.js') }}"></script>
 @endpush
