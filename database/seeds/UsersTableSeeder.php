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
        $usr = User::findOrNew(1);

        $usr->company_id = 1;
        $usr->name = 'Administrador';
        $usr->sector_id = 1;
        $usr->email = 'admin@genesis.tec.br';
        $usr->active = 1;
        $usr->password = bcrypt('G&nesis***');

        $usr->save();

        $role = Defender::findRole('root');

        $usr->attachRole($role);

        Profile::firstOrCreate([
            'user_id'=> $usr->id,
            'active'=>1,
        ]);
    }
}
