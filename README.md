# User List Management Application

A simple web-based application for managing a list of users/candidates with CRUD operations.

## Features

- Add new users with name, email, age, and gender
- View all users in a list format
- Edit existing user information
- Delete users from the list
- AJAX-powered dynamic updates without page refresh
- Responsive design

## Technologies Used

- **Frontend:** HTML5, CSS3, JavaScript (AJAX)
- **Backend:** PHP 7+
- **Database:** MySQL
- **Architecture:** MVC pattern with separate classes for Database, Models, and Services

## Prerequisites

- XAMPP (or any web server with PHP and MySQL support)
- Web browser

## Installation and Setup

1. **Clone or Download the Project:**
   - Place the project folder in your web server's document root (e.g., `C:\xampp\htdocs\` for XAMPP)

2. **Database Setup:**
   - Start XAMPP and ensure Apache and MySQL services are running
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `user_list_app`
   - Import the `db/database.sql` file to create the required tables

3. **Configuration:**
   - Update database credentials in `classes/Database.php` if needed:
     ```php
     private static $host = "localhost";
     private static $user = "root"; // Your MySQL username
     private static $pass = "";     // Your MySQL password
     private static $db = "user_list_app";
     ```

4. **Access the Application:**
   - Open your web browser and navigate to: `http://localhost/Project/user-list/`

## Project Structure

```
user-list/
├── index.html              # Main HTML page
├── list.php                # PHP script for displaying users
├── ajax/                   # AJAX endpoints
│   ├── submit.php         # Handle form submissions
│   ├── get.php            # Retrieve user data
│   ├── edit.php           # Handle edit operations
│   └── delete.php         # Handle delete operations
├── assets/                 # Static assets
│   ├── css/
│   │   └── style.css      # Application styles
│   └── js/
│       └── script.js       # Frontend JavaScript
├── classes/                # PHP classes
│   ├── Database.php       # Database connection class
│   ├── Candidate.php      # User/Candidate model
│   └── CandidateManager.php # Business logic service
└── db/
    └── database.sql       # Database schema
```

## Usage

1. **Adding a User:**
   - Fill in the form fields (Name, Email, Age, Gender)
   - Click "Submit" to add the user

2. **Viewing Users:**
   - All users are displayed in the "User List" section
   - The list updates automatically after operations

3. **Editing a User:**
   - Click the "Edit" button next to any user
   - Modify the information in the form
   - Click "Submit" to save changes

4. **Deleting a User:**
   - Click the "Delete" button next to any user
   - Confirm the deletion when prompted

## API Endpoints

The application uses AJAX for dynamic operations:

- `POST /ajax/submit.php` - Add or update user
- `GET /ajax/get.php` - Retrieve all users
- `GET /ajax/edit.php?id={id}` - Get user data for editing
- `POST /ajax/delete.php` - Delete a user

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source and available under the [MIT License](LICENSE).

## Support

For issues or questions, please create an issue in the repository or contact the development team.