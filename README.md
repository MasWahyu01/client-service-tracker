# Client Service Tracker System

A **Web-Based Client Information & Service Tracking System** built with Laravel, designed to replace manual and spreadsheet-based workflows for managing clients, services, and interaction history. This system focuses on data consistency, scalability, and maintainability following modern Full Stack best practices.

---

## 📌 Project Overview

Client Service Tracker adalah aplikasi berbasis web untuk perusahaan skala menengah yang membutuhkan sistem terpusat dalam mengelola:

* Data klien dan profil perusahaan
* Layanan yang sedang berjalan
* Riwayat interaksi dan komunikasi
* Monitoring status & deadline layanan
* Reporting dan analisis data

Sistem ini dirancang dengan arsitektur modular dan scalable menggunakan prinsip:

* Separation of Concerns
* Service Layer Pattern
* Form Request Validation
* Clean MVC Structure

---

## 🚀 Core Features

### 1. Client Management

* CRUD Client
* Search & filtering (status, segment, keyword)
* Detail page dengan ringkasan layanan & interaksi
* Segment tagging (VIP, SME, dll)

### 2. Service Tracking

* Satu client bisa memiliki banyak service
* Field utama:

  * Service name
  * Start date & Due date
  * PIC
  * Priority (low, medium, high, critical)
  * Status (new, in_progress, completed, dll)
* Deteksi overdue otomatis

### 3. Interaction Logs

* Mencatat semua komunikasi dengan klien:

  * Call, Email, Meeting, Chat
* Next Action + Due Date
* Attachment file support
* Overdue reminder logic

### 4. Role-Based Access Control (RBAC)

* Super Admin
* Staff Operasional
* Viewer / Manager

### 5. Dashboard & Reporting

* Statistik real-time:

  * Total active clients
  * Services per status
  * Overdue items
* Chart visual via Chart.js
* Export ke CSV dan Excel

---

## 🧠 Tech Stack

### Backend

* Laravel 10+
* PHP 8.1+
* Eloquent ORM
* Custom JWT Authentication

### Frontend

* Blade Template Engine
* Tailwind CSS v4
* Vanilla JavaScript / AJAX

### Database

* MySQL

### Tooling

* Vite
* npm
* Git & GitHub

---

## 🗂 Folder Structure (Core)

```
app/
├── Http/
│   ├── Controllers/
│   ├── Requests/
├── Models/
├── Services/
resources/
├── views/
│   ├── clients/
│   ├── layouts/
routes/
database/
```

Arsitektur ini memastikan setiap layer memiliki tanggung jawab yang jelas dan mudah di-maintain.

---

## ⚙️ Installation Guide (Local Setup)

### 1. Clone repository

```bash
git clone https://github.com/USERNAME/client-service-tracker.git
cd client-service-tracker
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` sesuai konfigurasi database lokal:

```
DB_DATABASE=client_tracker
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run migration

```bash
php artisan migrate
```

### 5. Run development server

```bash
php artisan serve
npm run dev
```

Akses aplikasi di:
[http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔐 Security Notes

* File `.env` tidak di-commit ke repository
* JWT token digunakan untuk autentikasi
* Role-based middleware membatasi akses tiap module
* HTTPS recommended untuk production

---

## 🛠 Development Workflow

Setiap perubahan fitur direkomendasikan mengikuti pola:

```bash
git status
git add .
git commit -m "Deskripsi fitur"
git push
```

Contoh commit message:

* `Add client detail page`
* `Implement service tracking CRUD`
* `Integrate RBAC middleware`

---

## 📈 Roadmap

* ✅ Client CRUD + Detail Page
* ✅ Base UI Layout
* 🔄 Service Tracking Module
* 🔄 Interaction Log System
* 🔄 JWT Authentication
* 🔄 RBAC Policies
* 🔄 Dashboard Metrics
* 🔄 Export & Reporting

---

## 📄 License

This project is developed for educational and internal enterprise purposes.

---

## 👨‍💻 Author

**Wahyu Ali Marzuki**
Student - Software Engineering (PPLG)

---

## 💬 Notes

Proyek ini dikembangkan dengan pendekatan profesional dan siap untuk di-scale dalam lingkungan production. Semua keputusan teknis difokuskan pada maintainability, readability, dan clean architecture.

Jika ingin menggunakan sebagai base project untuk sistem serupa, disarankan untuk melakukan review ulang pada konfigurasi security dan environment sebelum deployment.
