<?php

namespace App\DTOS;

class UserDTO{
    public int $id;
    public string $name;
    public string $email;
    public ?array $quotes;
}