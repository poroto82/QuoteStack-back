<?php

namespace App\Mappers;

use App\DTOS\QuoteDTO;
use App\Models\Quote;
use App\Models\UserQuote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class QuoteMapper
{
    public static function mapQuoteToDTO(Quote $quote): QuoteDTO
    {
        $quoteDto = new QuoteDTO();
        $quoteDto->text = $quote->q;
        $quoteDto->author = $quote->a;
        $quoteDto->image = $quote->i;
        $quoteDto->characterCount = $quote->c;
        $quoteDto->html = $quote->h;
        $quoteDto->cached = $quote->cached;
        return $quoteDto;
    }

    public static function fromRequestToDto(Request $request): QuoteDTO{
        $quoteDto = new QuoteDTO();
        $quoteDto->text = $request->input('text');
        $quoteDto->author = $request->input('author');
        $quoteDto->image = $request->input('image');
        $quoteDto->characterCount = $request->input('characterCount');
        $quoteDto->html = $request->input('html');
        
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

    //check type
    public static function mapDbQuoteToDto(UserQuote $data): QuoteDTO{
        $quoteDto = new QuoteDTO();
        $quoteDto->id = $data->id;
        
        $auxQuote = json_decode($data->quote);
        
        $quoteDto->text = $auxQuote->text;
        $quoteDto->author = $auxQuote->author;
        $quoteDto->image = $auxQuote->image;
        $quoteDto->characterCount = $auxQuote->characterCount;
        $quoteDto->html = $auxQuote->html;

        return $quoteDto;
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

    public static function mapCollectionDbQuoteToDto (Collection $quotes): array{
        return $quotes->map(function($q){
            return self::mapDbQuoteToDto($q);
        })->toArray();
    }
}