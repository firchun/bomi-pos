<?php

namespace App\Http\Controllers;

use App\Mail\BlogPublished;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Blog Management',
            'blogs' => Blog::orderBy('created_at', 'desc')->paginate(10)
        ];
        return view('pages.blog.index', $data);
    }
    public function create()
    {
        return view('pages.blog.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_published' => 'nullable|boolean'
        ]);

        $slug = Str::slug($request->title);
        if (Blog::where('slug', $slug)->exists()) {
            $slug .= '-' . uniqid();
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('blogs', 'public');
        }

        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'thumbnail' => $thumbnailPath,
            'user_id' => Auth::id(),
            'is_published' => $request->is_published ?? true,
            'views' => 0
        ]);
        $users = User::where('role', 'user')->whereNotNull('email')->get();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new BlogPublished($blog));
        }

        return redirect()->route('admin-blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog, $id)
    {
        $blog = Blog::findOrFail($id);
        return view('pages.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_published' => 'nullable|boolean'
        ]);
        $blog = Blog::findOrFail($id);

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('blogs', 'public');
            $blog->thumbnail = $thumbnailPath;
        }

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->is_published = $request->is_published ?? true;
        $blog->save();

        return redirect()->route('admin-blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog, $id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }
        $blog->delete();
        return redirect()->route('admin-blogs.index')->with('success', 'Blog deleted successfully.');
    }
}