# RCV Technologies Recruitment Portal

<p align="center">
  <img src="https://www.rcvtechnologies.com/wp-content/uploads/2024/02/RCV-LOGO.webp" alt="RCV Technologies Logo" width="200" />
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#tech-stack">Tech Stack</a> •
  <a href="#installation">Installation</a> •
  <a href="#quick-start">Quick Start</a> •
  <a href="#configuration">Configuration</a> •
  <a href="#development">Development</a> •
  <a href="#troubleshooting">Troubleshooting</a> •
  <a href="#roadmap">Roadmap</a> •
  <a href="#support">Support</a>
</p>

## 📋 Overview

RCV Technologies Recruitment Portal is a comprehensive web application designed to streamline and enhance the recruitment process within our Human Resource Management System (HRMS). Built using cutting-edge technologies, this portal simplifies candidate management, job posting, and hiring workflows for HR professionals and hiring managers alike.

## ⚡ Quick Start

```bash
# Clone the repository
git clone https://github.com/rcv-technologies/recruitment-portal.git
cd recruitment-portal

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate

# Create admin user
php artisan user:create

# Seed the database with initial data
php artisan module:seed Recruitment

# Compile assets and run server
npm run dev
php artisan serve

# Start queue for mail to work
php artisan queue:work
```

## ✨ Features

### 👤 Candidate Management

-   **Comprehensive profiles** - Store complete candidate information in one place
-   **Smart resume parsing** - Automatically extract key data from uploaded resumes
-   **Skill matching** - Tag and filter candidates based on required skills
-   **Status tracking** - Real-time updates on candidate application progress

### 📝 Job Posting & Tracking

-   **Dynamic job listings** - Create and modify job postings with rich formatting
-   **Department categorization** - Organize openings by team, location, and type
-   **Automated screening** - Set qualification filters to prioritize applications
-   **Application pipeline** - Track candidates through each stage of recruitment

### 🗓️ Interview Management

-   **Smart scheduling** - Integrate with calendars for conflict-free booking
-   **Customizable evaluation forms** - Create role-specific assessment criteria
-   **Panel coordination** - Manage multiple interviewers and feedback collection
-   **Performance analytics** - Generate insights from interview outcomes

### 📊 Reporting & Analytics

-   **Visual dashboards** - Monitor recruitment metrics with interactive charts
-   **Source effectiveness** - Track which channels bring the best candidates
-   **Time optimization** - Analyze and improve time-to-hire and other KPIs
-   **Custom reports** - Generate tailored reports for stakeholders

## 🛠️ Tech Stack

### Backend Framework

-   **Laravel 11.x** - PHP framework for robust application architecture
-   **PHP 8.1+** - Latest language features for optimal performance
-   **MySQL Database** - Reliable data storage and retrieval

### Frontend Technologies

-   **Tailwind CSS** - Utility-first CSS framework for responsive design
-   **Alpine.js** - Lightweight JavaScript framework for dynamic interfaces
-   **jQuery** - Simplified DOM manipulation
-   **Chart.js** - Interactive data visualization

### Development Tools

-   **PHPUnit** - Comprehensive testing framework
-   **npm** - Package management for JavaScript dependencies

## 📥 Installation

### System Requirements

-   PHP 8.1 or higher
-   Composer 2.0+
-   Node.js 22+ and npm
-   MySQL 5.7+ or MariaDB 10.2+
-   Web server (Nginx or Apache)

### Detailed Installation Steps

1. **Clone the repository**

    git clone https://github.com/rcv-technologies/recruitment-portal.git
    cd recruitment-portal

2. **Install PHP dependencies**

    composer install

3. **Install JavaScript dependencies**

    npm install

4. **Configure environment**

    cp .env.example .env
    php artisan key:generate

5. **Edit the .env file** with your database credentials and other configuration

6. **Run database migrations**

    php artisan migrate

7. **Create admin user**

    php artisan user:create

