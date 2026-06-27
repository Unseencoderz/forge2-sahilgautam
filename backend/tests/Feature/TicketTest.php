<?php

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;

function setupOrgWithUsers(string $orgName): array
{
    $org = Organization::factory()->create([
        'name' => $orgName,
        'slug' => str()->slug($orgName),
    ]);

    $admin = User::factory()->create([
        'organization_id' => $org->id,
        'role' => 'admin',
        'password' => 'password123',
    ]);

    $agent = User::factory()->create([
        'organization_id' => $org->id,
        'role' => 'agent',
        'password' => 'password123',
    ]);

    $customer = User::factory()->create([
        'organization_id' => $org->id,
        'role' => 'customer',
        'password' => 'password123',
    ]);

    return [$org, $admin, $agent, $customer];
}

function loginToken(User $user): string
{
    return $user->createToken('test-token')->plainTextToken;
}

beforeEach(function () {
    [$this->org, $this->admin, $this->agent, $this->customer] = setupOrgWithUsers('Test Org');
});

it('admin can create a ticket', function () {
    $token = loginToken($this->admin);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson('/api/tickets', [
            'subject' => 'Server down',
            'description' => 'Production server is not responding',
            'priority' => 'urgent',
        ]);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'subject' => 'Server down',
            'priority' => 'urgent',
            'status' => 'open',
        ]);

    $this->assertDatabaseHas('tickets', [
        'subject' => 'Server down',
        'requester_id' => $this->admin->id,
        'organization_id' => $this->org->id,
    ]);
});

it('index returns paginated tickets', function () {
    Ticket::factory()->count(20)->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->admin->id,
    ]);

    $token = loginToken($this->admin);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/tickets');

    $response->assertOk()
        ->assertJsonStructure([
            'data',
            'current_page',
            'per_page',
            'total',
        ]);

    expect($response->json('data'))->toHaveCount(15);
    expect($response->json('total'))->toBe(20);
});

it('index filters by status', function () {
    Ticket::factory()->count(3)->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->admin->id,
        'status' => 'open',
    ]);
    Ticket::factory()->count(2)->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->admin->id,
        'status' => 'closed',
    ]);

    $token = loginToken($this->admin);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/tickets?status=closed');

    $response->assertOk();
    expect($response->json('data'))->toHaveCount(2);
    expect(collect($response->json('data'))->pluck('status')->unique()->toArray())->toBe(['closed']);
});

it('index search works on subject', function () {
    Ticket::factory()->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->admin->id,
        'subject' => 'Email delivery failure',
    ]);
    Ticket::factory()->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->admin->id,
        'subject' => 'Database corruption',
    ]);

    $token = loginToken($this->admin);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/tickets?search=Email');

    $response->assertOk();
    expect($response->json('data'))->toHaveCount(1);
    expect($response->json('data.0.subject'))->toBe('Email delivery failure');
});

it('show returns a single ticket', function () {
    $ticket = Ticket::factory()->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->admin->id,
        'subject' => 'Show me this ticket',
    ]);

    $token = loginToken($this->admin);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson("/api/tickets/{$ticket->id}");

    $response->assertOk()
        ->assertJsonFragment([
            'id' => $ticket->id,
            'subject' => 'Show me this ticket',
        ]);
});

it('agent can update ticket status', function () {
    $ticket = Ticket::factory()->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->customer->id,
        'status' => 'open',
    ]);

    $token = loginToken($this->agent);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->putJson("/api/tickets/{$ticket->id}", [
            'status' => 'pending',
        ]);

    $response->assertOk()
        ->assertJsonFragment(['status' => 'pending']);
});

it('customer cannot update ticket', function () {
    $ticket = Ticket::factory()->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->customer->id,
        'status' => 'open',
    ]);

    $token = loginToken($this->customer);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->putJson("/api/tickets/{$ticket->id}", [
            'status' => 'resolved',
        ]);

    $response->assertForbidden();
});

it('admin can delete a ticket', function () {
    $ticket = Ticket::factory()->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->admin->id,
    ]);

    $token = loginToken($this->admin);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->deleteJson("/api/tickets/{$ticket->id}");

    $response->assertNoContent();

    // Soft-deleted
    $this->assertSoftDeleted('tickets', ['id' => $ticket->id]);
});

it('customer cannot delete a ticket', function () {
    $ticket = Ticket::factory()->create([
        'organization_id' => $this->org->id,
        'requester_id' => $this->customer->id,
    ]);

    $token = loginToken($this->customer);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->deleteJson("/api/tickets/{$ticket->id}");

    $response->assertForbidden();
});
