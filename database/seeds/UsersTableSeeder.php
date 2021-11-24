<?php

use App\Models\Profile;
use App\Models\User;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // USER ROOT
        $usr = User::where('email', 'admin@genesis.tec.br')
            ->firstOr(function () {
                return User::create([
                    'company_id' => 1,
                    'name' => 'Administrador',
                    'sector_id' => 1,
                    'email' => 'admin@genesis.tec.br',
                    'active' => 1,
                    'password' => bcrypt('G&nesis***'),
                ]);
            });

        $role = Defender::findRole('root');

        $usr->attachRole($role);

        Profile::firstOrCreate([
            'user_id'=> $usr->id,
            'active'=>1,
        ]);
    }
}
