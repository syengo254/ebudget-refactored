<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\ProductViewResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request, int $page = 1, int $limit = 12)
    {
        $limit = request()->limit ?? $limit;

        // if (!(request()->category || request()->price || request()->store )) {
        //     return ProductViewResource::collection(Product::with("store", "category")->latest()->paginate($limit));
        // }

        $products = Product::query();

        if ($request->filled('q')) {
            $products->where("name", "LIKE", "%" . $request->q . "%");
            $products->orWhereHas("category", function (Builder $query) use ($request) {
                $query->where("name", "LIKE", "%{$request->q}%");
            });
            $products->orWhereHas("store", function (Builder $query) use ($request) {
                $query->where("name", "LIKE", "%{$request->q}%");
            });
        } else {
            $request->filled('category') && $products->whereHas("category", function (Builder $query) use ($request) {
                $query->where("name", "LIKE", "%{$request->category}%");
            });

            $request->filled('store') && $products->whereHas("store", function (Builder $query) use ($request) {
                $query->where("name", "LIKE", "%{$request->store}%");
            });

            $request->filled('price') && $products->where("price", "<=", intval($request->price));
        }

        return ProductViewResource::collection($products->latest()->paginate($limit));
    }


    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();
        $store = $user->store;
        $product = NULL;

        $res = DB::transaction(function () use ($validated, $store, &$product) {
            $category = NULL;

            if(request()->filled("categoryname")){
                $category = Category::firstOrCreate([
                    "name" => strtolower($validated["categoryname"]),
                ]);
            }
            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                "image" => '',
                'stock_amount' => $validated['stock'],
                'category_id' => $category ? $category->id : $validated['category'] ?? 1,
                'store_id' => $store->id,
            ]);
    
            $path = $validated["image"]->store('product-images');
            $product->image = $path;
            $product->save();
        });

        return response()->json( [
            "success" => boolval($product),
            "message" => boolval($product) ? "Product added." : "Failed to add product. Try again.",
            "product" => $product,
            "extra" => $res,
        ], boolval($product) ? 201 : 500);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
