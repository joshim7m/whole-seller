<?php

namespace App\Http\Controllers\StoreFront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InstagramImage;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class StorefrontController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();

        $featured = Product::where('status', 'active')->where('featured', true)
            ->with('category', 'images')->latest()->take(10)->get();

        $remaining = 10 - $featured->count();
        $latest = collect();
        if ($remaining > 0) {
            $latest = Product::where('status', 'active')->where('featured', false)
                ->with('category', 'images')->latest()->take($remaining)->get();
        }

        $products = $featured->concat($latest);

        $newArrivals = Product::where('status', 'active')
            ->with('images')
            ->latest()
            ->take(10)
            ->get();

        $instagramImages = InstagramImage::latest()->take(6)->get();

        return Inertia::render('StoreFront/Home/Index', compact('categories', 'products', 'newArrivals', 'instagramImages'));
    }

    public function categories()
    {
        $categories = Category::withCount(['products' => function ($q) {
            $q->where('status', 'active');
        }])->get();

        return Inertia::render('StoreFront/Categories/Index', compact('categories'));
    }

    public function category(Request $request, Category $category)
    {
        $category->load('children', 'parent');

        $categoryIds = $category->children->pluck('id')->push($category->id)->values();

        $query = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'active')
            ->with('images', 'variants');

        $query = $this->applyFilters($request, $query);
        $query = $this->applySort($request, $query);

        $products = $query->paginate(12)->withQueryString();

        $filters = $this->getFilterOptions($request);

        return Inertia::render('StoreFront/Categories/Show', compact('category', 'products', 'filters'));
    }

    public function products(Request $request)
    {
        $query = Product::where('status', 'active')
            ->with('images', 'variants', 'category');

        $query = $this->applyFilters($request, $query);
        $query = $this->applySort($request, $query);

        $products = $query->paginate(12)->withQueryString();

        $filters = $this->getFilterOptions($request);

        return Inertia::render('StoreFront/Products/Index', compact('products', 'filters'));
    }

    public function newArrivals(Request $request)
    {
        $query = Product::where('status', 'active')
            ->with('images', 'variants', 'category');

        if ($request->get('sort')) {
            $query = $this->applySort($request, $query);
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return Inertia::render('StoreFront/NewArrivals', compact('products'));
    }

    public function hotSale()
    {
        $products = Product::where('status', 'active')
            ->with('images', 'variants', 'category')
            ->orderBy('featured', 'desc')
            ->latest()
            ->take(20)
            ->get();

        return Inertia::render('StoreFront/HotSale', compact('products'));
    }

    public function product(Product $product)
    {
        $product->load('category', 'images', 'variants.image');

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->with('images')
            ->take(4)
            ->get();

        return Inertia::render('StoreFront/Products/Show', compact('product', 'related'));
    }

    public function searchProductsAjax(Request $request)
    {
        $q = $request->get('q');
        if (! $q || strlen($q) < 2) {
            return response()->json([]);
        }

        $products = Product::where('status', 'active')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%");
            })
            ->with('variants')
            ->take(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'sale_price' => $product->sale_price,
                    'unit_price' => $product->unit_price,
                    'image' => $product->image_url,
                    'variants' => $product->variants->map(function ($v) {
                        return [
                            'id' => $v->id,
                            'size' => $v->size,
                            'color' => $v->color,
                            'quantity' => $v->quantity,
                        ];
                    }),
                ];
            });

        return response()->json($products);
    }

    public function cart()
    {
        return Inertia::render('StoreFront/Cart/Index');
    }

    public function profile()
    {
        return Inertia::render('StoreFront/UserProfile/Profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'mobile' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:2000',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'mobile' => $validated['mobile'],
                'company' => $validated['company'],
                'address' => $validated['address'],
            ]
        );

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    private function applyFilters(Request $request, $query)
    {
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('sale_price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('sale_price', '<=', (int) $request->max_price);
        }

        if ($request->filled('categories')) {
            $cats = (array) $request->categories;
            $query->whereIn('category_id', $cats);
        }

        if ($request->filled('sizes')) {
            $sizes = (array) $request->sizes;
            $query->whereHas('variants', function ($q) use ($sizes) {
                $q->whereIn('size', $sizes)->where('quantity', '>', 0);
            });
        }

        if ($request->filled('colors')) {
            $colors = (array) $request->colors;
            $query->whereHas('variants', function ($q) use ($colors) {
                $q->whereIn('color', $colors)->where('quantity', '>', 0);
            });
        }

        return $query;
    }

    private function applySort(Request $request, $query)
    {
        return match ($request->sort) {
            'price_asc' => $query->orderBy('sale_price'),
            'price_desc' => $query->orderByDesc('sale_price'),
            'name_asc' => $query->orderBy('title'),
            'name_desc' => $query->orderByDesc('title'),
            'oldest' => $query->orderBy('created_at'),
            default => $query->latest(),
        };
    }

    private function getFilterOptions(Request $request)
    {
        $categories = Category::whereHas('products', function ($q) {
            $q->where('status', 'active');
        })->withCount(['products' => function ($q) {
            $q->where('status', 'active');
        }])->get();

        $prices = Product::where('status', 'active')
            ->selectRaw('MIN(sale_price) as min_price, MAX(sale_price) as max_price')
            ->first();

        $sizes = ProductVariant::whereHas('product', function ($q) {
            $q->where('status', 'active');
        })->whereNotNull('size')->where('size', '!=', '')
            ->selectRaw('size, SUM(quantity) as total_qty')
            ->groupBy('size')
            ->having('total_qty', '>', 0)
            ->orderBy('size')
            ->pluck('size')
            ->toArray();

        $colors = ProductVariant::whereHas('product', function ($q) {
            $q->where('status', 'active');
        })->whereNotNull('color')->where('color', '!=', '')
            ->selectRaw('color, SUM(quantity) as total_qty')
            ->groupBy('color')
            ->having('total_qty', '>', 0)
            ->orderBy('color')
            ->pluck('color')
            ->toArray();

        return compact('categories', 'prices', 'sizes', 'colors');
    }
}
