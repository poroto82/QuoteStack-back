<?php

namespace App\Services;

use App\DTOS\QuoteDTO;
use App\Mappers\UserMapper;
use App\Models\Quote;
use App\Models\User;
use App\Models\UserQuote;
use App\Repositories\ZenQuoteRepository;
use Illuminate\Support\Facades\Cache;

class QuoteService
{

    protected $quoteRepository;

    public function __construct(ZenQuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * Get quotes based on the specified mode and limit.
     *
     * @param string $mode Mode of the quote.  quotes | random
     * @param bool $useCache Indicates whether to use cache.
     * @param int $limit Limit of quotes to retrieve.
     * @return array Retrieved quotes.
     */
    public function getQuotes(string $mode, bool $useCache, int $limit): array
    {
        $cacheKey = $mode . '_quotes_' . $limit;

        if ($useCache && Cache::has($cacheKey)) {
            // Si se utiliza caché y los datos están en caché, devolver desde la caché
            $cacheResult = array_map(function ($q) {
                $q->cached = true;
                return $q;
            }, Cache::get($cacheKey));
            return $cacheResult;
        }

        // Si no hay datos en caché o no se utiliza la caché, obtener desde el repositorio
        $quotes = $this->quoteRepository->getQuotes($mode, $limit);

        Cache::put($cacheKey, $quotes, now()->addSeconds(config('app.quote_cache_ttl')));

        return $quotes;
    }


    /**
     * Save a quote associated with a user.
     *
     * @param User $user User to associate the quote with.
     * @param QuoteDTO $quote Quote to be saved.
     * @return UserQuote Quote associated with the user.
     */
    public function saveUserQuote(User $user,  QuoteDTO $quote): UserQuote
    {
        $userQuote = new UserQuote();
        $userQuote->user_id = $user->id;
        $userQuote->quote = json_encode($quote);
        $userQuote->save();
        return $userQuote;
    }

    /**
     * Delete a user's quote by its ID.
     *
     * @param int $id ID of the quote to be deleted.
     * @return void
     */
    public function deleteUserQuote(int $id): void
    {
        $userQuote = UserQuote::find($id);
        $userQuote->delete();
    }
}
