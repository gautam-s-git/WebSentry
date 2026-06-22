# Changelog

All notable changes to WebSentry will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Planned
- Response time tracking per check
- SMS notifications support
- Weekly uptime summary reports
- Public status page per client
- Slack / Discord webhook notifications
- API endpoints for external integrations
- Dark mode support

---

## [1.0.0] - 2025-12-29

### Added
- Multi-client website management
- 24/7 uptime monitoring via scheduled `monitor:websites` command
- HTTP status code checks with up/down detection
- Email notifications on website down and recovery events
- Real-time browser notifications via Pusher WebSockets
- Live dashboard with color-coded status indicators
- Uptime percentage tracking per website
- Monitoring process logs with full check history
- Mail notification logs for audit trail
- Two-factor authentication (2FA) via Laravel Fortify
- Vue.js 3 frontend with Inertia.js
- SQLite support out of the box (MySQL/MariaDB also supported)

---

## Links

- [GitHub Repository](https://github.com/gautam-s-git/WebSentry)
- [Report a Bug](https://github.com/gautam-s-git/WebSentry/issues)
