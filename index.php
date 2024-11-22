<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Include the database configuration
require_once 'config/db.php';
require_once 'src/parser.php';
require_once 'src/importer.php';

// Handle file upload and processing
if (isset($_POST['upload'])) {
    $fileType = $_FILES['xmlFile']['type'];
    $fileSize = $_FILES['xmlFile']['size'];

    if ($fileType !== 'text/xml') {
        $error = "Error: Please upload a valid XML file.";
    } elseif ($fileSize > 2 * 1024 * 1024) { // 2MB limit
        $error = "Error: File size exceeds 2MB limit.";
    } else {
        $filePath = 'uploads/' . basename($_FILES['xmlFile']['name']);
        move_uploaded_file($_FILES['xmlFile']['tmp_name'], $filePath);

        $xml = parseXML($filePath);
        if ($xml) {
            $success = importXMLToDatabase($pdo, $xml);
        } else {
            $error = "Error: Invalid or malformed XML file.";
        }
    }
}

// Handle data backup
if (isset($_POST['backup'])) {
    $filename = 'backup_' . date('Y-m-d_H-i-s') . '.csv';
    $filePath = 'backup/' . $filename;

    $stmt = $pdo->query("SELECT * FROM products");
    $file = fopen($filePath, 'w');
    fputcsv($file, ['ID', 'Name', 'Price', 'Quantity']);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($file, $row);
    }
    fclose($file);

    $backupSuccess = "Backup created: <a href='$filePath' download>$filename</a>";
}

// Handle data clearing
if (isset($_POST['clear'])) {
    $pdo->exec("TRUNCATE TABLE products");
    $clearSuccess = "All data cleared from the database.";
}

// Pagination for displaying products
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT * FROM products LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total number of rows and calculate total pages
$totalRows = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML to Database Import Tool</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">XML to Database Import Tool</h1>
    <!-- logout -->
    <div class="container mt-5">
    <a href="logout.php" class="btn btn-danger">Logout</a> 
</div>

    <!-- Upload Form -->
    <form method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label for="xmlFile" class="form-label">Upload XML File</label>
            <input type="file" name="xmlFile" id="xmlFile" class="form-control" required>
        </div>
        <button type="submit" name="upload" class="btn btn-primary">Upload and Import</button>
    </form>

    <!-- Success and Error Messages -->
    <?php if (isset($success)): ?>
        <div class="alert alert-success mt-3"><?= $success ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger mt-3"><?= $error ?></div>
    <?php endif; ?>
    <?php if (isset($backupSuccess)): ?>
        <div class="alert alert-success mt-3"><?= $backupSuccess ?></div>
    <?php endif; ?>
    <?php if (isset($clearSuccess)): ?>
        <div class="alert alert-success mt-3"><?= $clearSuccess ?></div>
    <?php endif; ?>

    <!-- Backup and Clear Buttons -->
    <form method="POST" class="mt-4">
        <button type="submit" name="backup" class="btn btn-secondary">Backup Data</button>
        <button type="submit" name="clear" class="btn btn-danger">Clear All Data</button>
    </form>

    <!-- Display Products -->
    <h3 class="mt-5">Imported Products</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No data available</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <!-- View Logs -->
    <h3 class="mt-5">Error Logs</h3>
    <?php if (file_exists('logs/error.log')): ?>
        <pre class="bg-light p-3"><?= htmlspecialchars(file_get_contents('logs/error.log')) ?></pre>
    <?php else: ?>
        <p class="text-muted">No logs available.</p>
    <?php endif; ?>
</div>
<script src="assets/js/scripts.js"></script>
</body>
</html>