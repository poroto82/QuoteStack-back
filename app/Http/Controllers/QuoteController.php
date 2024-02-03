<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use App\Mappers\QuoteMapper;
use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function getQuotes(?string $mode = 'quotes', bool $new = false){
        
        //Retrieve Quotes
        $quotes = $this->quoteService->getQuotes($mode, !$new);
        
        //map quotes to dto and return
        return response(QuoteMapper::mapArrayQuotesToDto($quotes), 200);
    }

    public function getUserQuotes(){
        //Retrieve user
        $user = Auth::user();

        //Retrieve user and relation Quotes
        $quotes = $user->quotes;

        if ($quotes->isEmpty()) {
            return response(['message' => 'No favorite quotes found.'], 404);
        }
    
        // Map quotes to dto using Collection map method
        $mappedQuotes = $quotes->map(function ($quote) {
            return json_decode($quote->quote);
        });
        //map quotes to dto and return
        return response($mappedQuotes, 200);
    }

    public function saveUserQuote(QuoteRequest $request){
        $quoteDTO = QuoteMapper::fromRequestToDto($request);
        
        //Retrieve user
        $user = Auth::user();

        $quote = $this->quoteService->saveUserQuote($user, $quoteDTO);
        
        return new JsonResponse(json_decode($quote->quote), 201);
    }

    public function deleteUserQuote(int $id){
        $this->quoteService->deleteUserQuote($id);
        return response(202);
    }
}
