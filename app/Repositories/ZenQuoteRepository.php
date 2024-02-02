<?php

namespace App\Repositories;

use App\Mappers\QuoteMapper;
use Illuminate\Support\Facades\Http;

class ZenQuoteRepository{

    public function getRandomQuotes(): array{
         // Realizar la solicitud a la API de Quotes
         $response = Http::get('https://zenquotes.io/api/random');

         // Verificar si la solicitud fue exitosa y devolver los datos
         if ($response->successful()){
            
            $quotes = array_map(function($q){
                return QuoteMapper::mapApiResponseToQuote($q);
            }, $response->array());
            
            return $quotes;
         }
 
         // Manejar cualquier error o fallback
         return null;
    }
}