<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\usertype;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        usertype::create([
            'usertype' => 'superadmin'       
        ]);
        usertype::create([
            'usertype' => 'admin'       
        ]);
        usertype::create([
            'usertype' => 'manager'       
        ]);
        usertype::create([
            'usertype' => 'reguser'       
        ]);
    }
}
