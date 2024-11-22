### XML to Database Import Tool  

**Overview**  
The **XML to Database Import Tool** is a robust web application designed for efficient XML data management. It allows users to seamlessly upload XML files, process their content, and import data into a MySQL database. The tool includes additional features for data backup, database clearing, and a paginated view of imported records, ensuring streamlined operations and ease of use.  

**Key Features**  
- **User Authentication**: Secure login and logout functionality.  
- **XML File Import**: Upload and parse XML files to store data in a MySQL database.  
- **Data Backup**: Export existing database records to CSV format.  
- **Database Clearing**: Clear all entries from the database with a single action.  
- **Pagination**: Display imported products with paginated navigation.  
- **Error Logging**: Centralized error logging to monitor and troubleshoot issues.  

**Technologies Used**  
- **Backend**: PHP with PDO for secure database interactions.  
- **Database**: MySQL for structured data storage.  
- **Frontend**: HTML, CSS, and Bootstrap for responsive design and user interface.  

---

### **Installation**  

#### **1. Clone the Repository**  
```bash  
git clone https://github.com/Colyzo466/xml-to-database-import-tool.git  
cd xml-to-database-import-tool  
```  

#### **2. Set Up the Environment**  
- Ensure PHP and MySQL are installed. Use tools like XAMPP, WAMP, or MAMP for a local server setup.  
- Create a new MySQL database (e.g., `xml_import_tool`).  

#### **3. Configure Database Connection**  
Edit the database configuration file `config/db.php`:  
```php  
$host = 'localhost';  
$db = 'xml_import_tool';  
$user = 'your_username';  
$pass = 'your_password';  
$charset = 'utf8mb4';  

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";  
$options = [  
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  
    PDO::ATTR_EMULATE_PREPARES => false,  
];  
$pdo = new PDO($dsn, $user, $pass, $options);  
```  

#### **4. Create Database Tables**  
Run the following SQL commands to initialize the database schema:  
```sql  
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
```  

#### **5. Start the Server**  
- Start the Apache and MySQL services using your local server tool (e.g., XAMPP).  
- Access the application at `http://localhost/xml-to-database-import-tool`.  

---

### **Usage Instructions**  

1. **User Registration**:  
   - Open `register.php` to create a new user account.  

2. **Login**:  
   - Use your credentials to log in via `login.php`.  

3. **Upload XML Files**:  
   - Use the upload form to select and process an XML file.  

4. **Backup Data**:  
   - Click the "Backup Data" button to export the database contents to a CSV file.  

5. **Clear Data**:  
   - Use the "Clear All Data" button to delete all entries in the `products` table.  

6. **View Data**:  
   - Browse imported products with a paginated interface.  

---

### **Error Handling**  
Errors during file uploads or database interactions are logged in `logs/error.log`. Regularly monitor this file for insights and troubleshooting.  

---

### **Contributing**  
We welcome contributions to enhance the tool's features and performance. To contribute:  

1. **Fork the Repository**  
   - Create a fork on GitHub.  

2. **Create a Branch**  
   ```bash  
   git checkout -b feature/YourFeature  
   ```  

3. **Implement Changes**  
   - Make your changes and commit them:  
   ```bash  
   git commit -m "Add some feature"  
   ```  

4. **Push the Changes**  
   ```bash  
   git push origin feature/YourFeature  
   ```  

5. **Open a Pull Request**  
   - Submit your changes for review.  

---

### **License**  
This project is licensed under the MIT License. See the `LICENSE` file for details.  

---

### **Contact**  
For any questions or feedback, feel free to reach out:  
📧 **Email**: colyzo466@gmail.com  
