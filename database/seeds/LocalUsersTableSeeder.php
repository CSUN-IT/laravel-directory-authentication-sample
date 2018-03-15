<?php

use Illuminate\Database\Seeder;

use App\LocalUser;

class LocalUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LocalUser::create([
        	'name' => 'Test User 1',
        	'username' => 'test1',
        	'email' => 'test1@example.com',
        	'password' => bcrypt('test1'),
        ]);

        LocalUser::create([
        	'name' => 'Test User 2',
        	'username' => 'test2',
        	'email' => 'test2@example.com',
        	'password' => bcrypt('test2'),
        ]);
    }
}
