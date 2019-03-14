<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CiclosTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(ResponsablesTableSeeder::class);
    }
}
