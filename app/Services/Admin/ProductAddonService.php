<?php

namespace App\Services\Admin;

use App\Models\ProductAddon;
use Illuminate\Support\Facades\DB;

class ProductAddonService
{
    public function syncForProduct(int $productId, array $rows): void
    {
        DB::transaction(function () use ($productId, $rows) {
            ProductAddon::where('product_id', $productId)->delete();

            if (empty($rows)) {
                return;
            }

            $payload = [];
            foreach ($rows as $row) {
                $payload[] = [
                    'product_id' => $productId,
                    'addon_id' => (int) $row['addon_id'],
                ];
            }

            ProductAddon::insert($payload);
        });
    }
}

