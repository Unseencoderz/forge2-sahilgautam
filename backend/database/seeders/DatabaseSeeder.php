<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Organization
        $org = Organization::create([
            'name' => 'Acme Corp',
            'slug' => 'acme',
            'plan' => 'pro',
        ]);

        // 2. Users
        $alice = User::create([
            'name' => 'Alice Admin',
            'email' => 'admin@acme.com',
            'password' => Hash::make('password'),
            'organization_id' => $org->id,
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $bob = User::create([
            'name' => 'Bob Agent',
            'email' => 'agent1@acme.com',
            'password' => Hash::make('password'),
            'organization_id' => $org->id,
            'role' => 'agent',
            'email_verified_at' => now(),
        ]);

        $carol = User::create([
            'name' => 'Carol Agent',
            'email' => 'agent2@acme.com',
            'password' => Hash::make('password'),
            'organization_id' => $org->id,
            'role' => 'agent',
            'email_verified_at' => now(),
        ]);

        $dave = User::create([
            'name' => 'Dave Customer',
            'email' => 'cust1@acme.com',
            'password' => Hash::make('password'),
            'organization_id' => $org->id,
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $eve = User::create([
            'name' => 'Eve Customer',
            'email' => 'cust2@acme.com',
            'password' => Hash::make('password'),
            'organization_id' => $org->id,
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // 3. Tickets — 12 total
        $agents = [$bob, $carol];
        $customers = [$dave, $eve];

        $ticketData = [
            // 4 open: 2 high, 2 medium
            ['subject' => 'Cannot login to portal', 'description' => 'I keep getting an invalid credentials error even though my password is correct.', 'status' => 'open', 'priority' => 'high', 'tags' => ['technical', 'account']],
            ['subject' => 'Password reset not working', 'description' => 'The password reset link expires immediately when I click it.', 'status' => 'open', 'priority' => 'high', 'tags' => ['technical']],
            ['subject' => 'Feature request: dark mode', 'description' => 'It would be great to have a dark mode option for the dashboard.', 'status' => 'open', 'priority' => 'medium', 'tags' => ['feature-request']],
            ['subject' => 'Cannot upload attachments', 'description' => 'When I try to upload a file to a ticket, nothing happens.', 'status' => 'open', 'priority' => 'medium', 'tags' => ['technical', 'bug']],

            // 3 pending: 1 urgent, 2 medium
            ['subject' => 'Billing charge incorrect', 'description' => 'I was charged twice for my monthly subscription.', 'status' => 'pending', 'priority' => 'urgent', 'tags' => ['billing']],
            ['subject' => 'Account suspended unexpectedly', 'description' => 'My account was suspended and I do not know why.', 'status' => 'pending', 'priority' => 'medium', 'tags' => ['account', 'billing']],
            ['subject' => 'Integration not working', 'description' => 'The Slack integration stopped syncing messages two days ago.', 'status' => 'pending', 'priority' => 'medium', 'tags' => ['integration', 'technical']],

            // 3 resolved: low
            ['subject' => 'Invoice not received', 'description' => 'I did not receive my invoice for this month via email.', 'status' => 'resolved', 'priority' => 'low', 'tags' => ['billing']],
            ['subject' => 'Need data export', 'description' => 'I need to export all my ticket history for compliance purposes.', 'status' => 'resolved', 'priority' => 'low', 'tags' => ['data', 'account']],
            ['subject' => 'Missing email notifications', 'description' => 'I stopped getting email notifications for ticket updates.', 'status' => 'resolved', 'priority' => 'low', 'tags' => ['technical', 'notifications']],

            // 2 closed: low
            ['subject' => 'Response time too slow', 'description' => 'It took 5 days to get a response on my last ticket.', 'status' => 'closed', 'priority' => 'low', 'tags' => ['feedback']],
            ['subject' => 'API rate limit issue', 'description' => 'I am hitting the API rate limit too frequently during bulk operations.', 'status' => 'closed', 'priority' => 'low', 'tags' => ['api', 'technical']],
        ];

        $assignees = [
            $bob, $carol, null, null,   // open tickets
            $bob, $carol, $bob,         // pending tickets
            null, null, null,           // resolved tickets
            null, null,                 // closed tickets
        ];

        $tickets = [];
        foreach ($ticketData as $i => $data) {
            $requester = $customers[$i % 2];
            $tickets[] = Ticket::create([
                'organization_id' => $org->id,
                'subject' => $data['subject'],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'requester_id' => $requester->id,
                'assignee_id' => $assignees[$i]?->id,
                'tags' => $data['tags'],
            ]);
        }

        // 4. Replies on 6 tickets
        // 3 public replies from Bob or Carol
        TicketReply::create([
            'ticket_id' => $tickets[0]->id,
            'user_id' => $bob->id,
            'body' => 'I have reproduced this issue. Working on a fix now.',
            'type' => 'reply',
        ]);

        TicketReply::create([
            'ticket_id' => $tickets[4]->id,
            'user_id' => $carol->id,
            'body' => 'I see the duplicate charge. I am escalating this to our billing team.',
            'type' => 'reply',
        ]);

        TicketReply::create([
            'ticket_id' => $tickets[1]->id,
            'user_id' => $carol->id,
            'body' => 'Can you try clearing your browser cache and requesting a new reset link?',
            'type' => 'reply',
        ]);

        // 3 internal notes from Bob or Carol
        TicketReply::create([
            'ticket_id' => $tickets[0]->id,
            'user_id' => $bob->id,
            'body' => 'This looks like a session handling bug in the auth middleware. Check the token expiry config.',
            'type' => 'note',
        ]);

        TicketReply::create([
            'ticket_id' => $tickets[4]->id,
            'user_id' => $carol->id,
            'body' => 'Customer has been with us for 3 years. Apply refund and waive next month.',
            'type' => 'note',
        ]);

        TicketReply::create([
            'ticket_id' => $tickets[6]->id,
            'user_id' => $bob->id,
            'body' => 'Slack API token may have been revoked. Need to check OAuth credentials.',
            'type' => 'note',
        ]);
    }
}
