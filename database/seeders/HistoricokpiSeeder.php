<?php

namespace Database\Seeders;
use App\Models\Historicokpi;

use Illuminate\Database\Seeder;

class HistoricokpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Historicokpi::factory()->create();
    }
}
