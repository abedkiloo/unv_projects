<?php

use Illuminate\Database\Seeder;

class COuntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Country::class, 15)->create();

    }
}
