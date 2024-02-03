<?php

namespace App\Services;

use App\DTOS\QuoteDTO;
use App\Models\Quote;
use App\Models\User;
use App\Models\UserQuote;
use App\Repositories\ZenQuoteRepository;
use Illuminate\Support\Facades\Cache;

class QuoteService{

    protected $quoteRepository;

    public function __construct(ZenQuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function getQuotes(string $mode, bool $useCache = true, int $limit = 5): array{
        $cacheKey = $mode.'_quotes_' . $limit;


        if ($useCache && Cache::has($cacheKey)) {
            // Si se utiliza caché y los datos están en caché, devolver desde la caché
            return Cache::get($cacheKey);
        }

        // Si no hay datos en caché o no se utiliza la caché, obtener desde el repositorio
        $quotes = $this->quoteRepository->getQuotes($mode, $limit);

        //Save to cache
        Cache::put($cacheKey, $quotes, now()->addSeconds(config('app.quote_cache_ttl')));

        return $quotes;
    }

    public function saveUserQuote(User $user,  QuoteDTO $quote){
        $userQuote = new UserQuote();
        $userQuote->user_id = $user->id;
        $userQuote->quote = json_encode($quote);
        $userQuote->save();
        return $userQuote;
    }
    
    public function deleteUserQuote(int $id):void{
        $userQuote = UserQuote::find($id);
        $userQuote->delete();
    }
    
}