<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\ProductViewResource;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;

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

        $products->where('is_deleted', '=', FALSE);

        return ProductViewResource::collection($products->latest()->paginate($limit));
    }


    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        if (Gate::denies('create', new Product)) {
            return response()->json([
                "success" => false,
                "message" => 'You are not authorised!',
                "product" => NULL,
            ], 403);
        }

        $user = auth()->user();
        $store = $user->store;
        $product = NULL;

        DB::transaction(function () use ($validated, $store, &$product) {
            $category = NULL;

            if (request()->filled("categoryname")) {
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

        return response()->json([
            "success" => boolval($product),
            "message" => boolval($product) ? "Product added." : "Failed to add product. Try again.",
            "product" => $product,
        ], boolval($product) ? 201 : 500);
    }

    public function show(Product $product)
    {
        return ProductViewResource::make($product);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:400',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            "image" => ["sometimes", File::types(["jpg", "jpeg", "png", "webp"])->min(2)->max(1024 * 5)],
            'category' => "sometimes|integer|min:1|exists:categories,id",
            'categoryname' => "sometimes|string|min:4",
            'id' => 'sometimes|exists:products,id',
            'imageHasChanged' => 'sometimes|boolean',
        ]);

        if (Gate::denies('update', $product)) {
            return response()->json([
                "success" => false,
                "message" => 'You are not authorised!',
            ], 403);
        }

        $success = false;

        DB::transaction(function () use ($validated, &$product, &$success) {
            $category = NULL;

            if (request()->filled("categoryname")) {
                $category = Category::firstOrCreate([
                    "name" => ucfirst($validated["categoryname"]),
                ]);
            }

            $success = $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'stock_amount' => $validated['stock'],
                'category_id' => $category ? $category->id : $validated['category'] ?? 1,
            ]);

            if ($success) {
                if (request()->has("image") && $validated["imageHasChanged"] == TRUE) {
                    $path = $validated["image"]->store('product-images');
                    $product->image = $path;
                    $product->save();
                }
            } else {
                throw new Exception("Could not update product image.");
            }
        });

        return response()->json([
            "success" => $success,
            "message" => $success ? "Product updated." : "Failed to add product. Try again.",
            "product" => $product,
        ], $success ? 201 : 500);
    }

    public function destroy(Product $product)
    {
        if (Gate::denies('delete', $product)) {
            return response()->json([
                "success" => false,
                "message" => 'You are not authorised!',
            ], 403);
        }

        $product->is_deleted = TRUE;
        $product->save();

        return response()->json([
            "success" => true,
            "message" => 'Product deleted!',
        ]);
    }
}
