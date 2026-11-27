namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        // Замеряем время начала
        $start = microtime(true);

        // Пытаемся взять из Redis, если нет — идем в БД и кладем в Redis на 60 секунд
        $products = Cache::remember('products.all', 60, function () {
            return Product::all();
        });

        // Замеряем время окончания
        $time = round((microtime(true) - $start) * 1000, 2);

        return view('products.index', compact('products', 'time'));
    }
}