<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    private string $testUserToken;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
        $testUser = User::create([
            'name' => 'Test username',
            'email' => 'test@test.com',
            'password' => Hash::make('00000000')
        ]);
        $this->testUserToken = $testUser->createToken('api-token')->plainTextToken;
    }

    /**
     * TEST ROUTE: /api/v1/register
     * TEST ROUTE: /api/v1/login
     */
    public function test_register_login(): void
    {
        $testUserData = [
            'name' => 'Test username II',
            'email' => 'test2@test.com',
            'password' => '00000000',
            'password_confirmation' => '00000000'
        ];

        // Register the user

        $response = $this->post('/api/v1/register', $testUserData);
        $response->assertStatus(201);

        $response = $this->post('/api/v1/login', [
            'email' => $testUserData['email'],
            'password' => $testUserData['password']
        ]);
        $response->assertStatus(200);
    }

    /**
     * TEST ROUTE: /api/v1/download
     */
    public function test_download(): void
    {
        $response = $this->get('/api/v1/download');
        $response->assertStatus(401);


    }
}
