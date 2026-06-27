<?php

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;

function createOrgWithAdmin(string $name): array
{
    $org = Organization::factory()->create([
        'name' => $name,
        'slug' => str()->slug($name),
    ]);

    $user = User::factory()->create([
        'organization_id' => $org->id,
        'role' => 'admin',
        'email' => "admin@{$org->slug}.test",
        'password' => 'password123',
    ]);

    return [$org, $user];
}

it('scopes tickets to the authenticated users organization', function () {
    // Create Org A + admin
    [$orgA, $adminA] = createOrgWithAdmin('Org Alpha');

    // Create Org B + admin
    [$orgB, $adminB] = createOrgWithAdmin('Org Beta');

    // 3 tickets for Org A
    Ticket::factory()->count(3)->create([
        'organization_id' => $orgA->id,
        'requester_id' => $adminA->id,
    ]);

    // 3 tickets for Org B
    Ticket::factory()->count(3)->create([
        'organization_id' => $orgB->id,
        'requester_id' => $adminB->id,
    ]);

    // Login as Org A admin
    $token = $adminA->createToken('test-token')->plainTextToken;

    // GET /api/tickets → exactly 3 from Org A
    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson('/api/tickets');

    $response->assertOk();
    expect($response->json('data'))->toHaveCount(3);
    expect(collect($response->json('data'))->pluck('organization_id')->unique()->toArray())->toBe([$orgA->id]);
});

it('returns 404 when accessing a ticket from another organization', function () {
    [$orgA, $adminA] = createOrgWithAdmin('Org Alpha Two');
    [$orgB, $adminB] = createOrgWithAdmin('Org Beta Two');

    // Ticket in Org B
    $orgBTicket = Ticket::factory()->create([
        'organization_id' => $orgB->id,
        'requester_id' => $adminB->id,
    ]);

    $token = $adminA->createToken('test-token')->plainTextToken;

    // Org A admin tries to access Org B ticket → 404
    $this->withHeader('Authorization', "Bearer {$token}")
        ->getJson("/api/tickets/{$orgBTicket->id}")
        ->assertNotFound();
});
