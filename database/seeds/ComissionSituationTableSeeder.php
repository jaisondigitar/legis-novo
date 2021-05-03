<?php

use Illuminate\Database\Seeder;

class ComissionSituationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['Pedido', 'Em análise', 'Aguardando documentos','Indiferente','Desfavorável','Favorável'];

        foreach ($datas as $data) {
            \App\Models\ComissionSituation::firstOrCreate(['name' => $data]);
        }
    }

}
