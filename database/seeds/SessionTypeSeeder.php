<?php

use Illuminate\Database\Seeder;

class SessionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['Sessão Ordinária', 'Sessão Extraordinária', 'Sessão Solene'];

        foreach ($datas as $data) {
            \App\Models\SessionType::firstOrCreate(['name' => $data]);
        }
    }
}
