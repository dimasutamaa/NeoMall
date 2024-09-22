## Getting Started

### This project is made using
- PHP
- Bootstrap 5
- MySQL

## How to Run the Project

### Prerequisites
Make sure you have the following installed on your local machine:
- [XAMPP](https://www.apachefriends.org/download.html) (which includes PHP and MySQL)
- [Git](https://git-scm.com/downloads)

### Step 1: Clone the Repository
1. Open a terminal or command prompt.
2. Navigate to the directory where you want to clone the project.
3.  Run the following command to clone the repository:

    ```bash
    git clone https://github.com/dimasutamaa/NeoMall.git
    ```

### Step 2: Move Project to XAMPP Directory
After cloning, move the project to the `htdocs` folder in XAMPP.
- For Windows: Copy the project folder to `C:\xampp\htdocs\`.
- For Mac/Linux: Move the project folder to `/opt/lampp/htdocs/`.

### Step 3: Start XAMPP
1. Open the XAMPP Control Panel.
2. Start the Apache and MySQL services by clicking the “Start” buttons next to each.

### Step 4: Create a Database
1. Open a web browser and go to `http://localhost/phpmyadmin/`.
2. Create a new database:
    - Click the “Databases” tab.
    - Under “Create database,” enter a name (e.g., `your_project_db`) and click “Create.”
  
### Step 5: Import the Database
1. Still in phpMyAdmin, select the database you just created.
2. Click on the “Import” tab.
2. Find and select the database file (`neomall_online_shop.sql`) located in the project folder.
4. Click “Import” to import the database.

### Step 6: Configure the Database Connection
1. Open the project files in a code editor (e.g., VSCode or Sublime).
2. Find the configuration file (`config.php`).
3. Update the following database details:

     ```bash
     $db_host = "localhost";
     $db_user = "root"; // Default XAMPP MySQL user
     $db_password = ""; // Default XAMPP MySQL password (empty)
     $db_database = "your_project_db"; // The name of your database
     ```

### Step 7: Access the Project in Browser
1. Open a web browser.
2. Navigate to [http://localhost/NeoMall/index.php](http://localhost/NeoMall/index.php) to view the project.

## Accounts
### Admin
- admin [pass: admin]

### Partner
- ABCPartner [pass: partner123]
- XYZPartner [pass: partner123]

### Customer
- dimas [pass: 12345]
- bondol [pass: 12345]
- boundy [pass: 12345]
