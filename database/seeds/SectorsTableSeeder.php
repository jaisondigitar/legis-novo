<?php

use Illuminate\Database\Seeder;
use App\Models\Sector;
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
        $sectors = ['Secretaria', 'Gabinete', 'Jurídico'];

        foreach ($sectors as $sector) {
            Sector::firstOrCreate(['name' => $sector, 'slug' => Str::slug($sector)]);
        }

    }
}
