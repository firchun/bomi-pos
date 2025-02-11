<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mb-4">
                <div class="section-title text-center">
                    <p class="text-purple text-uppercase fw-bold mb-3">Explore Our Comment & Rating</p>
                    <h1>Share Your Feedback</h1>
                </div>

                <!-- Formulir Rating dan Komentar -->
                <div class="mt-5">
                    <form action="{{ route('shop.rate', $shop->slug) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment" id="comment" rows="4" class="form-control" placeholder="Write your comment..."></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star star" data-rating="{{ $i }}"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating" />
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Daftar Komentar -->
                <div class="mt-5" id="ratings-container">
                    {{-- {{ Javascript Content }} --}}
                </div>
                <div id="comment-pagination" class="d-flex justify-content-center mt-4"></div>
            </div>
        </div>
    </div>
</section>
