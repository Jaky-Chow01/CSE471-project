# BloodConnect: Real-Time Blood Coordination and Emergency Management System

**Course:** CSE471: System Analysis and Design
**Section:** 04 | **Group:** 01
**Semester:** Spring 2026

---

## Project Description

BloodConnect is a unified, web-based platform designed for real-time coordination between blood requesters, verified donors, and healthcare institutions. It combines the work of Jaky, Rameeza, and Mashfi to address delays in medical emergencies by automating donor matching based on proximity, blood type, and eligibility. It ensures a secure and efficient ecosystem with identity verification and hospital-side validation.

---

## Technical Specifications

* **Backend:** PHP 8.x, Laravel Framework, Eloquent ORM
* **Database:** MySQL
* **Frontend:** Laravel Blade, Tailwind CSS
* **External APIs:** Google Maps (Distance, Directions, Places), Twilio SMS, Mailgun/SMTP, QR Generation API
* **Verification:** Simulated NID API for donor authentication

---

## Functional Modules & Team Contributions

| Module                 | Feature                                                 | Lead Developer      |
| :--------------------- | :------------------------------------------------------ | :------------------ |
| **Request Management** | Emergency Submission, Route Optimization, Leaderboard   | Jaky (22201616)     |
| **Donor Operations**   | Registration, Document Upload, Cross-Match, QR Receipts | Rashadat (21301544) |
| **System Tracking**    | Map Search, ID Verification, Notifications              | Rameezah (21201505) |
| **Analytics & Logic**  | Donor Matching Engine, Hospital Dashboard, Analytics    | Mashfiq (22101272)  |

---

## Version Control Strategy

We use a **Feature Branching** workflow:

* **Branching Structure:**

  * `main`: Stable, production-ready code.
  * `dev-[name]`: Individual branches for development.

* **Workflow:**

  * Development occurs in separate branches.
  * Verified features are merged into `main`.
  * Direct commits to `main` are restricted.

---

## Installation & Setup

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/Jaky-Chow01/CSE471-project.git
   cd bloodconnect
   ```
2. **Install Dependencies:**

   ```bash
   composer install
   npm install && npm run build
   ```
3. **Environment Configuration:**
   Configure the `.env` file with database credentials and API keys.
4. **Database Migration:**

   ```bash
   php artisan migrate --seed
   ```
5. **Local Launch:**

   ```bash
   php artisan serve
   ```

Open **[http://localhost:8000](http://localhost:8000)**.

---

## Development Team

* Jaky Ahmed Chowdhury (22201616)
* Md Rashadat Abdullah Rahman (21301544)
* Rameezah Rahman Yeasha (21201505)
* Mashfiq Ferdaus Ahmed (22101272)

---

## Routes & Structure

| URL                   | Feature                                  | By   |
| --------------------- | ---------------------------------------- | ---- |
| `/`                   | Home (Live Blood Requests + Leaderboard) | Jaky |
| `/find-blood`         | Submit Blood Request                     | Jaky |
| `/blood-banks`        | Blood Bank Directory                     | Jaky |
| `/diagnostic-centers` | Diagnostic Center Directory              | Jaky |
| `/blood-types`        | Blood Type Guide                         | Jaky |
