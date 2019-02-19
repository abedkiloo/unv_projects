<?php

use Illuminate\Database\Seeder;

class Disbursement extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Disbursment::class, 15)->create();

    }
}
