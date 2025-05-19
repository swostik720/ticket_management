# 🎫 Ticket Management System

A comprehensive ticket management system built with Laravel, featuring role-based access control, ticket tracking, and department management.

---

## ✨ Features

* **👥 Role-Based Access Control:** Admin, Staff, and User roles with distinct permissions.
* **🎟️ Ticket Management:** Create, assign, and track tickets throughout their lifecycle.
* **🏢 Department Organization:** Organize tickets by departments.
* **📊 Dashboard Analytics:** Visual statistics for ticket status and performance.
* **📱 Responsive Design:** Seamless experience on desktop and mobile devices.
* **🔒 Secure Authentication:** Custom authentication system with role-based authorization.
* **📁 File Attachments:** Support for file uploads with tickets.

---

## 🛠️ Technologies Used

* **Backend:** Laravel 10.x, PHP 8.1+
* **Frontend:** Bootstrap 5, Font Awesome 6
* **Database:** MySQL
* **Authentication:** Custom Laravel authentication

---

## 📋 Requirements

* PHP 8.1 or higher
* Composer
* MySQL or MariaDB
* Node.js and NPM (for asset compilation)

---

## 🚀 Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/ticket-management.git
   cd ticket-management
   ```

2. **Install dependencies:**

   ```bash
   composer install
   npm install
   npm run dev
   ```

3. **Configure environment variables:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Edit the `.env` file to set up your database connection:

   ```plaintext
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ticket_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations and seed the database:**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Set up file storage:**

   ```bash
   php artisan storage:link
   ```

6. **Start the development server:**

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser.

---

## 👤 Default Users

After seeding the database, use the following credentials to log in:

| Role  | Email                                         | Password |
| ----- | --------------------------------------------- | -------- |
| Admin | [admin@example.com](mailto:admin@example.com) | password |
| Staff | [staff@example.com](mailto:staff@example.com) | password |
| User  | [user@example.com](mailto:user@example.com)   | password |

---

## 🔍 Role Descriptions

### 👑 **Admin**

* View all tickets
* Assign tickets to staff members
* Manage departments
* Manage users and their roles
* Access system-wide analytics

### 👨‍💼 **Staff**

* View assigned tickets
* Update ticket status (Closed, Escalated, Not Resolved)
* Access staff dashboard with relevant statistics

### 👤 **User**

* Create new tickets
* View own tickets and their status
* Attach files to tickets

---

## 📱 Screenshots

* Login Page
* Admin Dashboard
* Ticket Creation
* Ticket Details

*Add your screenshots here for better visualization.*

---

## 📊 System Architecture

```plaintext
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│    Users    │     │   Tickets   │     │ Departments │
└─────────────┘     └─────────────┘     └─────────────┘
       │                   │                   │
       └───────────┬───────┴───────────┬───────┘
                   │                   │
                   ▼                   ▼
           ┌─────────────────────────────────┐
           │          Controllers            │
           └─────────────────────────────────┘
                           │
                           ▼
                  ┌─────────────────┐
                  │      Views      │
                  └─────────────────┘
```

---

## 🔄 Workflow

1. **User Creates Ticket:** Submits a new ticket with department, urgency, and optional attachment.
2. **Admin Reviews:** Admin reviews and assigns the ticket to a staff member.
3. **Staff Processes:** Staff member works on the ticket and updates its status.
4. **User Tracks:** User can monitor ticket status throughout the process.

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📝 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

---

## 📧 Contact

For any inquiries, please reach out to [paneruswostik@gmail.com](mailto:paneruswostik@gmail.com).
