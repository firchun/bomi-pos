<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $blog->title }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

        <!-- Gambar Header -->
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="Header Gambar"
                style="max-width: 100%; height: auto; border-radius: 6px;">
        </div>

        <h2 style="color: #af01ce;">{{ $blog->title }}</h2>

        <p style="font-size: 14px; color: #333333;">
            {!! \Illuminate\Support\Str::limit(strip_tags($blog->content), 150) !!}
        </p>

        <p style="text-align: center; margin-top: 30px;">
            <a href="{{ route('blog-detail', $blog->slug) }}"
                style="display: inline-block; background-color: #af01ce; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold;">
                Baca Selengkapnya
            </a>
        </p>

        <p style="font-size: 12px; color: #a700cd; margin-top: 40px;">
            Terimakasih, salam hangat dari kami<br>
            <strong>Tim Bomi POS</strong>
        </p>
    </div>
</body>

</html>
