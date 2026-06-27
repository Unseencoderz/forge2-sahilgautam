# Submission Checklist

This checklist is an honest map of the current repository state. Keep it updated before final handoff.

## App

- [x] PulseDesk support-ticket SaaS is implemented.
- [x] Laravel API exists under `backend/`.
- [x] React/Vite frontend exists under `frontend/`.
- [x] Auth uses Laravel Sanctum.
- [x] Roles exist: `admin`, `agent`, `customer`.
- [x] Tickets CRUD exists.
- [x] Public replies and internal notes exist.
- [x] Ticket filters/search exist.
- [x] Seeded demo data exists.
- [x] Multi-tenant ticket isolation is implemented and tested.
- [ ] SLA timers, notifications, macros, activity log, and realtime updates are not implemented.

## Run Steps

- [x] README includes portable SQLite run steps.
- [x] README includes MySQL 8 run steps.
- [x] README includes frontend run steps.
- [x] README includes demo accounts.
- [x] README includes API summary.

## Architecture And Docs

- [x] `README.md` is filled in.
- [x] `ARCHITECTURE.md` is filled in.
- [x] `SUBMISSION.md` is filled in.
- [x] README links screenshots and evidence files.
- [x] Architecture includes Mermaid diagrams.
- [x] Architecture explains tenancy, roles, API routes, frontend routes, tests, and tradeoffs.

## Tests And CI

- [x] Pest test evidence is saved at `backend/evidence/pest-output.txt`.
- [x] API route evidence is saved at `backend/evidence/api-routes.txt`.
- [x] Login/routes evidence is saved at `backend/evidence/login-and-routes.txt`.
- [x] GitHub Actions workflow exists at `.github/workflows/ci.yml`.
- [x] Saved evidence shows `24 passed (82 assertions)`.
- [ ] Confirm latest GitHub Actions run is green before final submission.

## Agent And Sprint Evidence

- [x] Root `agent-log.md` exists.
- [x] Sprint 1 backlog exists at `sprints/sprint-1/backlog.md`.
- [x] Sprint 2 backlog exists at `sprints/sprint-2/backlog.md`.
- [x] Slack/evidence screenshots exist under `slack-export/`.
- [x] Agent workflow screenshots exist under `slack-export/`.
- [ ] `sprints/sprint-1/review.md` is currently empty.
- [ ] `sprints/sprint-2/review.md` is currently empty.
- [ ] `agents/hermes-config.md` is currently empty.
- [ ] `agents/openclaw-config.md` is currently empty.

## Important Paths

| Item | Path |
| --- | --- |
| README | `README.md` |
| Architecture | `ARCHITECTURE.md` |
| Submission checklist | `SUBMISSION.md` |
| Agent log | `agent-log.md` |
| CI workflow | `.github/workflows/ci.yml` |
| Backend evidence | `backend/evidence/` |
| Slack evidence | `slack-export/` |
| Sprint docs | `sprints/` |
| Agent configs | `agents/` |

## Known Review Notes

- Current backend dependency is Laravel 13, while the event target named Laravel 11.
- Current `.env.example` defaults to SQLite for portability. MySQL is supported through the documented `.env` settings.
- No real secrets are documented here. Any final agent config should use placeholders such as `${EASTROUTER_API_KEY}` and `${SLACK_BOT_TOKEN}`.
