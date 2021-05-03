<?php

use Illuminate\Database\Seeder;
use App\Models\LawsPlace;
use App\Models\LawsType;

class PlacesTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $namePlaces = [
            'Diário Oficial',
            'Internet'
        ];

        foreach ($namePlaces as $key => $item) {
            LawsPlace::firstOrCreate(['name' => $item]);
        }

        $nameTypes = [
            'Código de Obras',
            'Código de Postura',
            'Código Tributário',
            'Emenda a Lei Complementar',
            'Emenda Aditiva',
            'Emenda Modificada',
            'Lei Complementar',
            'Lei Ordinária',
            'Lei Orgânica',
            'Regime Interno',
            'Projeto de Lei'
        ];

        foreach ($nameTypes as $key => $itemType) {
            LawsType::firstOrCreate(['name' => $itemType]);
        }
    }
}
