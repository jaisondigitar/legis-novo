<?php

use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectors = [
            ['name' => 'Secretaria', 'external' => 0],
            ['name' => 'Gabinete', 'external' => 0],
            ['name' => 'Jurídico', 'external' => 0],
            ['name' => 'Externo', 'external' => 1],
        ];

        foreach ($sectors as $sector) {
            Sector::firstOrCreate(['name' => $sector['name'], 'slug' => Str::slug($sector['name']), 'external' => $sector['external']]);
        }
    }
}