8. **Seed the database with initial data**

    php artisan module:seed Recruitment

9. **Compile assets**

    npm run dev

10. **Start the development server**
    php artisan serve

## 🔒 Security

-   **Multi-role authentication** - Role-based access control for different user types
-   **Secure token authentication** - JWT implementation for API security
-   **Data encryption** - Protection for sensitive candidate information
-   **CSRF protection** - Guards against cross-site request forgery
-   **Input validation** - Comprehensive data validation and sanitation

## ⚙️ Configuration

### Key .env Variables

APP_NAME="RCV Recruitment Portal"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recruitment_portal
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="recruitment@rcvtechnologies.com"

QUEUE_CONNECTION=database

FILESYSTEM_DISK=local

## 🧪 Testing

Run the comprehensive test suite:

php artisan test

For specific test groups:

php artisan test --group=candidates
php artisan test --group=jobs
php artisan test --group=interviews

## 🚀 Deployment

### Recommended Setup

-   **Web Server**: Nginx with PHP-FPM
-   **Database**: MySQL on dedicated server
-   **Caching**: Redis for improved performance
-   **Queue Worker**: Supervisor for reliable job processing

### Docker Deployment

Docker configuration is available in the repository:

docker-compose up -d

## 📈 Roadmap

-   **Q2 2025**: AI-powered candidate matching and recommendation engine
-   **Q3 2025**: Integration with major job boards (Indeed, LinkedIn, Glassdoor)
-   **Q4 2025**: Advanced analytics dashboard with predictive hiring insights
-   **Q1 2026**: Mobile application for on-the-go recruitment management

## 🤝 Contributing

Please read our [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## 🛠️ Development

### Asset Compilation

The project uses Vite for asset compilation. Here are the key commands:

```bash
# Development build with hot reloading
npm run dev

# Production build
npm run build

# Production build with cache clearing
npm run build -- --force
```

### Common Development Tasks

```bash
# Clear all caches
php artisan optimize:clear

# Generate IDE helpers
php artisan ide-helper:generate
php artisan ide-helper:models
php artisan ide-helper:meta

# Run code style fixer
./vendor/bin/pint
```

### Module Development

The project uses a modular structure. To create a new module:

```bash
php artisan module:make ModuleName
```

## 🔧 Troubleshooting

### Common Issues

1. **CSS Build Issues**

    - Clear Vite cache: `rm -rf node_modules/.vite`
    - Clear npm cache: `npm cache clean --force`
    - Reinstall dependencies: `npm install`
    - Force rebuild: `npm run build -- --force`

2. **Database Issues**

    - Clear migrations: `php artisan migrate:fresh`
    - Reseed database: `php artisan module:seed Recruitment`

3. **Cache Issues**
    - Clear all caches: `php artisan optimize:clear`
    - Clear view cache: `php artisan view:clear`
    - Clear config cache: `php artisan config:clear`

### Debugging

-   Enable debug mode in `.env`: `APP_DEBUG=true`
-   Check Laravel logs: `tail -f storage/logs/laravel.log`
-   Check Vite logs in browser console

## 📞 Support

For any queries or technical support:

-   **Email**: [support@rcvtechnologies.com](mailto:support@rcvtechnologies.com)
-   **Website**: [www.rcvtechnologies.com](https://www.rcvtechnologies.com)
-   **Documentation**: [docs.rcvtechnologies.com/recruitment](https://docs.rcvtechnologies.com/recruitment)
-   **Issue Tracker**: [GitHub Issues](https://github.com/rcv-technologies/recruitment-portal/issues)

## 📄 License

This software is proprietary and confidential. Unauthorized copying, transferring or reproduction of the contents of this software, via any medium is strictly prohibited. The receipt or possession of the source code and/or any parts thereof does not convey or imply any right to use them for any purpose other than the purpose for which they were provided to you.

Copyright © 2025 RCV Technologies. All rights reserved.
