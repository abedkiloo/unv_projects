<?php

use Illuminate\Database\Seeder;

class ReadinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ReadinessType::class, 5)->create();

    }
}
