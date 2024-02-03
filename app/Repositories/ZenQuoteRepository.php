<?php

namespace App\Repositories;

use App\Exceptions\ZenRepositoryException;
use App\Mappers\QuoteMapper;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZenQuoteRepository
{

    public function getQuotes(string $mode, int $limit): array
    {
        try{
            // call Api
            $response = Http::get("https://zenquotes.io?api=$mode");

            // check if succesful
            if ($response->successful()) {
                //apply limit
                $arr = array_slice($response->json(), 0, $limit);
                
                // cast to type
                $quotes = QuoteMapper::mapArrayApiResponseToQuotes($arr);

                return $quotes;
            }
        }
        catch(Exception $e){
            Log::error($e->getMessage());
            throw new ZenRepositoryException("Cannot retrieve quotes from Zen");
        }
        
    }
}
