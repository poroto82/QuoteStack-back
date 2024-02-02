<?php

namespace App\Repositories;

use App\Mappers\QuoteMapper;
use Illuminate\Support\Facades\Http;

class ZenQuoteRepository{

    public function getQuotes(string $mode, int $limit): array{
        
        // call Api
         $response = Http::get("https://zenquotes.io?api=$mode");

         // check if succesful
         if ($response->successful()){
            //apply limit
            array_slice($response->json(), 0, $limit);
            // cast to type
            $quotes = QuoteMapper::mapArrayApiResponseToQuotes($response->json());
            
            return $quotes;
         }
 
         // null on fallback
         return null;
    }
}