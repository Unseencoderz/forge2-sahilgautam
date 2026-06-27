<?php

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;

function setupOrgAndUsers(): array
{
    $org = Organization::factory()->create([
        'name' => 'Reply Test Org',
        'slug' => 'reply-test-org',
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

    $ticket = Ticket::factory()->create([
        'organization_id' => $org->id,
        'requester_id' => $customer->id,
    ]);

    return [$org, $admin, $agent, $customer, $ticket];
}

function replyLoginToken(User $user): string
{
    return $user->createToken('test-token')->plainTextToken;
}

beforeEach(function () {
    [$this->org, $this->admin, $this->agent, $this->customer, $this->ticket] = setupOrgAndUsers();
});

it('agent can post a public reply', function () {
    $token = replyLoginToken($this->agent);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson("/api/tickets/{$this->ticket->id}/replies", [
            'body' => 'Here is the fix for your issue.',
            'type' => 'reply',
        ]);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'body' => 'Here is the fix for your issue.',
            'type' => 'reply',
        ]);

    $this->assertDatabaseHas('ticket_replies', [
        'ticket_id' => $this->ticket->id,
        'user_id' => $this->agent->id,
        'type' => 'reply',
    ]);
});

it('agent can post an internal note', function () {
    $token = replyLoginToken($this->agent);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson("/api/tickets/{$this->ticket->id}/replies", [
            'body' => 'This customer has a history of duplicate tickets.',
            'type' => 'note',
        ]);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'type' => 'note',
        ]);

    $this->assertDatabaseHas('ticket_replies', [
        'ticket_id' => $this->ticket->id,
        'type' => 'note',
    ]);
});

it('customer can post a reply', function () {
    $token = replyLoginToken($this->customer);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson("/api/tickets/{$this->ticket->id}/replies", [
            'body' => 'Thanks for the update!',
            'type' => 'reply',
        ]);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'body' => 'Thanks for the update!',
            'type' => 'reply',
        ]);
});

it('customer posting a note gets saved as reply instead', function () {
    $token = replyLoginToken($this->customer);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson("/api/tickets/{$this->ticket->id}/replies", [
            'body' => 'Trying to sneak a note',
            'type' => 'note',
        ]);

    $response->assertStatus(201)
        ->assertJsonFragment([
            'type' => 'reply',
        ]);

    $this->assertDatabaseHas('ticket_replies', [
        'ticket_id' => $this->ticket->id,
        'user_id' => $this->customer->id,
        'type' => 'reply',
    ]);

    // No notes from this customer
    $this->assertDatabaseMissing('ticket_replies', [
        'ticket_id' => $this->ticket->id,
        'user_id' => $this->customer->id,
        'type' => 'note',
    ]);
});

it('customer listing replies does not see notes', function () {
    // Create a reply and a note from agent
    TicketReply::create([
        'ticket_id' => $this->ticket->id,
        'user_id' => $this->agent->id,
        'body' => 'Public reply here',
        'type' => 'reply',
    ]);

    TicketReply::create([
        'ticket_id' => $this->ticket->id,
        'user_id' => $this->agent->id,
        'body' => 'Secret internal note',
        'type' => 'note',
    ]);

    $token = replyLoginToken($this->customer);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson("/api/tickets/{$this->ticket->id}/replies");

    $response->assertOk();

    $types = collect($response->json())->pluck('type');
    expect($types)->not->toContain('note');
    expect($types)->toContain('reply');
    expect($response->json())->toHaveCount(1);
});

it('agent listing replies sees both replies and notes', function () {
    TicketReply::create([
        'ticket_id' => $this->ticket->id,
        'user_id' => $this->agent->id,
        'body' => 'Public reply',
        'type' => 'reply',
    ]);

    TicketReply::create([
        'ticket_id' => $this->ticket->id,
        'user_id' => $this->agent->id,
        'body' => 'Internal note',
        'type' => 'note',
    ]);

    $token = replyLoginToken($this->agent);

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson("/api/tickets/{$this->ticket->id}/replies");

    $response->assertOk();
    expect($response->json())->toHaveCount(2);

    $types = collect($response->json())->pluck('type');
    expect($types)->toContain('reply');
    expect($types)->toContain('note');
});
