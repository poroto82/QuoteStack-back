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
        $quoteService = new QuoteService(new ZenQuoteRepository());
        $quotes = $quoteService->getQuotes('quotes',true,20);
        $quote = $quotes[rand(0,sizeof($quotes)-1)];
        
        return [
            'quote' => json_encode(QuoteMapper::mapQuoteToDTO($quote))
        ];
    
    }
}
