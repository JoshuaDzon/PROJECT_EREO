##  Project EREO
**Event Reservation for Event Organization**

---

## About the Project
**Project EREO** is a simple web-based system designed to help users **manage event reservations** and **organize schedules** efficiently.  
It allows administrators to create events, manage participants, and view reservations in a user-friendly interface.

Developed using:
- **PHP** for backend scripting  
- **MySQL (phpMyAdmin)** for database management  
- **HTML, CSS, and JavaScript** for the front-end interface

---

## Folder Structure
```
Project_EREO/
│
├── index.php → Landing page template
│
├── assets/
│ ├── css/
│ │ └── style.css → Page styling
│ ├── js/
│ │ └── script.js → Optional JavaScript file
│ └── img/ → Image folder
│
├── config/
│ └── dbconfig.php → Database connection file
│
└── event_reservation.sql → Exported database file
```

---

## Setup Instructions
1. Copy the folder to:
   ```
   C:\xampp\htdocs\
   ```
2. Open **XAMPP Control Panel** → Start **Apache** and **MySQL**
3. Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
4. Create a new database named **`event_reservation`**
5. Import the file:
6. Run the system in your browser:
   http://localhost/Project_EREO/
7. If “✅ Database connected successfully!” appears in `/config/dbconfig.php`, your setup works perfectly.

---

## 💾 Database Information
| Property | Value |
|-----------|--------|
| **Database Name** | `event_reservation` |
| **Table Name** | `users` |
| **Primary Key** | `id` |
| **Sample Records** | 3–5 users inserted |
| **Export File** | `event_reservation.sql` |

---

## 🧰 Technologies Used
| Technology | Purpose |
|-------------|----------|
| **PHP** | Core logic / server-side scripting |
| **MySQL** | Database management |
| **HTML / CSS / JavaScript** | Front-end design |
| **XAMPP** | Local server environment |
| **phpMyAdmin** | Database GUI tool |

---