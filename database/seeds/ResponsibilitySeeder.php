<?php

use Illuminate\Database\Seeder;

class ResponsibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ['Presidente', 'Vice-presidente', '1º Secretário', 'Vereador'];
        $order = [1, 2, 3, 15];

        foreach ($datas as $key => $data) {
            $resp = \App\Models\Responsibility::firstOrCreate(['name' => $data]);
            $resp->order = $order[$key];
            $resp->save();
        }
    }
}
