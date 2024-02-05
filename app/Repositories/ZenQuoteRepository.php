<?php

namespace App\Repositories;

use App\Exceptions\ZenRepositoryException;
use App\Mappers\QuoteMapper;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZenQuoteRepository
{

    /**
     * Get quotes from the ZenQuotes API based on the specified mode and limit.
     *
     * @param string $mode Mode of the quotes API.
     * @param int $limit Limit of quotes to retrieve.
     *
     * @return array Retrieved quotes from the ZenQuotes API.
     *
     * @throws ZenRepositoryException If the response from the ZenQuotes API is unsuccessful.
     * @throws ZenRepositoryException If there is an exception while retrieving quotes from the ZenQuotes API.
     */
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
            else{
                throw new ZenRepositoryException('Response Unsuccesfull');
            }
        }
        catch(Exception $e){
            Log::error($e->getMessage());
            throw new ZenRepositoryException("Cannot retrieve quotes from Zen");
        }
        
    }
}
