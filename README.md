XML to Database Import Tool

Overview
The XML to Database Import Tool is a web application that allows users to upload XML files and import the data into a database. The tool provides functionalities for data backup, data clearing, and pagination for displaying imported products. It is built using PHP and utilizes a MySQL database for data storage.

Features
User authentication (login/logout)
Upload and import XML files into a MySQL database
Backup existing database data to CSV files
Clear all data from the database
Pagination for viewing imported products
Error logging for monitoring issues

Technologies Used
PHP
MySQL
HTML/CSS
Bootstrap (for styling)
PDO (for database interactions)

Installation
To set up the XML to Database Import Tool on your local machine, follow these steps:

Clone the Repository:

git clone https://github.com/Colyzo466/xml-to-database-import-tool.git
cd xml-to-database-import-tool

Set Up the Environment:

Ensure you have PHP and MySQL installed on your machine. You can use XAMPP, WAMP, or MAMP for an easy setup.
Create a new MySQL database for the application (e.g., xml_import_tool).

Configure Database Connection:

Open config/db.php and update the database connection settings:

$host = 'localhost';
$db   = 'xml_import_tool';
$user = 'your_username';
$pass = 'your_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

Create the Database Table:

Execute the following SQL command to create the required table:
sql

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

Start the Server:

If using XAMPP, start the Apache and MySQL modules.
Access the application in your web browser at http://localhost/xml-to-database-import-tool.
Usage
Register a New User:

Navigate to register.php to create a new account.
Login:

Use your credentials to log in at login.php.
Upload XML File:

After logging in, use the upload form to select and upload an XML file.
Backup Data:

Click the "Backup Data" button to create a CSV backup of the current database.
Clear All Data:

Use the "Clear All Data" button to remove all entries from the products table.
View Imported Products:

View the list of imported products with pagination.

Error Handling
Any errors encountered during file upload or database operations are logged to logs/error.log.
Ensure to check this file for troubleshooting any issues.

Contributing
Contributions are welcome! If you have suggestions for improvements or features, please open an issue or submit a pull request.

Fork the repository.
Create a new branch (git checkout -b feature/YourFeature).

Make your changes.
Commit your changes (git commit -m 'Add some feature').

Push to the branch (git push origin feature/YourFeature).
Open a pull request.

License
This project is licensed under the MIT License. See the LICENSE file for details.

Contact
For any inquiries or feedback, please reach out to colyzo466@gmail.com.
