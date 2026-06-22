# Contributing to WebSentry 🛡️

Thanks for taking the time to contribute! Here's how to get started.

---

## 🐛 Reporting Bugs

1. Check [existing issues](https://github.com/gautam-s-git/WebSentry/issues) to avoid duplicates.
2. Open a new issue with:
   - A clear title and description
   - Steps to reproduce
   - Expected vs actual behavior
   - PHP/Node versions and OS

---

## 💡 Suggesting Features

Open an issue with the `enhancement` label. Describe the use case, not just the solution.

---

## 🔧 Development Setup

```bash
git clone https://github.com/gautam-s-git/WebSentry.git
cd WebSentry
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

---

## 📬 Submitting a Pull Request

1. Fork the repo and create a branch from `main`:
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. Make your changes and commit with a clear message:
   ```bash
   git commit -m "feat: add response time tracking to monitoring logs"
   ```

3. Push to your fork:
   ```bash
   git push origin feature/your-feature-name
   ```

4. Open a PR against `main`. Include:
   - What changed and why
   - Screenshots if UI is affected
   - Any migration steps needed

---

## ✅ Commit Message Convention

Use [Conventional Commits](https://www.conventionalcommits.org/):

| Prefix | Use for |
|--------|---------|
| `feat:` | New features |
| `fix:` | Bug fixes |
| `docs:` | Documentation changes |
| `refactor:` | Code refactoring |
| `test:` | Adding or updating tests |
| `chore:` | Maintenance tasks |

---

## 🧪 Running Tests

```bash
php artisan test
```

---

## 📄 License

By contributing, you agree your contributions will be licensed under the [MIT License](LICENSE).
