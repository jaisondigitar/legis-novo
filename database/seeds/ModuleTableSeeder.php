<?php

use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Module::firstOrCreate(['name' => 'Geral', 'active'=>'1']);
        \App\Models\Module::firstOrCreate(['name' => 'Cadastro', 'active'=>'1']);
        \App\Models\Module::firstOrCreate(['name' => 'Documentos', 'active'=>'1']);
        \App\Models\Module::firstOrCreate(['name' => 'Comissoes', 'active'=>'1']);
        \App\Models\Module::firstOrCreate(['name' => 'Sessoes', 'active'=>'1']);
        \App\Models\Module::firstOrCreate(['name' => 'Leis', 'active'=>'1']);

    }
}
