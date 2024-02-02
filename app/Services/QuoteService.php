<?php

namespace App\Services;

use App\Models\Quote;
use App\Models\User;
use App\Repositories\ZenQuoteRepository;
use Illuminate\Support\Facades\Cache;

class QuoteService{

    protected $quoteRepository;

    public function __construct(ZenQuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function getQuotes(string $mode, int $limit = 5, bool $useCache = true){
        $cacheKey = 'random_quotes_' . $limit;

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

    public function saveUserQuote(User $user, Quote $quote){
        $user->quotes[] = $quote;
        $user->save();
    }

    
}