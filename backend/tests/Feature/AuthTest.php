<?php

use App\Models\User;

function createUserToken(): array
{
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $token = $user->createToken('test-token')->plainTextToken;

    return [$user, $token];
}

it('registers a new user and returns a token', function () {
    $response = $this->postJson('/api/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'user' => ['id', 'name', 'email', 'role'],
            'token',
        ]);

    expect($response->json('token'))->not->toBeEmpty();
    expect($response->json('user.email'))->toBe('john@example.com');
    expect($response->json('user.role'))->toBe('customer');

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
    ]);
});

it('logs in with valid credentials and returns a token', function () {
    [$user, $originalToken] = createUserToken();

    $response = $this->postJson('/api/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
            'token',
        ]);

    expect($response->json('token'))->not->toBeEmpty();
});

it('returns 401 with wrong password', function () {
    User::factory()->create([
        'email' => 'wrong@example.com',
        'password' => 'password123',
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => 'wrong@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertUnauthorized()
        ->assertJson(['message' => 'Invalid credentials']);
});

it('returns the authenticated user via me endpoint', function () {
    [$user, $token] = createUserToken();

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/auth/me');

    $response->assertOk()
        ->assertJsonFragment([
            'id' => $user->id,
            'email' => $user->email,
        ]);
});

it('revokes the token on logout', function () {
    $user = User::factory()->create([
        'email' => 'logout-test@example.com',
        'password' => 'password123',
    ]);

    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson('/api/auth/logout');

    $response->assertOk()
        ->assertJson(['message' => 'Logged out']);

    // Token record should be deleted from DB
    expect(\DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->count())->toBe(0);
});
