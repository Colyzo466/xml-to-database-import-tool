<?php
function importXMLToDatabase($pdo, $xml)
{
    foreach ($xml->product as $product) {
        $id = (int)$product->id;
        $name = (string)$product->name;
        $price = (float)$product->price;
        $quantity = (int)$product->quantity;

        // Validate fields
        if (empty($id) || empty($name) || empty($price) || empty($quantity)) {
            error_log("Error: Missing data for product with ID $id\n", 3, 'logs/error.log');
            continue;
        }

        // Insert into database
        try {
            $stmt = $pdo->prepare("INSERT INTO products (id, name, price, quantity) VALUES (:id, :name, :price, :quantity)");
            $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':price' => $price,
                ':quantity' => $quantity,
            ]);
            echo "Inserted product: $name\n";
        } catch (PDOException $e) {
            error_log("Error inserting product $name: " . $e->getMessage() . "\n", 3, 'logs/error.log');
        }
    }
}
