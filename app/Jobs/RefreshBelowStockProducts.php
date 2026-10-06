<?php

namespace App\Jobs;

use App\Models\Ecommerce\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefreshBelowStockProducts
{
    /**
     * Refresh the cached list of products below their reorder point.
     */
    public function handle()
    {
        DB::transaction(function () {
            DB::table('below_stock_products')->delete();

            $rows = [];
            $products = Product::where('reorder_point', '>', 0)->get();

            foreach ($products as $product) {
                $inventory = $product->Inventory;

                if ($inventory <= $product->reorder_point) {
                    $rows[] = [
                        'product_id' => $product->id,
                        'reorder_point' => $product->reorder_point,
                        'inventory' => $inventory,
                    ];
                }
            }

            if (! empty($rows)) {
                DB::table('below_stock_products')->insert($rows);
            }

            Log::info('Below-stock products table refreshed.', [
                'inserted' => count($rows),
            ]);
        });
    }
}
