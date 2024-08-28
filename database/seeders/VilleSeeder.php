<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['nom' => 'طنجة', 'price' => 25.00],
            ['nom' => 'الرباط', 'price' => 40.00],
            ['nom' => 'الدار البيضاء', 'price' => 40.00],
            ['nom' => 'فاس', 'price' => 40.00],
            ['nom' => 'مراكش', 'price' => 40.00],
            ['nom' => 'أكادير', 'price' => 40.00],
            ['nom' => 'تطوان', 'price' => 40.00],
            ['nom' => 'وجدة', 'price' => 40.00],
            ['nom' => 'الصويرة', 'price' => 40.00],
            ['nom' => 'الحسيمة', 'price' => 40.00],
            ['nom' => 'مدينة أخرى', 'price' => 40.00],
        ];

        foreach ($cities as $city) {
            Ville::firstOrCreate(
                ['nom' => $city['nom']], // Matching criteria
                ['price' => $city['price']] // Data to insert
            );
        }
    }
}
