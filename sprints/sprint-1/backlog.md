# Sprint 1 Backlog — PulseDesk REST API

| Task | Description | Assignee | Status |
|------|-------------|----------|--------|
| **TASK-1** | Laravel 11 scaffolding in backend/, Sanctum, /api/health endpoint | OpenClaw | To Do |
| **TASK-2** | Database migrations (organizations, users with roles, tickets, ticket_replies) | Unassigned | To Do |
| **TASK-3** | Auth API (register, login, logout, me) with EnsureRole middleware | Unassigned | To Do |
| **TASK-4** | OrganizationScope global scope for multi-tenancy isolation | Unassigned | To Do |
| **TASK-5** | Tickets REST API (index with filters, store, show, update, destroy) | Unassigned | To Do |
| **TASK-6** | Ticket Replies API (public replies + internal notes, customer visibility scoping) | Unassigned | To Do |
| **TASK-7** | DatabaseSeeder (1 org, 1 admin, 2 agents, 2 customers, 12 tickets, sample replies) | Unassigned | To Do |
| **TASK-8** | Full Pest test suite green + /api/health + route list saved to evidence/ | Unassigned | To Do |

## Sprint Goal
Build the complete Laravel 11 REST API backend for PulseDesk, including multi-tenant scaffolding, auth, ticket management, replies, seeders, and a passing Pest test suite.

## Definition of Done
- All 8 tasks complete and committed
- `php artisan test` green (Pest)
- `/api/health` responds 200 OK
- Route list exported to `evidence/route-list.txt`
