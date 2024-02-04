<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use App\Mappers\QuoteMapper;
use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function getQuotes(Request $request, ?string $mode = 'quotes'){ 
        
        $forceRefresh = filter_var($request->get('forceRefresh'), FILTER_VALIDATE_BOOLEAN) ??  false;
        $limit = $request->get('limit') ?? 5;

        //Retrieve Quotes
        $quotes = $this->quoteService->getQuotes($mode, !$forceRefresh, $limit);
        
        //map quotes to dto and return
        return response(QuoteMapper::mapArrayQuotesToDto($quotes), 200);
    }

    public function getUserQuotes(){
        //Retrieve user
        $user = Auth::user();

        //Retrieve user and relation Quotes
        $quotes = $user->quotes;

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
