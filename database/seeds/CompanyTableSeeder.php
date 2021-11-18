<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = Company::find(2);
        if (is_null($obj)) {
            Company::create([
                'shortName'=>'Gênesis',
                'fullName'=>'Gênesis Tecnologia e Inovação',
                'email'=>'comercial@genesis.tec.br',
                'phone1'=>'(67) 9 9978-1420',
                'mayor'=>'Igor M. Oliveira',
                'cnpjCpf'=>'000.000.000-00',
                'ieRG'=>'00000-0 SSP/MT',
                'city'=>'5120',
                'state'=>'12',
                'active'=>'1',
            ]);
        }
    }
}
