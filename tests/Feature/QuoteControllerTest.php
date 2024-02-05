<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;
use \Illuminate\Support\Facades\Artisan;

class QuoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetQuotes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/quotes');

        $response->assertStatus(200);
    }

    public function testGetUserQuotes()
    {
        Artisan::call('passport:install');
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createToken(config('app.name'))->accessToken
        ])->get('/api/user/quotes');

        $response->assertStatus(200);
    }

    public function testUnauthorizedGetUserQuotes()
    {
        Artisan::call('passport:install');
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . 'RandomString'
        ])
        ->withHeader('Accept','application/json')
        ->get('/api/user/quotes');

        $response->assertStatus(401);
    }


}