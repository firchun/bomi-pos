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
                 <h1>Product</h1>
                 <div class="section-header-button">
                     <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New
                         Product</a>
                 </div>
                 <div class="section-header-breadcrumb">
                     <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                     <div class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></div>
                     <div class="breadcrumb-item">All Products</div>
                 </div>
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

                                 <div class="clearfix mb-3"></div>

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
                     <img id="modal-image" src="" alt="Preview" class="img-fluid rounded">
                 </div>
             </div>
         </div>
     </div>
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

 )
