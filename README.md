## UMD – Medicine Donation Platform (Laravel)

This is a Laravel application for coordinating unused-medicine donations between Donators and NGOs, operated by Admins and NGO staff. It supports user roles, donation workflows, medicine verification, stock management, and feedback.

### Tech Stack
- Laravel (PHP)
- SQLite (default) – a single file database at `database/database.sqlite`
- Blade views in `resources/views`
- Auth guards for multiple roles (`admin`, `donator`, `manager`, `pickupman`, `verifier`)

### Local Setup
1) Install PHP extensions (pdo_sqlite, openssl, mbstring, tokenizer, xml, ctype, json). With XAMPP they are typically available.
2) From the project root:
   - Copy env: `cp .env.example .env` (already present in this repo).
   - Ensure DB is SQLite: `DB_CONNECTION=sqlite` and `DB_DATABASE` points to the full path of `database/database.sqlite`.
   - Generate key (if not set): `php artisan key:generate`.
   - Create the SQLite file if missing: create an empty file at `database/database.sqlite`.
   - Migrate: `php artisan migrate`.
3) Run the app: `php artisan serve` and browse `http://127.0.0.1:8000`.

If you see “Database (database/database.sqlite) does not exist”, set `DB_DATABASE` to the absolute path of the file, then `php artisan config:clear`.

### Modules (Eloquent Models)
- Admin (`app/Admin.php`)
- Ngo (`app/Ngo.php`)
- Manager (`app/Manager.php`)
- Verifier (`app/Verifier.php`)
- Pickupman (`app/Pickupman.php`)
- Donator (`app/Donator.php`)
- Donation (`app/Donation.php`), DonationMedicine, DonationMedicineExpiration
- Medicine (`app/Medicine.php`), MedicineCategory, MedicineStock, MedicineStockExpiration
- Feedback, BadFeedback, FeedbackCategory, Message

### Main Sections and How to Access
- Public site (Donator-facing)
  - Home: GET `/` (route name `MedCharity`)
  - About: GET `/about`
  - Contact: GET `/contact`, POST `/contactmessage`
  - Register (Donator): GET `/register`, POST `/register`
  - Login (Donator): GET `/login`, POST `/login`
  - Forgot/Create Password: `/forgotpassword`, `/createpassword`
  - Authenticated Donator:
    - Donate: GET/POST `/donate`
    - View donations: GET `/donations`
    - Profile & Change Password: `/profile`, `/changepassword`
    - Logout: GET `/logout`

- Admin panel
  - Login: GET `/admin/login`, POST `/admin/login`
  - After login: GET `/admin`
  - NGO management: `/admin/registerngo` (GET/POST), `/admin/displayngos`, edit/update/delete routes
  - Manager management: `/admin/registermanager` (GET/POST), `/admin/displaymanagers`, edit/update/delete
  - Donator moderation: `/admin/managedonators`, block/warn routes
  - Medicine stock overview: `/admin/medicinestock` (POST category select)
  - Donation history: `/admin/donationhistory`
  - Messages: `/admin/messages` and `/admin/messages/{id}`

- NGO > Manager area (under `/ngo/manager`)
  - Login/Create/Forgot password: `/ngo/manager/login`, `/ngo/manager/createpassword`, `/ngo/manager/forgotpassword`
  - Dashboard (after login): `/ngo/manager/`
  - Pickupmen management: register/list/edit/update/delete
  - Verifier management: register/list/edit/update/delete
  - Donation operations: picked up donations, DPD updates, donation history
  - Medicine stock management and expiries

- NGO > Pickupman area (under `/ngo/pickupman`)
  - Login/Create/Forgot password
  - Dashboard (after login)
  - Pending/Taken donations handling and status updates

- NGO > Verifier area (under `/ngo/verifier`)
  - Login/Create/Forgot password
  - Dashboard (after login)
  - Take pending donations, add medicines, move to stock
  - Give feedback, add medicine categories

### Authentication & Guards
Defined routes live in `routes/web.php`. Multi-auth is implemented using guards (`config/auth.php`) and role-specific controllers in `app/Http/Controllers/Auth/`:
- `LoginController` provides role-specific login and create-password flows.
- `RegisterController` handles Donator registration and admin-assisted registrations for NGO staff.
- `LogoutController` handles role-specific logout endpoints.

Middleware `auth:<guard>` protects each role’s area. Example: manager routes use `auth:manager`.

### API
`routes/api.php` exposes a single example route:
- GET `/api/user` (requires `auth:api` token). Out-of-the-box this returns the authenticated API user when token auth is configured. If you need richer APIs, add them here or convert web routes as needed.

### Common Operational Tasks
- Clear caches after changing `.env`:
  - `php artisan config:clear`
  - `php artisan cache:clear`
- Run database migrations: `php artisan migrate`
- Seed data (add your own seeders in `database/seeds` and call them from `DatabaseSeeder`)

### Default Credentials
No default users are hard-coded. Use Admin to create NGO staff, or register as a Donator via `/register`.

### Project Structure Highlights
- Routes: `routes/web.php`, `routes/api.php`
- Controllers: `app/Http/Controllers` (Admin, Donator, Manager, Pickupman, Verifier, and Auth controllers)
- Models: `app/*.php`
- Views: `resources/views`
- Public assets: `public`

### Troubleshooting
- Error: “Database (database/database.sqlite) does not exist”
  - Ensure the file exists at `database/database.sqlite`.
  - Point `DB_DATABASE` to the absolute path of the file.
  - Run `php artisan config:clear` and refresh.
- 500 on auth pages
  - Ensure `APP_KEY` is set in `.env`.
- Styling/JS not loading in XAMPP
  - Access via `http://127.0.0.1:8000` and ensure `APP_URL` matches.


## Getting started

copy env file

    .env.example to .env

As a temporary fix, try this, it worked for me, in the following file:

    vendor/laravel/framework/src/Illuminate/Foundation/PackageManifest.php

Find line 116 and comment it:

    $packages = json_decode($this->files->get($path), true);

Add two new lines after the above commented line:

    $installed = json_decode($this->files->get($path), true);
    $packages = $installed['packages'] ?? $installed;

Install dependency for project

    composer install

Create Table structure using migration

    php artisan migrate:fresh

Run your project

    php artisan serve