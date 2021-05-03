<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        \DB::table('states')->delete();
        
        \DB::table('states')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uf' => 'AC',
                'name' => 'Acre',
                'created_at' => '2015-12-20 19:41:04',
                'updated_at' => '2015-12-20 19:41:04',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uf' => 'AL ',
                'name' => 'Alagoas',
                'created_at' => '2015-12-20 19:42:05',
                'updated_at' => '2015-12-20 19:42:05',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uf' => 'AM',
                'name' => 'Amazonas',
                'created_at' => '2015-12-20 19:42:20',
                'updated_at' => '2015-12-20 19:42:20',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'uf' => 'AP',
                'name' => 'Amapa',
                'created_at' => '2015-12-20 19:42:31',
                'updated_at' => '2015-12-20 19:42:31',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'uf' => 'BA',
                'name' => 'Bahia',
                'created_at' => '2015-12-20 19:46:01',
                'updated_at' => '2015-12-20 19:46:01',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'uf' => 'CE',
                'name' => 'Ceara',
                'created_at' => '2015-12-20 19:46:11',
                'updated_at' => '2015-12-20 19:46:11',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'uf' => 'DF',
                'name' => 'Distrito Federal',
                'created_at' => '2015-12-20 19:46:33',
                'updated_at' => '2015-12-20 19:46:33',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'uf' => 'ES',
                'name' => 'Espirito Santo',
                'created_at' => '2015-12-20 19:46:50',
                'updated_at' => '2015-12-20 19:46:50',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'uf' => 'GO',
                'name' => 'Goias',
                'created_at' => '2015-12-20 19:46:59',
                'updated_at' => '2015-12-20 19:47:05',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'uf' => 'MA',
                'name' => 'Maranhão',
                'created_at' => '2015-12-20 19:47:18',
                'updated_at' => '2015-12-20 19:47:28',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'uf' => 'MG',
                'name' => 'Minas Gerais',
                'created_at' => '2015-12-20 19:47:44',
                'updated_at' => '2015-12-20 19:47:44',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'uf' => 'MS',
                'name' => 'Mato Grosso do Sul',
                'created_at' => '2015-12-20 19:47:59',
                'updated_at' => '2015-12-20 19:48:08',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'uf' => 'MT',
                'name' => 'Mato Grosso',
                'created_at' => '2015-12-20 19:48:16',
                'updated_at' => '2015-12-20 19:48:16',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'uf' => 'PA',
                'name' => 'Pará',
                'created_at' => '2015-12-20 19:48:23',
                'updated_at' => '2015-12-20 19:48:23',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'uf' => 'PB',
                'name' => 'Paraiba',
                'created_at' => '2015-12-20 19:48:33',
                'updated_at' => '2015-12-20 19:48:33',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'uf' => 'PE',
                'name' => 'Pernambuco',
                'created_at' => '2015-12-20 19:48:50',
                'updated_at' => '2015-12-20 19:48:50',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'uf' => 'PI',
                'name' => 'Piauí',
                'created_at' => '2015-12-20 19:49:02',
                'updated_at' => '2015-12-20 19:49:02',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'uf' => 'PR',
                'name' => 'Paraná',
                'created_at' => '2015-12-20 19:49:13',
                'updated_at' => '2015-12-20 19:49:13',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'uf' => 'RJ',
                'name' => 'Rio de Janeiro',
                'created_at' => '2015-12-20 19:49:23',
                'updated_at' => '2015-12-20 19:49:23',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'uf' => 'RN',
                'name' => 'Rio Grande do Norte',
                'created_at' => '2015-12-20 19:49:35',
                'updated_at' => '2015-12-20 19:49:35',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'uf' => 'RO',
                'name' => 'Rondonia',
                'created_at' => '2015-12-20 19:49:47',
                'updated_at' => '2015-12-20 19:49:47',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'uf' => 'RR',
                'name' => 'Roraima',
                'created_at' => '2015-12-20 19:50:00',
                'updated_at' => '2015-12-20 19:50:00',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'uf' => 'RS',
                'name' => 'Rio Grande do Sul',
                'created_at' => '2015-12-20 19:50:26',
                'updated_at' => '2015-12-20 19:50:26',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'uf' => 'SC',
                'name' => 'Santa Catarina',
                'created_at' => '2015-12-20 19:50:34',
                'updated_at' => '2015-12-20 19:50:34',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'uf' => 'SE',
                'name' => 'Sergipe',
                'created_at' => '2015-12-20 19:50:43',
                'updated_at' => '2015-12-20 19:50:43',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'uf' => 'SP',
                'name' => 'São Paulo',
                'created_at' => '2015-12-20 19:50:50',
                'updated_at' => '2015-12-20 19:50:50',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'uf' => 'TO',
                'name' => 'Tocantins',
                'created_at' => '2015-12-20 19:51:06',
                'updated_at' => '2015-12-20 19:51:06',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}
