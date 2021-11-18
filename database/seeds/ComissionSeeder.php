<?php

use Illuminate\Database\Seeder;

class ComissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'Presidente', 'slug' => 'presidente'],
            ['name'=>'Relator', 'slug' => 'relator'],
            ['name'=>'Membro', 'slug' => 'membro'],
        ];

        foreach ($data as $reg) {
            \App\Models\OfficeCommission::firstOrCreate($reg);
        }
    }
}
