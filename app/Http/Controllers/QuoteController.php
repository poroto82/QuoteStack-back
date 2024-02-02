<?php

namespace App\Http\Controllers;

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

    public function getRandomQuotes(){
        $quotes = $this->quoteService->getRandomQuotes(5);
        //map quotes to json
        return response(['quotes' => $quotes], 200);
    }

    public function getFavoriteQuotes(){
        //Retrieve user
        $user = Auth::user();

        $quotes = $this->quoteService->getUserQuotes($user);
        //map quotes to json
        return response(['quotes' => $quotes], 200);
    }
}
