# FUN FITNESS - Gym Management System

A comprehensive gym management web application built with PHP, MySQL, and modern web technologies.

## 🚀 Features

- Member Management
- Class Scheduling  
- Staff Management
- Membership Plans
- Admin Dashboard
- Responsive Design

## 🛠 Technology Stack

- PHP
- MySQL
- jQuery
- Bootstrap
- HTML5
- CSS3
- Laragon (Local Development)

## 📁 Project Structure
```plaintext
FUN-FITNESS/
├── HOME.php                # Main dashboard page
├── index.php               # Landing / Home page
├── login.php               # Authentication page
│
├── assets/                 # Static resources
│   ├── CSS/                # Stylesheets
│   │   ├── bootstrap.css
│   │   ├── dash.css
│   │   ├── index.css
│   │   └── login.css
│   │
│   ├── JS/                 # JavaScript files
│   │   ├── bootstrap.js
│   │   └── login.js
│   │
│   ├── IMAGES/             # Media assets
│   │   ├── bg-index.jpg
│   │   ├── bg-login.jpg
│   │   ├── fast-fitness.png
│   │   ├── funfitness.png
│   │   └── [other images]
│   │
│   ├── fonts/              # Font files
│   │   └── Montserrat/
│   │
│   └── include/            # Configuration / Includes
│       ├── config.php
│       └── script.php
│
├── database/
│   └── fun_fitness.sql     # Database schema
│
└── pages/                  # App subpages
    ├── classes.php         # Class management
    ├── dashboard.php       # Admin dashboard
    ├── members.php         # Member management
    ├── memberships.php     # Membership plans
    ├── save_class.php      # Class creation/editing
    └── staff.php           # Staff management

```
text

**Core Files:**
- `HOME.PHP` - Main dashboard interface
- `index.php` - Landing page and entry point
- `login.php` - User authentication system

**Assets Directory:**
- `CSS/` - All styling files (Bootstrap + custom)
- `JS/` - JavaScript functionality 
- `IMAGES/` - Visual assets and branding
- `fonts/` - Montserrat font family
- `include/` - Configuration and scripts

**Pages Directory:**
- Administrative and management modules
- Member and staff management interfaces
- Class scheduling system


## ⚙️ Installation

1. **Setup Laragon**
   - Install Laragon
   - Start Apache and MySQL

2. **Setup Project**
   - Place project in `C:\laragon\www\FUN FITNESS`
   - Create database `fun_fitness`
   - Import `database/fun_fitness.sql`

3. **Configure Database**
   - Update `assets/include/config.php`
   - Set your database credentials

4. **Access Application**
   - Open `http://localhost/FUN FITNESS`
   - Use login credentials

## 🎯 Usage

**For Administrators:**
- Manage members and staff
- Schedule classes
- View dashboard analytics

**For Members:**
- View class schedules  
- Check membership status
- Update profiles

## 🌐 Deployment

**Traditional Hosting:**
1. Upload files via FTP
2. Create MySQL database
3. Import SQL file
4. Update config.php

**Recommended Hosting:**
- SiteGround
- Hostinger
- DigitalOcean

## 📞 Support

For issues and questions:
- Check existing issues
- Create new issue
- Contact developer

---


*Built with PHP, MySQL, jQuery, Bootstrap for the fitness community*

