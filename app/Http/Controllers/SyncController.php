<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Discount;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use App\Models\IngredientDish;
use App\Models\LocalServerToken;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{

    public function syncUsersWithCloud(Request $request)
    {
        $userId = Auth::id(); // atau ambil dari token lokal jika tanpa login

        $data = [
            'users' => User::where('id', $userId)->get(),
            'products' => Product::where('user_id', $userId)->get(),
            'orders' => Order::where('user_id', $userId)->get(),
            'order_items' => OrderItem::whereHas('order', fn($q) => $q->where('user_id', $userId))->get(),
            'ads' => Ads::where('user_id', $userId)->get(),
            'discounts' => Discount::where('user_id', $userId)->get(),
            'ingredient_categories' => IngredientCategory::where('user_id', $userId)->get(),
            'ingredient_dish' => IngredientDish::where('user_id', $userId)->get(),
            'ingredients' => Ingredient::where('user_id', $userId)->get(),
            'notifications' => Notification::where('user_id', $userId)->get(),
            'visitors' => Visitor::where('user_id', $userId)->get(),
            'migrations' => DB::table('migrations')->get(), // tidak pakai user_id
        ];

        Http::post('https://cloud.bomipos.com/api/upload-data', $data);
        Http::post(config('app.server') . '/api/upload-data', $data);

        // Ambil dari cloud
        $response = Http::withToken('TOKENMU')->get(config('app.server') . '/api/download-data');
        $cloudData = $response->json();

        foreach ($cloudData as $table => $rows) {
            foreach ($rows as $row) {
                $modelClass = '\\App\\Models\\' . Str::studly(Str::singular($table));
                $key = in_array($table, ['users', 'migrations']) ? 'email' : 'id';
                $data = collect($row)->only((new $modelClass)->getFillable())->toArray();
                $modelClass::updateOrCreate([$key => $row[$key]], $data);
            }
        }

        return response()->json(['message' => 'Sinkronisasi berhasil']);
    }
    public function uploadData(Request $request)
    {
        $tokenValue = $request->header('Authorization');
        $token = LocalServerToken::where('token', $tokenValue)->where('active', true)->first();

        if (! $token) {
            return response()->json(['status' => 'error', 'message' => 'Token tidak valid'], 401);
        }

        $userId = $token->user_id;

        foreach ($request->all() as $table => $rows) {
            foreach ($rows as $row) {
                $modelClass = '\\App\\Models\\' . Str::studly(Str::singular($table));
                $key = in_array($table, ['users', 'migrations']) ? 'email' : 'id';
                $data = collect($row)->only((new $modelClass)->getFillable())->toArray();
                $data['user_id'] = $userId; // overwrite agar tidak disalahgunakan
                $modelClass::updateOrCreate([$key => $row[$key]], $data);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Data uploaded']);
    }
    // Endpoint cloud
    public function downloadData(Request $request)
    {
        $tokenValue = $request->header('Authorization');
        $token = \App\Models\LocalServerToken::where('token', $tokenValue)->where('active', true)->first();

        if (! $token) {
            return response()->json(['status' => 'error', 'message' => 'Token tidak valid'], 401);
        }

        $userId = $token->user_id;

        return response()->json([
            'users' => User::where('id', $userId)->get(),
            'products' => Product::where('user_id', $userId)->get(),
            'orders' => Order::where('user_id', $userId)->get(),
            'order_items' => OrderItem::whereHas('order', fn($q) => $q->where('user_id', $userId))->get(),
            'ads' => Ads::where('user_id', $userId)->get(),
            'discounts' => Discount::where('user_id', $userId)->get(),
            'ingredient_categories' => IngredientCategory::where('user_id', $userId)->get(),
            'ingredient_dish' => IngredientDish::where('user_id', $userId)->get(),
            'ingredients' => Ingredient::where('user_id', $userId)->get(),
            'notifications' => Notification::where('user_id', $userId)->get(),
            'visitors' => Visitor::where('user_id', $userId)->get(),
            'migrations' => DB::table('migrations')->get()
        ]);
    }
}
