<?php

namespace Database\Factories;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Period::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id;
        $amount = $this->faker->numberBetween(5, 15);
        $opened =  Carbon::now();
        $closed = Carbon::parse($opened)->addDays($amount);
        $id++;
        return [
            'opened' => $opened,
            'closed' => $closed,
            'is_ended' => $this->faker->boolean
        ];
    }
}
