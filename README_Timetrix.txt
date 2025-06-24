
Timetrix – Institutional Timetable Management System
====================================================

Timetrix is a Laravel-based web application designed to help academic institutions manage and automate class timetabling efficiently.

REQUIREMENTS
------------
Ensure the following dependencies are installed before setting up Timetrix:

- PHP 8.1 or higher
- Composer (Dependency Manager for PHP)
- Laravel 11.x
- MySQL or MariaDB
- Node.js & npm (for compiling frontend assets)
- Git (for cloning the repository)
- A Web Server (Apache, Nginx, or Laravel's built-in server)
- Laravel Breeze (already included for authentication scaffolding)

INSTALLATION GUIDE
------------------

1. Clone the Repository
   ---------------------
   git clone https://github.com/yourusername/timetrix.git
   cd timetrix

2. Install PHP Dependencies
   ------------------------
   composer install

3. Install JavaScript Dependencies
   -------------------------------
   npm install

4. Environment Setup
   -----------------
   - Duplicate `.env.example` and rename it to `.env`.
     cp .env.example .env

   - Generate application key:
     php artisan key:generate

5. Configure `.env` File
   ----------------------
   Update the following variables in your `.env` file:

   APP_NAME="Timetrix"
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=timetrix
   DB_USERNAME=your_db_username
   DB_PASSWORD=your_db_password

   Note: Create the `timetrix` database manually in MySQL before running migrations.

6. Run Migrations and Seeders
   ---------------------------
   php artisan migrate --seed

7. Compile Frontend Assets
   ------------------------
   npm run dev

   For production:
   npm run build

8. Start the Development Server
   -----------------------------
   php artisan serve

   The application will be accessible at:
   http://localhost:8000

EMAIL VERIFICATION (OPTIONAL)
-----------------------------
To test email verification locally, use tools like:

- Mailtrap (https://mailtrap.io/)
- Mailhog (https://github.com/mailhog/MailHog)

Example SMTP config in `.env`:

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@timetrix.test
MAIL_FROM_NAME="Timetrix"

PROJECT STRUCTURE HIGHLIGHTS
----------------------------
- app/Models – Eloquent models
- app/Http/Controllers – Route controllers
- resources/views – Blade templates
- resources/js – JavaScript & Alpine.js components
- routes/web.php – Web routes
- database/migrations – Table structure
- database/seeders – Seed test/admin data

COMMON ARTISAN COMMANDS
------------------------
- Clear config/cache:
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear

- Create symbolic link for file storage:
  php artisan storage:link

DEFAULT ADMIN LOGIN (IF SEEDED)
-------------------------------
Email:    test@example.com
Password: password

LICENSE
-------
Timetrix is open-source and available under the MIT License.

SUPPORT
-------
For issues or feature requests, open an issue in the repository.
