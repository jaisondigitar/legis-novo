<?php

use App\Models\Parameters;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParametersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = [
            'Permitir criar documentos fora da sequência',
            'Permitir criar sessões fora da sequência',
            'Permitir criar número de projetos de lei fora da sequência',
            'Permitir criar número de lei fora da sequência',
            'Exibe apenas documentos LIDOS no portal',
            'Permitir criar número de projetos e documentos para mesmo vereadores',
            'Realiza trâmite em documentos',
            'Realiza trâmite em projetos',
            'Gabinete pede parecer juridico',
            'Gabinete pede parecer em comissão',
            'Mostra historico de tramites no front',
            'Mostra anexo de documentos no front',
            'Mostra cabeçalho em PDF de documentos e projetos',
            'Mostra cabeçalho em PDF de pauta ',
            'Mostra cabeçalho em PDF de ata',
            'Espaço entre texto e cabeçalho',
            'Mostra ATAS no front',
            'Mostra PAUTAS no front',
            'Margem superior de documentos',
            'Margem inferior de documentos',
            'Margem esquerda de documentos',
            'Margem direita de documentos',
            'Sempre usa protocolo externo',
            'Exibe detalhe de tramitação',
            'Presidente assina pauta e ata',
            'Vice Presidente assina pauta e ata',
            '1º Secretário assina pauta e ata',
            'Realiza votação de documentos',
            'Realiza votação em projeto de lei',
            'Realiza votação de ata',
            'Realiza votação de parecer',
            'Mostra votação em projeto de lei',
            'Mostra votação em documento',
            'Mostra votação em ata',
            'Mostra votação em parecer',
            'Painel digital permitir multi-sessões',
        ];

        $type = [
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '0',
            '1',
            '1',
            '0',
            '0',
            '0',
            '0',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
        ];

        $value = [
            '0',
            '0',
            '0',
            '0',
            '1',
            '0',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '1',
            '45',
            '1',
            '1',
            '10',
            '15',
            '15',
            '15',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '1',
            '1',
            '1',
            '0',
            '0',
            '0',
            '0',
            '0',
        ];

        //Parameters::truncate();

        foreach ($name as $key => $item) {
            $data = [
                'name' => $item,
                'slug' => Str::slug($item),
                'type' => $type[$key],
                'value' => $value[$key],
            ];

            $param = Parameters::where('slug', $data['slug'])->first();

            if (! $param) {
                Parameters::create($data);
            }
        }
    }
}
