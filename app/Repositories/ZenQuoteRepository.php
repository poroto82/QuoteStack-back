<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class ZenQuoteRepository{

    public function getRandomQuotes(){
         // Realizar la solicitud a la API de Quotes
         $response = Http::get('https://zenquotes.io/api/random');

         // Verificar si la solicitud fue exitosa y devolver los datos
         if ($response->successful()) {
             return $response->json();
         }
 
         // Manejar cualquier error o fallback
         return null;
    }
}