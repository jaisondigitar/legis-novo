<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = Company::find(1);
        if(is_null($obj))
        {
            Company::create([
                'shortName'=>'i7 Creative',
                'fullName'=>'i7 Creative Tecnologia',
                'email'=>'lucas@i7creative.com.br',
                'phone1'=>'(67) 8107-4917',
                'mayor'=>'Lucas R. Pasquetto',
                'cnpjCpf'=>'000.000.000-00',
                'ieRG'=>'00000-0 SSP/MT',
                'city'=>'5120',
                'state'=>'12',
                'active'=>'1'
            ]);
        }

    }
}
