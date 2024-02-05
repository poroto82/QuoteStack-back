<?php
use App\DTOS\QuoteDTO;
use App\Mappers\QuoteMapper;
use App\Models\Quote;
use App\Models\UserQuote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Tests\TestCase;

class QuoteMapperTest extends TestCase
{
    public function testMapQuoteToDTO()
    {
        $quote = new Quote();
        $quote->q = 'Sample quote';
        $quote->a =  'Sample author';
        $quote->i = 'Sample image';
        $quote->c = 'Sample charcou';
        $quote->h = 'Sample html';

        $quoteDto = QuoteMapper::mapQuoteToDTO($quote);

        $this->assertInstanceOf(QuoteDTO::class, $quoteDto);
        $this->assertEquals('Sample quote', $quoteDto->text);
        $this->assertEquals('Sample author', $quoteDto->author);
    }

    public function testFromRequestToDto()
    {
        $request = new Request([
            'text' => 'Sample quote',
            'author' => 'Sample author',
            'html' => 'www.something.com'
        ]);

        $quoteDto = QuoteMapper::fromRequestToDto($request);

        $this->assertInstanceOf(QuoteDTO::class, $quoteDto);
        $this->assertEquals('Sample quote', $quoteDto->text);
        $this->assertEquals('Sample author', $quoteDto->author);
    }

    public function testFromRequestToDtoWithInvalidRequestData()
    {
        //missing html
        $request = new Request([
            'text' => 'Sample quote',
            'author' => 'Sample author',
        ]);

        $this->expectException(\TypeError::class);
        $quoteDto = QuoteMapper::fromRequestToDto($request);
    }


    public function testMapApiResponseToQuote()
    {
        $apiResponse = [
            'q' => 'Sample quote',
            'a' => 'Sample author',
            'i' => 'Sample image',
            'c' => 'Sample charcou',
            'h' => 'Sample html',
        ];

        $quote = QuoteMapper::mapApiResponseToQuote($apiResponse);

        $this->assertInstanceOf(Quote::class, $quote);
        $this->assertEquals('Sample quote', $quote->q);
        $this->assertEquals('Sample author', $quote->a);
    }

}