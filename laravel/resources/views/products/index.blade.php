<!DOCTYPE html>
<html lang="ru" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Auto Parts Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
</head>
<body class="bg-gray-900 text-gray-100 p-8 font-sans min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-white">Каталог Автозапчастей</h1>
        
        <!-- Форма поиска и фильтров -->
        <form method="GET" action="/" class="mb-6 flex flex-wrap gap-4 bg-gray-800 p-4 rounded-lg shadow-lg">
            <input type="text" name="search" value="{{ $search }}" placeholder="Поиск по названию..." 
                   class="bg-gray-700 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            
            <select name="category" class="bg-gray-700 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Все категории</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded font-semibold transition">Найти</button>
            <a href="/" class="bg-gray-600 hover:bg-gray-500 px-6 py-2 rounded font-semibold transition">Сбросить</a>
        </form>

        <div class="mb-6 p-4 bg-gray-800 border border-gray-700 rounded-lg shadow-md flex justify-between items-center">
            <span>Время выполнения: <strong class="text-blue-400">{{ $time }} ms</strong></span>
            <span class="text-sm text-gray-400">Показано 50 товаров (Кэш Redis)</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-gray-800 p-5 rounded-lg shadow-lg border border-gray-700 flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-white mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-400 text-sm mb-4">{{ $product->description }}</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-400 mb-2">{{ number_format($product->price, 0, '.', ' ') }} ₽</p>
                        <p class="text-sm text-gray-400 mb-3">Склад: {{ $product->warehouse->name }}</p>
                        
                        <!-- Проверка на наличие -->
                        @if($product->stock_quantity > 0)
                            <span class="inline-block bg-green-900 text-green-300 px-3 py-1 rounded text-sm">В наличии: {{ $product->stock_quantity }} шт.</span>
                        @else
                            <span class="inline-block bg-red-900 text-red-300 px-3 py-1 rounded text-sm">Нет в наличии</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-12">По вашему запросу ничего не найдено.</div>
            @endforelse
        </div>
    </div>
</body>
</html>