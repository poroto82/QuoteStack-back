<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote
{
    use HasFactory;

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