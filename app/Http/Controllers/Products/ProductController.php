<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductViewResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $page = 1, int $limit = 8)
    {
        $limit = request()->limit ?? $limit;

        if (!(request()->category || request()->price || request()->store)) {
            return ProductViewResource::collection(Product::with("store", "category")->latest()->paginate($limit));
        }

        $products = Product::query();

        $request->category && $products->whereHas("category", function (Builder $query) use ($request) {
            $query->where("name", "LIKE", "%{$request->category}%");
        });

        $request->store && $products->whereHas("store", function (Builder $query) use ($request) {
            $query->where("name", "LIKE", "%{$request->store}%");
        });

        $request->price && $products->where("price", "<=", intval($request->price));

        return ProductViewResource::collection($products->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
