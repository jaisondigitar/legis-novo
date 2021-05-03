<?php

use Illuminate\Database\Seeder;
use App\Models\ProtocolType;
use Illuminate\Support\Str;

class DocumentProtocolTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentProtocolTypes = [
            'Automático',
            'Externo'
        ];

        $prefix = [
            'aut',
            'ext'
        ];

        foreach ($documentProtocolTypes as $key => $documentProtocolType) {
            ProtocolType::firstOrCreate(['name' => $documentProtocolType, 'slug' => Str::slug($documentProtocolType)]);
        }
    }
}
