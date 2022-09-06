<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        DB::statement("TRUNCATE TABLE users");

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'rabia@vivense.com',
            'email_verified_at' => now(),
            'password' => bcrypt(713229),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(60)
        ]);

        User::factory(100)->create();

    }
}
