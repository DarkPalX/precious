<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Ecommerce\Deliverablecities;
use Illuminate\Support\Facades\DB;

class PhilippineLocationsSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('deliverable_cities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Fetch provinces
        $provincesRes = Http::get("https://psgc.gitlab.io/api/provinces/");
        $citiesRes    = Http::get("https://psgc.gitlab.io/api/cities-municipalities/");

        if (!$provincesRes->successful() || !$citiesRes->successful()) {
            $this->command->error('Failed to fetch PSGC data.');
            return;
        }

        $provinces = collect($provincesRes->json())->keyBy('code');
        $locations = $citiesRes->json();

        $batch = [];

        foreach ($locations as $loc) {

            $provinceName = optional($provinces->get($loc['provinceCode']))['name'] ?? null;

            $batch[] = [
                'name'          => $loc['name'],
                'rate'          => rand(100, 200),
                'area'          => null,
                'user_id'       => 1,
                'item_type'     => 'location',
                'outside_manila'=> $provinceName !== 'Metro Manila',
                'province'      => $provinceName,
                'city'          => $loc['isCity'] ? $loc['name'] : null,
                'municipality'  => !$loc['isCity'] ? $loc['name'] : null,
                'barangay'      => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            // batch insert every 500
            if (count($batch) >= 500) {
                Deliverablecities::insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            Deliverablecities::insert($batch);
        }

        $this->command->info('PH Cities & Municipalities seeded successfully!');
    }
}