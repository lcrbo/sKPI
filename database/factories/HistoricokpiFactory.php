<?php

namespace Database\Factories;

use App\Models\Historicokpi;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoricokpiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Historicokpi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'formato' => 'ALV',  
            'local'=> 454, 
            'valor'=> 67, 
            'indicadorkpi_id' => 2
        ];
    }
}
