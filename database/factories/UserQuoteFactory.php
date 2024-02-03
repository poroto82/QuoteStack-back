<?php

namespace Database\Factories;

use App\Mappers\QuoteMapper;
use App\Repositories\ZenQuoteRepository;
use App\Services\QuoteService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserQuote>
 */
class UserQuoteFactory extends Factory
{

   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quoteRepository = new ZenQuoteRepository();
        $quotes = $quoteRepository->getQuotes('random',1);
        return [
            'quote' => json_encode(QuoteMapper::mapToApiResponse($quotes[0]))
        ];
    
    }
}
