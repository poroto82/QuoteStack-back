<?php

namespace Tests\Unit\Services;

use App\DTOS\QuoteDTO;
use App\Mappers\UserMapper;
use App\Models\Quote;
use App\Models\User;
use App\Models\UserQuote;
use App\Repositories\ZenQuoteRepository;
use App\Services\QuoteService;
use Illuminate\Support\Facades\Cache;
use Mockery\MockInterface;
use Tests\TestCase;

class QuoteServiceTest extends TestCase
{
    protected $quoteRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->quoteRepositoryMock = new ZenQuoteRepository();
    }

    public function testGetQuotesReturnsQuotesFromRepository()
    {
        $service = new QuoteService($this->quoteRepositoryMock);

        // Llama a la función que deseas probar
        $result = $service->getQuotes('quotes', false, 5);

        $this->assertCount(5, $result);  // Asegura que hay dos citas en el resultado

    }

    public function testSaveUserQuote()
    {
        $service = new QuoteService($this->quoteRepositoryMock);
        $user = User::factory()->create();
        $quoteDTO = new QuoteDTO(/* datos ficticios */);

        $userQuote = $service->saveUserQuote($user, $quoteDTO);

        $this->assertInstanceOf(UserQuote::class, $userQuote);
        $this->assertEquals($user->id, $userQuote->user_id);

    }

    public function testDeleteUserQuote()
    {
        $service = new QuoteService($this->quoteRepositoryMock);
        
        $userQuote = UserQuote::create(['quote' => json_encode([
            'text' => 'Some random Quote',
            'author' => "someone"
        ]), 'user_id' => 1]);
        $userQuoteId = $userQuote->id;

        $service->deleteUserQuote($userQuoteId);

        $this->assertDatabaseMissing('user_quotes', ['id' => $userQuoteId]);
    }

    public function testGetQuotesUsesCache()
    {
        Cache::shouldReceive('has')->andReturn(true);
        Cache::shouldReceive('get')->andReturn([
            (object) ['text' => 'cache Quote'],
        ]);

        $service = new QuoteService($this->quoteRepositoryMock);

        $result = $service->getQuotes('someMode', true, 5);

        $this->assertCount(1, $result);
        $this->assertEquals('cache Quote', $result[0]->text);
    }


}