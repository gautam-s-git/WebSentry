# WebSentry 🛡️

> Multi-client website monitoring platform with real-time notifications

WebSentry helps agencies and developers monitor uptime, performance, and security across all client websites from one powerful dashboard. Get instant alerts via email and real-time browser notifications when issues arise.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![Pusher](https://img.shields.io/badge/Pusher-Real--time-300D4F?style=for-the-badge&logo=pusher&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

---

## ✨ Features

- 🔄 **24/7 Uptime Monitoring** - Automatic website availability checks every 15 minutes
- 📧 **Real-time Email Alerts** - Instant notifications when sites go down or recover
- 🔔 **Live Browser Notifications** - Real-time push notifications via Pusher WebSockets
- 👥 **Multi-Client Management** - Organize and monitor unlimited client websites
- 📊 **Live Dashboard** - Real-time status overview with color-coded indicators
- 📈 **Uptime Statistics** - Track uptime percentage for each website
- 🎨 **Clean UI** - Simple, intuitive interface for easy management

---

## 🎯 MVP Focus

This is a Minimum Viable Product focused on core functionality:

- ✅ Client and website management
- ✅ Basic uptime monitoring (HTTP status checks)
- ✅ Email notifications for up/down events
- ✅ **Real-time browser notifications via Pusher**
- ✅ Simple dashboard with current status

---

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Redis (optional, for queue management)
- Node.js 18+ & NPM
- Vue.js 3
- **Pusher account** (for real-time notifications - Free tier available)

---

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/gautam-s-git/WebSentry.git
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
MAIL_FROM_ADDRESS=do-not-reply@example.com
MAIL_FROM_NAME="WebSentry Alerts"
```

**Supported Email Services:**
- SMTP (any provider)
- Mailtrap (for testing)
- Gmail, SendGrid, Mailgun, etc.

### 6. Configure Pusher (Real-time Notifications)

Sign up for a free account at [Pusher.com](https://pusher.com) and add credentials to `.env`:
```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

**Install Pusher PHP SDK:**
```bash
composer require pusher/pusher-php-server
```

**Install Pusher JavaScript:**
```bash
npm install --save laravel-echo pusher-js
```

### 7. Run Migrations
```bash
php artisan migrate

# Optional: Run seeders for demo data
php artisan db:seed
```

### 8. Build Frontend Assets
```bash
# For production
npm run build

# For development (with hot reload)
npm run dev
```

### 9. Start Services
```bash
# Terminal 1: Start Laravel development server
php artisan serve

# Terminal 2: Start queue worker
php artisan queue:work

# Terminal 3: Start scheduler (for monitoring)
php artisan schedule:work
```

**Visit:** `http://localhost:8000`

---

## 🔧 Configuration

### Monitoring Interval

By default, websites are checked every **15 minutes**. To change this, edit:

**`app/Console/Kernel.php`**
```php
protected function schedule(Schedule $schedule): void
{
    $schedule->command('monitor:websites')
        ->everyFifteenMinutes()  // Change interval here
        ->withoutOverlapping();
}
```

**Available Options:**

| Method | Interval |
|--------|----------|
| `everyMinute()` | Every minute |
| `everyFiveMinutes()` | Every 5 minutes |
| `everyTenMinutes()` | Every 10 minutes |
| `everyFifteenMinutes()` | Every 15 minutes ⭐ |
| `everyThirtyMinutes()` | Every 30 minutes |
| `hourly()` | Every hour |

### Email Notification Settings

Configure notification recipients in the client settings or update default settings in `config/websentry.php`

### Pusher Configuration

Real-time notifications are sent via Pusher on these channels:

- **Public channel:** `website-monitoring` (all users)
- **Private channel:** `client.{id}` (specific client)

---

## 📖 Usage

### 1. Add Clients

Navigate to **"Clients"** → **"Add New Client"** and enter client details:
- Name
- Email
- Status (Active/Inactive)

### 2. Add Websites

Go to **"Websites"** → **"Add Website"** and configure:
- Website URL
- Website Name
- Monitoring interval
- Client assignment

### 3. View Monitoring Logs

Check **"Monitoring"** page to see:
- All monitored websites
- Current status (🟢 Up / 🔴 Down)
- Last check time
- Client information
- Filter by client

### 4. Real-time Notifications

When a website goes down, you'll receive:

- ✉️ **Email notification** with error details
- 🔔 **Real-time browser notification** (via Pusher)
- 📱 **Desktop notification** (if browser permissions granted)

---

## 🛠️ Troubleshooting

### Monitoring Not Working
```bash
# Test monitoring command manually
php artisan monitor:websites

# Check scheduler is running
php artisan schedule:run

# For 15-minute intervals, ensure cron is set up (Production):
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Pusher Not Connecting
```bash
# Verify Pusher credentials in .env
php artisan config:clear
php artisan cache:clear

# Check browser console for errors
# Ensure queue worker is running
php artisan queue:work
```

### Email Not Sending
```bash
# Test email configuration
php artisan tinker
>>> Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# Check queue jobs
php artisan queue:failed
php artisan queue:retry all
```

### Clear All Caches
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 📊 Database Schema

### Main Tables

| Table | Description |
|-------|-------------|
| `users` | Admin and client users |
| `websites` | Monitored websites |
| `monitoring_process_logs` | Check history and results |

### Key Relationships
```
User (Client) → has many → Websites
Website → has many → MonitoringProcessLogs
```

---

## 🔐 Security

- ✅ All passwords are hashed using bcrypt
- ✅ CSRF protection enabled
- ✅ SQL injection protection via Eloquent ORM
- ✅ XSS protection in Vue components
- ✅ Authentication via Laravel Breeze/Sanctum

---

## 🚀 Production Deployment

### Requirements

1. Set up cron job for scheduler:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

2. Use process manager for queue worker (Supervisor recommended):
```ini
[program:websentry-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-your-project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path-to-your-project/storage/logs/worker.log
```

3. Optimize application:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

---

## 📝 API Documentation

### Monitor Website Manually
```php
use App\Services\MonitoringService;

MonitoringService::checkWebsiteStatus($url, $clientId, $websiteId);
```

### Trigger Event
```php
use App\Events\WebsiteDownEvent;

event(new WebsiteDownEvent($website, $client));
```

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

- Built with [Laravel 12](https://laravel.com) ❤️
- Real-time notifications via [Pusher](https://pusher.com) 🔔
- UI components from [Bootstrap](https://getbootstrap.com) & [PrimeVue](https://primevue.org) 🎨
- Frontend framework: [Vue.js 3](https://vuejs.org) ⚡
- Icons from [PrimeIcons](https://primevue.org/icons) 🎯

---

## 📧 Contact

**Gautam Kumar**

- GitHub: [@gautam-s-git](https://github.com/gautam-s-git)
- Project Link: [https://github.com/gautam-s-git/WebSentry](https://github.com/gautam-s-git/WebSentry)

---

<div align="center">

**Made with ❤️ by GAUTAM KUMAR**

⭐ Star this repository if you find it helpful!

</div>
