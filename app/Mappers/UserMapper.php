<?php

namespace App\Mappers;

use App\DTOS\UserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserMapper{
    public static function userToDto(User $user,Collection $quotes){
        $userDTO = new UserDTO();
        $userDTO->name = $user->name;
        $userDTO->email = $user->email;
        $userDTO->id = $user->id;
        
        $userDTO->quotes = QuoteMapper::mapCollectionDbQuoteToDto($quotes);

        return $userDTO;
    }

    public static function userCollectionToArrayDTo(Collection $users){
       return $users->map(function($u){
            return UserMapper::userToDto($u,$u->quotes);
        })->toArray();
    }
}