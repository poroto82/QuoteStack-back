<?php

namespace App\Models;

class Quote
{
    public string $q;
    public string $a;
    public ?string $i;  // Nullable Only in pro version of api
    public ?string $c;  // Nullable Only in pro version of api
    public ?string $h;  
    public bool $cached;

    public function __construct()
    {
        $this->cached = false;
    }
}