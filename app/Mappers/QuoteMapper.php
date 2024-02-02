<?php

namespace App\Mappers;

use App\Models\Quote;

class QuoteMapper
{
    public static function mapToApiResponse(Quote $quote)
    {
        return [
            'text' => $quote->q,
            'author' => $quote->a,
            'image' => $quote->i,
            'characterCount' => $quote->c,
            'html' => $quote->h
        ];
    }

    public static function mapApiResponseToQuote(array $data){
        
        $quote = new Quote();
        $quote->q = $data['q'];
        $quote->a = $data['a'];
        $quote->i = isset($data['i']) ? $data['i'] : null; // Only in pro version
        $quote->c = isset($data['c']) ? $data['c'] : null; // Only in pro version
        $quote->h = $data['h'];
        
        return $quote;
    }

    public static function mapArrayApiResponseToQuotes(array $quotes){
        return array_map(function($q){
            return self::mapApiResponseToQuote($q);
        },$quotes);
    }

    public static function mapArrayQuotesToApiResponse(array $quotes){
        return array_map(function($q){
            return self::mapToApiResponse($q);
        },$quotes);
    }
}