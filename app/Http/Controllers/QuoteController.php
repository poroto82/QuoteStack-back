<?php

namespace App\Http\Controllers;

use App\Mappers\QuoteMapper;
use App\Models\Quote;
use App\Models\User;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function getRandomQuote(){
        //Retrieve Quotes
        $quotes = $this->quoteService->getQuotes('random');
        
        //map quotes to dto and return
        return response(QuoteMapper::mapToApiResponse($quotes[0]), 200);
    }

    public function getFavoriteQuotes(){
        //Retrieve user
        $userId = Auth::id();

        //Retrieve user and relation Quotes
        $quotes = User::find($userId)->quotes();

        //map quotes to dto and return
        return response([QuoteMapper::mapArrayQuotesToApiResponse($quotes)], 200);
    }

    public function saveFavoriteQuote(Quote $quote){
        //Retrieve user
        $user = Auth::user();

        $quote = $this->quoteService->saveUserQuote($user, $quote);
        //map quotes to json
        return response(['quote' => $quote], 200);
    }
}
