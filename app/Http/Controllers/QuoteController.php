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

    public function getQuotes(?string $mode = 'quotes', bool $new = false){
        
        //Retrieve Quotes
        $quotes = $this->quoteService->getQuotes($mode, $new);
        
        //map quotes to dto and return
        return response(QuoteMapper::mapArrayQuotesToApiResponse($quotes), 200);
    }

    public function getUserQuotes(){
        //Retrieve user
        $userId = Auth::id();

        //Retrieve user and relation Quotes
        $quotes = User::find($userId)->quotes;

        //map quotes to dto and return
        return response([QuoteMapper::mapArrayQuotesToApiResponse($quotes)], 200);
    }

    public function saveUserQuote(){
        //Retrieve user
        $user = Auth::user();

        $quote = $this->quoteService->saveUserQuote($user, "asfaf");
        //map quotes to json
        return response(json_encode($quote), 200);
    }
}
