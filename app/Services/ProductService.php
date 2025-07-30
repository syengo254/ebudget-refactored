<?php

namespace App\Services;

use App\Enums\StockUpdateType;
use App\Exceptions\ProductStockException;
use App\Models\Product;
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
}
