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
         $this->call(UserTableSeeder::class);
         $this->call(COuntrySeeder::class);
         $this->call(ProjectSeeder::class);
         $this->call(ReadinessSeeder::class);
         $this->call(DisbursmentSeeder::class);
         $this->call(StatusSeeder::class);
         $this->call(PhaseSeeder::class);
    }
}
