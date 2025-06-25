# 🔧 Timetrix - Automated Academic Scheduling System

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php&logoColor=white)](https://php.net)

> **Timetrix** is a Laravel-powered academic scheduling platform that automates teaching timetable generation, workload management, and institutional reporting with dynamic filters and branded PDF exports.

![Timetrix Dashboard Preview](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/Dashboard.png)

---

## 📋 Table of Contents

- [🧩 Overview](#-overview)
- [🚀 Key Features](#-key-features)
- [✅ Requirements](#-requirements)
- [🛠 Installation](#-installation)
- [⚙️ Configuration](#️-configuration)
- [▶️ Usage](#️-usage)
- [📸 Screenshots](#-screenshots)
- [🧪 Development](#-development)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)
- [🙋‍♂️ Author](#-author)

---

## 🧩 Overview

Timetrix helps institutions automate the generation of teaching timetables with:

- ✅ Conflict-free course scheduling  
- 🏫 Intelligent room allocation  
- 🧑‍🏫 Instructor workload reporting  
- 🧠 Dynamic filtering with faculty-department hierarchy  
- 📄 Branded PDF timetable and report exports

Built on Laravel, it supports both admin and academic users with role-based access control.

---

## 🚀 Key Features

### 📅 Core Scheduling

- Auto-generated master timetables  
- Session splitting (3hr, 2+1hr, or 1+1+1hr)  
- Classroom allocation based on enrollment and room capacity  

### 🔍 Data Insights

- Instructor workload reports  
- Course offering summaries  
- Student enrollment analytics  
- Department-specific schedule previews  

### 🛠 Productivity Tools

- PDF export with institutional branding  
- Dynamic timetable filters (Faculty → Department → Course → Instructor)  
- Email verification and OTP-based login  
- System activity auditing  

---

## ✅ Requirements

### Server Environment

- PHP 8.1+  
- MySQL 8+  
- Node.js 18+  
- Composer 2.x  

### Optional Dependencies

- Redis (queues & caching)  
- Laravel Breeze (authentication scaffolding)

---

## 🛠 Installation

```bash
# Clone repository
git clone https://github.com/Mortal-man/Timetrix.git
cd Timetrix/Timetrix

# Install backend dependencies
composer install

# Install frontend assets
npm install && npm run dev

# Set environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed default data
php artisan migrate --seed

# Start local server
php artisan serve
```

---

## ⚙️ Configuration

Update your `.env` file with your application and database settings:

```env
APP_NAME="Timetrix"
APP_URL=http://localhost
APP_TIMEZONE=Africa/Nairobi

DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=null
```

---

## ▶️ Usage

1. Register a new user account  
2. Verify email (OTP-enabled if configured)  
3. Navigate through:

- 📊 **Dashboard**: View statistics  
- 📚 **Courses / Instructors**: Manage academic data  
- 🗓 **Timetable**: View or generate teaching schedules  
- 📄 **Reports**: Export instructor workloads, course offerings, etc.  

4. Apply filters to personalize schedule views  
5. Export to PDF or share with stakeholders

---

## 📸 Screenshots

> _Actual screenshots from the system interface:_

### 📊 Welcome Page  
![Welcome Page](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/Welcome%20page.png)

### 🔐 Login Page  
![Login](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/Login.png)

### ⏳ OTP Authentication  
![OTP Auth](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/OTP%20auth.png)

### 🕒 Master Timetable Preview  
![Timetable](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/Sample%20MAster%20Timetable.png)

### 📚 Reports  
![Reports](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/Reports.png)

### 📄 PDF Export  
![PDF Export](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/Sample%20PDF%20Report.png)

### 🏛 Institution Details  
![Institution](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/Institution%20Details.png)

### 🚩 System Audit  
![Audit](https://github.com/Mortal-man/Timetrix/blob/main/Timetrix/public/images/screenshots/System%20Audit.png)

---

## 🧪 Development

To run tests:

```bash
php artisan test
```

Optional enhancements:

- Use Laravel Telescope for debugging  
- Set up Horizon for queue monitoring  
- Schedule tasks with:  
  ```bash
  * * * * * php artisan schedule:run >> /dev/null 2>&1
  ```

---

## 🤝 Contributing

We welcome contributions!  
To contribute:

1. Fork the repository  
2. Create a feature branch: `git checkout -b feature/your-feature`  
3. Push and open a Pull Request  
4. Follow Laravel's [code style guide](https://laravel.com/docs/contributions#coding-style)

---

## 📄 License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

## 🙋‍♂️ Author

**Emmanuel Otieno Oduor**  
📫 [Portfolio](https://emman-exe.netlify.app)
