<?php

namespace App\Mappers;

use App\DTOS\QuoteDTO;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteMapper
{
    public static function mapQuoteToDTO(Quote $quote)
    {
        $quoteDto = new QuoteDTO();
        $quoteDto->text = $quote->q;
        $quoteDto->author = $quote->a;
        $quoteDto->image = $quote->i;
        $quoteDto->characterCount = $quote->c;
        $quoteDto->html = $quote->h;
        return $quoteDto;
    }

    public static function fromRequestToDto(Request $request): QuoteDTO{
        $quoteDto = new QuoteDTO();
        $quoteDto->text = $request->input('text');
        
        return $quoteDto;
    }

    public static function mapApiResponseToQuote(array $data): Quote{
        
        $quote = new Quote();
        $quote->q = $data['q'];
        $quote->a = $data['a'];
        $quote->i = isset($data['i']) ? $data['i'] : null; // Only in pro version
        $quote->c = isset($data['c']) ? $data['c'] : null; // Only in pro version
        $quote->h = $data['h'];
        
        return $quote;
    }

    public static function mapArrayApiResponseToQuotes(array $quotes): array{
        return array_map(function($q){
            return self::mapApiResponseToQuote($q);
        },$quotes);
    }

    public static function mapArrayQuotesToDto(array $quotes): array{
        return array_map(function($q){
            return self::mapQuoteToDTO($q);
        },$quotes);
    }
}