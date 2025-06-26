@extends('layouts.app')

@section('title', 'Edit Blog')
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
@endpush
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Blog</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin-blogs.update', $blog->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" value="{{ $blog->title }}" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea id="content" name="content" rows="10" class="form-control">{{ old('content', $blog->content ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Current Thumbnail</label><br>
                                @if ($blog->thumbnail)
                                    <img src="{{ asset('storage/' . $blog->thumbnail) }}" width="150">
                                @else
                                    <p>No thumbnail uploaded</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Change Thumbnail (optional)</label>
                                <input type="file" name="thumbnail" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Published?</label>
                                <select name="is_published" class="form-control">
                                    <option value="1" {{ $blog->is_published ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$blog->is_published ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin-blogs.index') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                placeholder: 'Write blog content here...',
                tabsize: 2,
                height: 400,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
@endpush
