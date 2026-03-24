<?php

namespace App\Services\Admin;

use App\Models\ProductIngredient;
use Illuminate\Support\Facades\DB;

class ProductIngredientService
{
    public function syncForProduct(int $productId, array $rows): void
    {
        DB::transaction(function () use ($productId, $rows) {
            ProductIngredient::where('product_id', $productId)->delete();

            if (empty($rows)) {
                return;
            }

            $payload = [];
            foreach ($rows as $row) {
                $payload[] = [
                    'product_id' => $productId,
                    'ingredient_id' => (int) $row['ingredient_id'],
                    'qty' => (float) $row['qty'],
                ];
            }

            ProductIngredient::insert($payload);
        });
    }
}

