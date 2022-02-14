<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(RolesTableSeeder::class);
        $this->call(SectorsTableSeeder::class);
        $this->call(ComissionSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(ModuleTableSeeder::class);
        $this->call(DocumentTypesTableSeeder::class);
        //$this->call(StatesTableSeeder::class);
        //$this->call(CitiesTableSeeder::class);
        $this->call(DocumentProtocolTypeTableSeeder::class);
        $this->call(ParametersTableSeeder::class);
        $this->call(PlacesTypesTableSeeder::class);
        $this->call(LawStructureTypeTableSeeder::class);
        $this->call(ResponsibilitySeeder::class);
        $this->call(SessionLocationSeeder::class);
        $this->call(SessionTypeSeeder::class);
        $this->call(ComissionSituationTableSeeder::class);
        $this->call(VersionPautaSeeder::class);
        Model::reguard();
    }
}
