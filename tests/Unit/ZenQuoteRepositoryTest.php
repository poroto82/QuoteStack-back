<?php

namespace Tests\Unit\Repositories;

use App\Exceptions\ZenRepositoryException;
use App\Models\Quote;
use App\Repositories\ZenQuoteRepository;
use Database\Factories\QuoteFactory;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

use Mockery;

class ZenQuoteRepositoryTest extends TestCase
{
    protected $httpClientMock;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testGetQuotesSuccess()
    {
        Http::fake([
            'https://zenquotes.io?api=quotes' => Http::response([QuoteFactory::create(),QuoteFactory::create()], 200)
        ]);

        $repository = new ZenQuoteRepository();

        $result = $repository->getQuotes('quotes', 2);

        $this->assertCount(2, $result);
    }

    public function testGetQuotesApiFailure()
    {
        Http::fake([
            'https://zenquotes.io?api=quotes' => Http::response('random error message', 500)
        ]);

        $repository = new ZenQuoteRepository();

        $this->expectException(ZenRepositoryException::class);
        $repository->getQuotes('quotes', 2);
    }


}