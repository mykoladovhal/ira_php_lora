<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            '博覧会',           // Exhibitions
            '見本市・展示会',    // Trade fairs
            '会議イベント',      // Conferences
            '文化イベント',      // Cultural events
            'スポーツイベント',  // Sports events
            '販促イベント',      // Promotional events
            'その他',           // Other
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
