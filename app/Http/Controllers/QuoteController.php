<?php

namespace App\Http\Controllers;

use App\Services\QuoteService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function getRandomQuotes(){
        $quotes = (new QuoteService())->getRandomQuotes(5);
        //map quotes to json
        return response(['quotes' => $quotes], 200);
    }

    public function getFavoriteQuotes(){
        //Retrieve user
        $user = Auth::user();

        $quotes = (new QuoteService())->getUserQuotes($user);
        //map quotes to json
        return response(['quotes' => $quotes], 200);
    }
}
