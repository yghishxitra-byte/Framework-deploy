<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Собираем параметры поиска
        $search = $request->input('search');
        $category = $request->input('category');
        
        // 2. Формируем УНИКАЛЬНЫЙ ключ для кэша на основе фильтров
        $cacheKey = 'products.' . md5(json_encode($request->all()));

        $start = microtime(true);

        // 3. Кэшируем результат
        $products = Cache::remember($cacheKey, 60, function () use ($search, $category) {
            $query = Product::with('warehouse')->take(50); // Берем только 50 для скорости фронта!

            if ($search) {
                $query->where('name', 'ILIKE', '%' . $search . '%');
            }
            if ($category) {
                $query->where('category_id', $category);
            }

            return $query->get();
        });

        $time = round((microtime(true) - $start) * 1000, 2);
        $categories = Cache::remember('categories.all', 3600, fn() => \App\Models\Category::all());

        return view('products.index', compact('products', 'time', 'categories', 'search', 'category'));
    }
}