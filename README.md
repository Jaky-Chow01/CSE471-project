# bloodConnect — Combined Project

A unified Laravel blood donation platform combining the work of **Jaky**, **Rameeza**, and **Mashfi** for CSE471.

---

## 👥 Team Contributions

| Member | Features |
|--------|----------|
| **Jaky** | Home dashboard, Blood requests (CRUD + live announcements + map), Blood banks, Diagnostic centers, Blood types, Leaderboard, Donations |
| **Rameeza** | Donor map search (Leaflet + Haversine), NID verification portal, Auth (donor/requester/admin), Live donation tracking (5-stage pipeline + email) |
| **Mashfi** | Donor matching engine, Post-donation care panel (hydration/rest/nutrition/recovery clocks), Hospital dashboard, Analytics dashboard |

---

## 🎨 Style
All views use **Jaky's** design system:
- **Font:** Plus Jakarta Sans
- **Palette:** `#fdf2f2` warm background, `#dc2626` red accent, white glassmorphism cards
- **Components:** `bg-white/80 backdrop-blur-md rounded-[2.5rem]` cards, floating blood particles, Tailwind CSS

---

## 🗄 Database
One unified MySQL database: **`bloodconnect`**

Tables created by migrations:
- `users`, `sessions`, `password_reset_tokens` (Laravel auth)
- `bloodtypes`, `bloodbanks`, `diagonosticcenters`, `bloodrequests`, `donations`, `posts` *(Jaky)*
- `donors`, `donation_requests`, `nid_verifications`, `blood_notifications` *(Rameeza)*
- `donor_care` *(Mashfi)*

---

## 🚀 Setup

```bash
# 1. Clone / extract project
cd bloodConnect

# 2. Install PHP dependencies
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Create database
mysql -u root -p -e "CREATE DATABASE bloodconnect CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 5. Run migrations + seeders
php artisan migrate --seed

# 6. (Optional) Install JS deps
npm install && npm run build

# 7. Start server
php artisan serve
```

Open **http://localhost:8000**

---

## 🗺 Routes

| URL | Feature | By |
|-----|---------|-----|
| `/` | Home — live blood request announcements + leaderboard | Jaky |
| `/find-blood` | Submit blood request | Jaky |
| `/blood-banks` | Blood bank directory | Jaky |
| `/diagnostic-centers` | Diagnostic center directory | Jaky |
| `/blood-types` | Blood type compatibility guide | Jaky |
| `/leaderboard` | Top donors by donation volume | Jaky |
| `/find-donors` | Map-based donor search | Rameeza |
| `/login` | Track donation (donor/requester/admin login) | Rameeza |
| `/track` | Live 5-stage donation tracker (admin) | Rameeza |
| `/admin` | NID verification portal | Rameeza |
| `/dashboard` | Advanced dashboard (matching, care, hospital, analytics) | Mashfi |

---

## 📁 Structure

```
app/
  Http/Controllers/
    BloodrequestsController.php   # Jaky
    BloodbanksController.php      # Jaky
    DiagonosticcentersController.php # Jaky
    LeaderboardController.php     # Jaky
    RouteController.php           # Jaky
    DonorController.php           # Rameeza
    AuthController.php            # Rameeza
    TrackingController.php        # Rameeza
    NidController.php             # Rameeza
    DashboardController.php       # Mashfi (all 4 modules)
  Models/
    bloodrequests, bloodbanks, diagonosticcenters, bloodtype, Donation, User  # Jaky
    Donor, DonationRequest, BloodNotification, NidVerification               # Rameeza
database/migrations/            # All 14 migrations unified
database/seeders/               # Combined seed data
resources/views/                # All views with Jaky's style
```
