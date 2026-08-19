# AKHANDA BHARATHA VISWA HINDU PARIRAKSHANA SAMITI (ABVHPS)
### Central Digital Governance & Devotee Administration Portal

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel Framework](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?logo=vite&logoColor=white)](https://vitejs.dev)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Test Suite](https://img.shields.io/badge/Tests-140%20Passed-success?logo=phpunit&logoColor=white)](tests/)
[![License](https://img.shields.io/badge/License-Proprietary-orange.svg)](#license)

---

## 📌 Executive Summary

**ABVHPS** (*Akhanda Bharatha Viswa Hindu Parirakshana Samiti*) is an institutional-grade, monolithic digital platform developed to manage large-scale socio-cultural initiatives, devotee registries, youth cadre mobilizations, statutory compliance, multi-tier volunteer administration, examinations, and holy Dharma Seva fundraising campaigns across India.

---

## 🏛️ Core System Architecture

```
                                  ┌───────────────────────────────┐
                                  │      Public Devotees & Users  │
                                  └───────────────┬───────────────┘
                                                  │
                ┌─────────────────────────────────┴─────────────────────────────────┐
                │                                                                   │
    ┌───────────▼───────────┐                                           ┌───────────▼───────────┐
    │  Public Portal Desks  │                                           │  QR Anti-Fraud Engine │
    │  • Membership / OTP   │                                           │  • /verify/{entity}/  │
    │  • Exam Applications  │                                           │  • Dynamic DB Lookup  │
    │  • Wing Registrations │                                           │  • Zero-PII Exposure  │
    │  • Dharma Seva Ledger │                                           └───────────────────────┘
    └───────────┬───────────┘
                │
┌───────────────▼────────────────┐                             ┌───────────────────────────────┐
│     Laravel Application Core   │◄────────────────────────────┤    Multi-Guard Auth Matrix    │
│     (PHP 8.2+ / MVC Engine)    │                             │    • web: Admin Commander     │
└───────────────┬────────────────┘                             │    • volunteer: 6-Digit ID    │
                │                                              └───────────────────────────────┘
  ┌─────────────┼─────────────┬─────────────┐
  │             │             │             │
┌─▼────────┐  ┌─▼────────┐  ┌─▼────────┐  ┌─▼────────┐
│ Database │  │ AuditLog │  │ NotifSvc │  │ Storage  │
│  MySQL / │  │ Redacted │  │ Multi-   │  │ Local /  │
│  SQLite  │  │ Logs     │  │ Channel  │  │ AWS S3   │
└──────────┘  └──────────┘  └──────────┘  └──────────┘
```

---

## 🔱 Key Platform Modules

### 1. 💳 Life Membership Management
- **Mobile OTP Authentication:** Two-step SMS verification with automatic 5-minute TTL.
- **12-Digit Automatic Unique Key Code:** Dynamic unique identification matrix (e.g., `4318 2764 1156`).
- **PVC Digital ID Card Desk:** High-resolution digital ID card rendering with instant printable vector layouts and embedded dynamic QR codes.
- **Multilingual Support:** Intelligent language auto-assignment (`Telugu`, `Kannada`, `English`) based on applicant region.

### 2. 🛡️ Dedicated Volunteer Portal (`/volunteer/login`)
- **6-Digit Login Architecture:** Synchronized `volunteer_id` and `volunteer_login_id` for approved cadres.
- **Security & Password Policy:** Mandatory first-login password reset (`must_change_password`), session invalidation on logout, and brute-force throttling (5 attempts/min).
- **Hierarchical Jurisdiction Desks:** Village, Mandal, Assembly Segment, District, State, and Global Overseer control desks.
- **Area-Wise Member Data Explorer:**
  - Cascading area selection (District &rarr; Mandal &rarr; Grama Panchayat).
  - Search and preview up to 100 members in real time.
  - **Secure PDF & CSV Export Desk:** Filtered member rosters containing strictly approved public fields (*Name, Gender, Photo, Membership ID, Region*). **Aadhaar, contact numbers, emails, and database keys are never exposed.**
  - Comprehensive audit trail recording all download operations.

### 3. 📝 Examination Portal & Hall Ticket Engine
- **Multi-Exam Lifecycle Management:** Create and schedule multiple examinations with custom exam types (`Theory`, `MCQ`, `Both`), center locations, guidelines, and cash prizes/awards.
- **Exam-Specific Syllabus Repository:** Direct streaming of downloadable syllabus PDFs tied directly to each specific exam setting.
- **Anti-Fraud Parent Eligibility Gate:** Server-side verification enforcing that candidate parent/guardian membership IDs are verified before accepting payment or submissions.
- **11-Digit Unique Hall Ticket Generator:** Collision-safe randomized 11-digit hall ticket numbers (e.g., `84729103847`).
- **Exam Result Announcement & Winners Wall:**
  - Administrative draft result entry (marks obtained, total marks, percentage, grade, remarks).
  - One-click bulk publication triggering email, in-app, and WhatsApp notification loggers with per-channel idempotency.
  - Public results lookup by 11-digit hall ticket number (draft results remain strictly hidden).
  - Top 6 Winners Showcase Wall.

### 4. ⚔️ Rudra Sena Youth Command (`/rudrasena-apply`)
- Dedicated registration for volunteer commandos and cultural defense forces.
- Unique sequential ID matrix formatting: `RS0001`, `RS0002`, ...
- Administrative dossier view, approval workflow, PDF ID card download, and QR verification.

### 5. 🌾 Local GP Gateway Wings (`/admin/local-gateways`)
- **Organic Farmers Agriculture Wing (`OF-XXXXXX`):** Desi agriculture registration, multi-crop mapping, native cow counts, and digital Green Certification issuance.
- **Kala Brundam Cultural Wing (`KB-XXXXXX`):** Folk artist and cultural team registration, performing arts categorization, and troop strength tracking.
- **Grama Seva Dal Village Wing (`GSD-XXXXXX`):** Grama Panchayat youth service force roster, seva history recording, and identity verification.

### 6. 📜 Dharma Seva Fundraising & Legal Ledger
- Multi-media campaigns supporting up to 4 high-res gallery images and field explainer briefing videos.
- Dynamic financial progress bars, real-time targets vs. raised amounts, and native WhatsApp/Facebook social share links.
- Devotee Legal Donation Ledger with automated 80G tax-exemption digital cash receipt PDF generator (`ABVHPS-TXN-XXXXXX`).

### 7. 👑 Central Administrative Control Desk (`/admin/login`)
- Unified commander dashboard with live metric counters across all wings.
- Page-Wise Banner Management Engine with device-aware mobile/desktop image serving.
- Contact message tracker with note-taking and resolution state logs.
- Statutory compliance certificates desk (10AC, 12A, 80G, CSR).

---

## 🆔 Master Identity Schema

| Entity | ID Format | Example | Uniqueness | Public Verification |
|---|---|---|---|---|
| **Life Membership** | 12-Digit Numeric | `9224 9312 1520` | Unique (DB Index) | `/verify/membership/{id}` |
| **Volunteer** | 6-Digit Numeric | `849201` | Unique (DB Index) | `/verify/volunteer/{id}` |
| **Rudra Sena Member** | `RS` + 4 Digits | `RS0001` | Unique (DB Index) | `/verify/rudrasena/{id}` |
| **Exam Hall Ticket** | 11-Digit Numeric | `84729103847` | Unique (DB Index) | `/verify/exam/{ticket}` |
| **Organic Farmers Group** | `OF-` + 6 Digits | `OF-583214` | Unique (DB Index) | `/verify/organic-farmers/{id}` |
| **Kala Brundam Group** | `KB-` + 6 Digits | `KB-194820` | Unique (DB Index) | `/verify/kala-brundham/{id}` |
| **Grama Seva Dal Group** | `GSD-` + 6 Digits | `GSD-720194` | Unique (DB Index) | `/verify/grama-seva-dal/{id}` |

---

## 🔒 Security Hardening Matrix

- **HTTP Security Headers:** `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy: strict-origin-when-cross-origin`, strict `Content-Security-Policy`, and `HSTS` on HTTPS.
- **Audit Logging Subsystem:** Centralized logging of all administrative actions, exports, status updates, and logins with automatic PII sanitization.
- **Rate Limiting:** Protects Admin login (5/min), Volunteer login (5/min), OTP requests, search endpoints, and PDF/CSV export streams.
- **File Upload Security:** Enforces strict MIME checks, size limits, randomized filenames, storage isolation, and total rejection of executable scripts (`.php`, `.phtml`, `.phar`, `.sh`, `.exe`).
- **Zero PII Exposure on QR Verification:** Public scan views verify authenticity, cadre, and name while strictly suppressing Aadhaar, contact phone, private emails, and database primary keys.

---

## 🛠️ Technology Stack

| Layer | Technologies Used |
|---|---|
| **Backend Framework** | Laravel 12.x (PHP 8.2+) |
| **Frontend & Styling** | Blade Engine, Tailwind CSS, Vanilla JS, Alpine.js |
| **Asset Bundler** | Vite 7.x |
| **Database** | MySQL 8.0+ (Production) / SQLite (Testing) |
| **PDF Rendering** | `barryvdh/laravel-dompdf` |
| **Storage** | Local Disk / AWS S3 Cloud Storage |
| **Testing** | PHPUnit 11 (140 Feature & Unit Tests, 773 Assertions) |

---

## 🚀 Installation & Local Setup

### Prerequisites
- PHP `>= 8.2` with extensions: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `gd`, `fileinfo`, `zip`
- Composer `>= 2.2`
- Node.js `>= 18.x` & npm
- MySQL / MariaDB (or SQLite for local testing)

### Step-by-Step Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Kondareddy1209/Abvhps.git
   cd Abvhps
   ```

2. **Install PHP and Node dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Database Migrations and Seeders:**
   ```bash
   php artisan migrate --seed
   ```

5. **Create Storage Symlink:**
   ```bash
   php artisan storage:link
   ```

6. **Build Frontend Assets:**
   ```bash
   npm run build
   # or for active development:
   npm run dev
   ```

7. **Start the Laravel Development Server:**
   ```bash
   php artisan serve
   ```

---

## 🧪 Automated Testing

Run the complete test suite across all feature matrices:

```bash
php artisan test
```

Expected result:
```
Tests:    140 passed (773 assertions)
Duration: ~13s
```

---

## 📦 Deployment & Git Workflow

All code contributions should be pushed to the personal fork before creating a Pull Request to upstream:

```bash
# 1. Add your fork remote
git remote set-url origin https://github.com/Kondareddy1209/Abvhps.git

# 2. Commit and push your changes
git add .
git commit -m "feat: your descriptive feature summary"
git push origin main

# 3. Open Pull Request on GitHub:
# https://github.com/synvertix/Abvhps/pulls
```

---

## 📄 Statutory Information & Compliance

All statutory registration documentation (including 12A registration, 80G tax exemption, 10AC certificates, and CSR approval records) is accessible under `/compliance-certificates`.

---

## ⚖️ License & Proprietary Rights

All rights reserved © 2026 **Akhanda Bharatha Viswa Hindu Parirakshana Samiti (ABVHPS)**.  
Unauthorized distribution, replication, or modification of this software matrix is strictly prohibited.
