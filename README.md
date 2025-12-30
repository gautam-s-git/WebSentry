# WebSentry 🛡️

> Multi-client website monitoring platform with real-time email notifications

WebSentry helps agencies and developers monitor uptime, performance, and security across all client websites from one powerful dashboard. Get instant email alerts when issues arise.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## ✨ Features

- 🔄 **24/7 Uptime Monitoring** - Automatic website availability checks every 5 minutes
- 📧 **Real-time Email Alerts** - Instant notifications when sites go down or recover
- 👥 **Multi-Client Management** - Organize and monitor unlimited client websites
- 📊 **Live Dashboard** - Real-time status overview with color-coded indicators
- 📈 **Uptime Statistics** - Track uptime percentage for each website
- ⚡ **Background Processing** - Queue-based monitoring system for reliability
- 🎨 **Clean UI** - Simple, intuitive interface for easy management

## 🎯 MVP Focus

This is a Minimum Viable Product focused on core functionality:
- Single admin user authentication
- Client and website management
- Basic uptime monitoring (HTTP status checks)
- Email notifications for up/down events
- Simple dashboard with current status

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7+ 
- Redis (optional, for queue management)
- Vue.js

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/websentry.git
cd websentry
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=websentry
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Configure Email

Add your email configuration to `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=alerts@websentry.com
MAIL_FROM_NAME="WebSentry Alerts"
```

**Supported Email Services:**
- SMTP
- Mailgun
- Amazon SES
- SendGrid
- Postmark
- Mailtrap (for testing)

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Build Frontend Assets

```bash
npm run build
# or for development
npm run dev
```



### 8. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 🔧 Configuration

### Monitoring Interval

By default, websites are checked every 5 minutes. To change this, edit:

```php
// app/Console/Kernel.php

$schedule->command('websentry:check-websites')
    ->everyFiveMinutes(); // Change to everyMinute(), hourly(), etc.
```

### Email Notification Settings

Customize email templates in:
- `resources/views/emails/website-down.blade.php`
- `resources/views/emails/website-up.blade.php`

## 📖 Usage


### 2. Add a Client

1. Go to **Clients** menu
2. Click **Add Client**
3. Enter client details (name, email, phone)
4. Save

### 3. Add Websites to Monitor

1. Select a client
2. Click **Add Website**
3. Enter website URL and name
4. Save

### 4. Monitor Dashboard

The dashboard shows:
- All monitored websites
- Current status (🟢 Up / 🔴 Down)
- Last check time
- Uptime percentage

### 5. Email Notifications

You'll automatically receive emails when:
- A website goes down (with error details)
- A website comes back up (recovery notification)

## 🗂️ Project Structure

```
websentry/
├── app/
│   ├── Console/
│   │   
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ClientController.php
│   │       └── WebsiteController.php
│   ├── Mail/
│   │   ├── WebsiteDown.php
│   │   └── WebsiteUp.php
│   ├── Models/
│   │   ├── Client.php
│   │   ├── Website.php
│   │   └── Check.php
│   └── Jobs/
│       └── CheckWebsiteUptime.php   # Queue job
├── database/
│   └── migrations/
├── resources/
│   └── views/
│       ├── clients/
│       ├── websites/
│       └── emails/
└── routes/
    └── web.php
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ClientTest
```

## 🔒 Security

- All passwords are hashed using bcrypt
- CSRF protection enabled on all forms
- SQL injection protection via Eloquent ORM
- XSS protection in Blade templates

**Security Best Practices:**
- Change default admin password immediately
- Use strong passwords
- Enable 2FA (post-MVP feature)
- Keep Laravel and dependencies updated
- Use HTTPS in production

## 📊 Database Schema

### Tables

**users**
- id, name, email, password, timestamps

**clients**
- id, name, email, phone, timestamps

**websites**
- id, client_id, name, url, status, last_checked_at, timestamps

**checks**
- id, website_id, status_code, is_up, checked_at, error_message, timestamps

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Configure proper database credentials
- [ ] Setup email service (not Mailtrap)
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Setup Supervisor for queue workers
- [ ] Configure cron for scheduler
- [ ] Setup SSL certificate
- [ ] Configure firewall rules

### Recommended Hosting

- DigitalOcean
- AWS
- Linode
- Vultr
- Laravel Forge (managed)

## 🛠️ Troubleshooting

### Queue not processing?

```bash
# Restart queue worker
php artisan queue:restart

# Check failed jobs
php artisan queue:failed
```

### Emails not sending?

```bash
# Test email configuration
php artisan tinker
Mail::raw('Test email', function($msg) {
    $msg->to('test@example.com')->subject('Test');
});
```

### Scheduler not running?

```bash
# Verify cron is setup
crontab -l

# Test scheduler manually
php artisan schedule:run
```

## 📝 Roadmap

### Phase 2: Enhanced Monitoring
- [ ] Performance metrics (load time, response time)
- [ ] SSL certificate expiry monitoring
- [ ] Multiple check locations (geo-distributed)

### Phase 3: Advanced Features
- [ ] Multi-user support with roles
- [ ] Client portal access
- [ ] Detailed charts and historical data
- [ ] SMS notifications
- [ ] Slack/Discord integrations

### Phase 4: Enterprise
- [ ] API access
- [ ] White-label branding
- [ ] Custom reporting
- [ ] Mobile app

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Support

- 📧 Email: support@websentry.com
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/websentry/issues)
- 📖 Documentation: [Wiki](https://github.com/yourusername/websentry/wiki)

## 🙏 Acknowledgments

- Built with [Laravel 12](https://laravel.com)
- UI components from [Tailwind CSS](https://tailwindcss.com)
- Icons from [Heroicons](https://heroicons.com)

---

**Made with ❤️ for agencies and developers managing multiple client websites**

**Never miss downtime again. Get instant alerts. Keep your clients happy.** ✉️
