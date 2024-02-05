<?php

namespace Database\Factories;

use App\Models\Quote;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory 
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public static function create()
    {
        return ([
            'q' => fake()->text(),
            'a' => fake()->text(),
            'i' => null,
            'c' => null,
            'h' => fake()->text(),
        ]);
    }
}
