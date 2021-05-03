<?php

use Illuminate\Database\Seeder;

class VersionPautaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\VersionPauta::firstOrCreate([
           'name' => 'Padrão'
        ]);
    }
}
