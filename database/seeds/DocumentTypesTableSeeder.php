<?php

use App\Models\DocumentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentTypes = [
            'Indicação',
            'Requerimento',
            'Moção',
            'Decreto',
            'Emenda',
        ];

        $prefix = [
            'ind',
            'req',
            'moc',
            'dec',
            'eme',
        ];

        foreach ($documentTypes as $key => $documentType) {
            DocumentType::firstOrCreate(['parent_id'=>0, 'name' => $documentType, 'prefix' => $prefix[$key], 'slug' => Str::slug($documentType)]);
        }
    }
}
