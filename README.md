# BloodLink — XAMPP Setup Guide

## Project Structure
```
bloodlink/
├── index.php           ← Main frontend (served by Apache)
├── bloodlink.sql       ← Database schema + seed data
├── config/
│   └── db.php          ← Database credentials
└── api/
    └── api.php         ← All backend API endpoints
```

## Step 1 — Copy files to XAMPP
Copy the entire `bloodlink/` folder to:
- **Windows:** `C:\xampp\htdocs\bloodlink\`
- **Mac/Linux:** `/opt/lampp/htdocs/bloodlink/`

## Step 2 — Start XAMPP
Open XAMPP Control Panel → Start **Apache** and **MySQL**

## Step 3 — Import the database
1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click **Import** in the top menu
3. Choose the file: `bloodlink.sql`
4. Click **Go**

   *Or use the terminal:*
   ```bash
   mysql -u root -p < bloodlink.sql
   ```

## Step 4 — Open the app
Visit: **http://localhost/bloodlink/**

---

## API Endpoints (api/api.php)

| Action               | Method | Parameters                        | Description                     |
|----------------------|--------|-----------------------------------|---------------------------------|
| `get_donors`         | GET    | `blood_group`, `location`, `available` | List/filter donors         |
| `get_donor`          | GET    | `id`                              | Single donor profile            |
| `get_care`           | GET    | `donor_id`                        | Care schedule for a donor       |
| `save_care`          | POST   | JSON body with schedule fields    | Upsert care schedule            |
| `register_donor`     | POST   | JSON body with donor fields       | Add new donor                   |
| `get_requests`       | GET    | —                                 | Active blood requests (sidebar) |
| `get_stats`          | GET    | —                                 | Dashboard stat numbers          |
| `toggle_availability`| POST   | `id`                              | Toggle donor availability       |

## Database Tables
- **donors** — donor profiles with GPS, blood group, contact info
- **donor_care** — per-donor hydration/rest/nutrition schedules
- **blood_requests** — active hospital blood requests

## Troubleshooting
- **Blank page / DB error:** Check `config/db.php` — default is `root` with empty password
- **Map not loading:** Requires internet (loads from OpenStreetMap CDN)
- **Fonts not loading:** Requires internet (loads from Google Fonts CDN)
