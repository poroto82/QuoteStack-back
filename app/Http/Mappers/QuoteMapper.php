<?php

namespace App\Mappers;

use App\Models\Quote;

class QuoteMapper
{
    public static function mapToApiResponse(Quote $quote)
    {
        return [
            'id' => $quote->id,
            'text' => $quote->text,
            'author' => $quote->author,
            // Otros campos...
        ];
    }

    public static function mapApiResponseToQuote(array $data){
        $quote = new Quote();
        $quote->text = $data['text'];
        
        return $quote;
    }
}