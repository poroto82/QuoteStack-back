<?php

namespace App\DTOS;

class QuoteDTO{
    public string $text;
    public string $author;
    public ?string $image;
    public ?string $characterCount;
    public string $html;
}