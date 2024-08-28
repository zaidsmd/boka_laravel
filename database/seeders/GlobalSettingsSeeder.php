<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GlobalSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        GlobalSetting::firstOrCreate([
            'nom' => 'stock_operations',
            'label' => 'تفعيل المخزون',
            'valeur' => true,
        ]);
    }
}
