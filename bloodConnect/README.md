# BloodConnect: Real-Time Blood Coordination and Emergency Management System

**Course:** CSE471: System Analysis and Design  
**Section:** 04 | **Group:** 01  
**Semester:** Spring 2026

---

## Project Description
BloodConnect is a web-based integrated platform designed to facilitate real-time coordination between blood requesters, verified donors, and healthcare institutions. The system addresses critical delays in emergency medical situations by automating the donor matching process based on geographical proximity, blood group compatibility, and donor eligibility. By integrating identity verification protocols and hospital-side validation, the platform ensures a transparent, secure, and efficient ecosystem for blood management.

---

## Technical Specifications
*   **Backend:** PHP 8.x, Laravel Framework, Eloquent ORM.
*   **Database:** MySQL.
*   **Frontend:** Laravel Blade, Tailwind CSS.
*   **External APIs:** Google Maps (Distance Matrix, Directions, Places), Twilio SMS, Mailgun/SMTP, QR Generation API.
*   **Verification:** Simulated National ID (NID) API for donor authentication.

---

## Functional Modules and Responsibility Matrix

| Module | Feature | Lead Developer |
| :--- | :--- | :--- |
| **Request Management** | Emergency Submission, Route Optimization, Leaderboard | Jaky (22201616) |
| **Donor Operations** | Registration, Document Upload, Cross-Match, QR Receipts | Rashadat (21301544) |
| **System Tracking** | Map Search, ID Verification, Progress Tracking, Notifications | Rameezah (21201505) |
| **Analytics & Logic** | Matching Engine, Hospital Dashboard, Analytics | Mashfiq (22101272) |

---

## Version Control Strategy
The repository implements a **Feature Branching** workflow to maintain code integrity.

*   **Branching Structure:**
    *   `main`: Stable, production-ready code for final submission.
    *   `dev-[name]`: Individual branches for active development and testing.
*   **Workflow:**
    *   Development occurs in isolated developer branches.
    *   Completed features are merged into `main` after verification.
    *   Direct commits to the `main` branch are restricted to ensure system stability.

---

## Installation and Setup

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/username/bloodconnect.git
    cd bloodconnect
    ```
2.  **Install Dependencies:**
    ```bash
    composer install
    npm install && npm run build
    ```
3.  **Environment Configuration:**
    Configure the `.env` file with database credentials and the necessary API keys for Google Maps and Twilio.
4.  **Database Migration:**
    ```bash
    php artisan migrate --seed
    ```
5.  **Local Launch:**
    ```bash
    php artisan serve
    ```

---

## Development Team
*   Jaky Ahmed Chowdhury (22201616)
*   Md Rashadat Abdullah Rahman (21301544)
*   Rameezah Rahman Yeasha (21201505)
*   Mashfiq Ferdaus Ahmed (22101272)