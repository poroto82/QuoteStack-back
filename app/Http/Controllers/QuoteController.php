<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use App\Mappers\QuoteMapper;
use App\Mappers\UserMapper;
use App\Models\User;
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
        
        // Key to apply cache per ip and device
        $ipDeviceKey = $request->ip().$request->userAgent();

        $forceRefresh = filter_var($request->get('forceRefresh'), FILTER_VALIDATE_BOOLEAN) ??  false;
        $limit = $request->get('limit') ?? 5;

        //Retrieve Quotes
        $quotes = $this->quoteService->getQuotes($mode, !$forceRefresh, $limit, $ipDeviceKey);
        
        //map quotes to dto and return
        return response(QuoteMapper::mapArrayQuotesToDto($quotes), 200);
    }

    public function getUserQuotes(){
        //Retrieve user
        $user = Auth::user();

        //map quotes to dto and return
        return response(QuoteMapper::mapCollectionDbQuoteToDto($user->quotes), 200);
    }

    public function saveUserQuote(QuoteRequest $request){
        $quoteDTO = QuoteMapper::fromRequestToDto($request);
        
        //Retrieve user
        $user = Auth::user();
        $quote = $this->quoteService->saveUserQuote($user, $quoteDTO);

        $response = QuoteMapper::mapDbQuoteToDto($quote);

        return new JsonResponse($response, 201);
    }

    public function deleteUserQuote(int $id){
        $this->quoteService->deleteUserQuote($id);
        return response(202);
    }


    public function getUsersAndQuotes(){
        $users = User::with('quotes')->get();
        return response(UserMapper::userCollectionToArrayDTo($users), 200);
    }
}
