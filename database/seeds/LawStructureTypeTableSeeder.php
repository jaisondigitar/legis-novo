<?php

use App\Models\LawsStructure;
use Illuminate\Database\Seeder;

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
