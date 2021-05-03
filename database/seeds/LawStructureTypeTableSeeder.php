<?php

use Illuminate\Database\Seeder;
use App\Models\LawsStructure;

class LawStructureTypeTableSeeder extends Seeder
{

    public function run()
    {
        $nameTypes = [
            'Artigo',
            'Capítulo',
            'Inciso',
            'Item',
            'Livro',
            'Parágrafo',
            'Parágrafo único',
            'Alinea',
            'Seção',
            'Setor',
            'Subseção',
            'Texto Único',
            'Título',
        ];

        foreach ($nameTypes as $key => $itemType) {
            LawsStructure::firstOrCreate(['name' => $itemType]);
        }
    }
}
