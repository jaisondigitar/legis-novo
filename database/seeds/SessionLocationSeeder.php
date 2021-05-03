<?php

use Illuminate\Database\Seeder;

class SessionLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SessionPlace::firstOrCreate(['name'=>'Câmara Municipal']);
    }
}
