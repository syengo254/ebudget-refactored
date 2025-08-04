<?php

namespace App\Services;

use App\Enums\StockUpdateType;
use App\Exceptions\ProductStockException;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Collection;

class ProductService
{
    public function updateStockAmount(Product $product, int $amount, StockUpdateType $updateType = StockUpdateType::ADD)
    {
        if ($updateType === StockUpdateType::ADD) {
            $product->stock_amount = $product->stock_amount + $amount;
        } else {
            if ($product->stock_amount < $amount) {
                throw new ProductStockException("Stock amount for '{$product->name}' is below the requested product amount '{$amount}'!");
            }

            $product->stock_amount = $product->stock_amount - $amount;
        }

        $product->save();
    }

    public function getProductsById(array|Collection $productIds)
    {
        return Product::whereIn('id', $productIds)->get();
    }

    public function createProduct(Store $store, array $attributes): Product
    {
        $product = Product::create([
            'name' => $attributes['name'],
            'price' => $attributes['price'],
            'image' => '',
            'stock_amount' => $attributes['stock'],
            'category_id' => $attributes['category'] ?? 1,
            'store_id' => $store->id,
        ]);

        $path = $attributes['image']->store('product-images');
        $product->image = $path;
        $product->save();

        return $product;
    }
}
