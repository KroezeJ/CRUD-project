<?php

include './admincheck.php';
$add = $_GET['add'];
addentry($add);
function addentry($case)
{
    // base commands

    include './config.php';

    // get all tables and put posts into variables
    $tablesQuery = "SHOW TABLES";
    $tablesStmt = $conn->prepare($tablesQuery);
    $tablesStmt->execute();

    $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        $columnsQuery = "SELECT column_name
                     FROM information_schema.columns
                     WHERE table_name = :table_name AND table_schema = :database_name";

        $columnsStmt = $conn->prepare($columnsQuery);
        $columnsStmt->execute([
            ':table_name' => $table,
            ':database_name' => 'project3'
        ]);

        $columns = $columnsStmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($columns as $column) {
            if (isset($_POST[$column])) {
                $$column = $_POST[$column];
            } else {
                $$column = null;
            }
        }
    }

    // switch case to determine which table to add to
    try {
        switch ($case) {
            case "customer":
                $phoneCode = $_POST['phoneCode'];
                $phone = $phoneCode . " " . $phone;
                $check_sql = "SELECT * FROM customers WHERE customerName = :customerName AND contactLastName = :contactLastName AND contactFirstName = :contactFirstName";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->execute([
                    ':customerName' => $customerName,
                    ':contactLastName' => $contactLastName,
                    ':contactFirstName' => $contactFirstName
                ]);
                if ($check_stmt->rowCount() > 0) {
                    echo "<script>alert('Customer already exists.');
                window.location.href='../webpages/index.php';</script>";
                }

                $sql = "INSERT INTO customers (customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, state, postalCode, country, salesRepEmployeeNumber, creditLimit) VALUES (:customerName, :contactLastName, :contactFirstName, :phone, :addressLine1, :addressLine2, :city, :state, :postalCode, :country, :salesRepEmployeeNumber, :creditLimit)";
                $data = [
                    ':customerName' => $customerName,
                    ':contactLastName' => $contactLastName,
                    ':contactFirstName' => $contactFirstName,
                    ':phone' => $phone,
                    ':addressLine1' => $addressLine1,
                    ':addressLine2' => $addressLine2,
                    ':city' => $city,
                    ':state' => $state,
                    ':postalCode' => $postalCode,
                    ':country' => $country,
                    ':salesRepEmployeeNumber' => explode(" - ", $salesRepEmployeeNumber)[0],
                    ':creditLimit' => $creditLimit
                ];
                break;
            case "employee":
                $check_sql = "SELECT * FROM employees WHERE firstname = :firstname AND lastname = :lastname";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->execute([
                    ':firstname' => $firstName,
                    ':lastname' => $lastName
                ]);
                if ($check_stmt->rowCount() > 0) {
                    echo "<script>alert('Employee already exists.');
                window.location.href='../webpages/index.php';</script>";
                }
                $sql = "INSERT INTO employees (lastName, firstName, extension, email, officeCode, reportsTo, jobTitle) VALUES (:lastName, :firstName, :extension, :email, :officeCode, :reportsTo, :jobTitle)";
                $data = [
                    ':lastName' => $lastName,
                    ':firstName' => $firstName,
                    ':extension' => $extension,
                    ':email' => $email,
                    ':officeCode' => explode(" - ", $officeCode)[0],
                    ':reportsTo' => explode(" - ", $reportsTo)[0],
                    ':jobTitle' => $jobTitle
                ];
                break;
            case "office":
                $phoneCode = $_POST['phoneCode'];
                $phone = $phoneCode . " " . $phone;
                $check_sql = "SELECT * FROM offices WHERE city = :city AND addressLine1 = :addressLine1";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->execute([
                    ':city' => $city,
                    ':addressLine1' => $addressLine1
                ]);
                if ($check_stmt->rowCount() > 0) {
                    echo "<script>alert('Office already exists.');
                window.location.href='../webpages/index.php';</script>";
                }
                $sql = "INSERT INTO offices (city, phone, addressLine1, addressLine2, state, country, postalCode, territory) VALUES (:city, :phone, :addressLine1, :addressLine2, :state, :country, :postalCode, :territory)";
                $data = [
                    ':city' => $city,
                    ':phone' => $phone,
                    ':addressLine1' => $addressLine1,
                    ':addressLine2' => $addressLine2,
                    ':state' => $state,
                    ':country' => $country,
                    ':postalCode' => $postalCode,
                    ':territory' => $territory
                ];
                break;
            case "orderdetails":
                $check_sql = "SELECT * FROM orderdetails WHERE orderNumber = :orderNumber AND productCode = :productCode";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->execute([
                    ':orderNumber' => $orderNumber,
                    ':productCode' => $productCode
                ]);
                if ($check_stmt->rowCount() > 0) {
                    echo "<script>alert('Order already exists.');
                window.location.href='../webpages/index.php';</script>";
                }
                $sql = "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber) VALUES (:orderNumber, :productCode, :quantityOrdered, :priceEach, :orderLineNumber)";
                $data = [
                    ':orderNumber' => explode(" - ", $orderNumber)[0],
                    ':productCode' => explode(" - ", $productCode)[0],
                    ':quantityOrdered' => $quantityOrdered,
                    ':priceEach' => $priceEach,
                    ':orderLineNumber' => $orderLineNumber
                ];
                break;
            case "order":
                $check_sql = "SELECT * FROM orders WHERE orderNumber = :orderNumber";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->execute([
                    ':orderNumber' => $orderNumber
                ]);
                if ($check_stmt->rowCount() > 0) {
                    echo "<script>alert('Order already exists.');
                window.location.href='../webpages/index.php';</script>";
                }
                $sql = "INSERT INTO orders (orderNumber, orderDate, requiredDate, shippedDate, status, comments, customerNumber) VALUES (:orderNumber, :orderDate, :requiredDate, :shippedDate, :status, :comments, :customerNumber)";
                $data = [
                    ':orderNumber' => $orderNumber,
                    ':orderDate' => $orderDate,
                    ':requiredDate' => $requiredDate,
                    ':shippedDate' => $shippedDate,
                    ':status' => $status,
                    ':comments' => $comments,
                    ':customerNumber' => explode(" - ", $customerNumber)[0]
                ];
                break;
            case "payment":
                $check_sql = "SELECT * FROM payments WHERE customerNumber = :customerNumber AND checkNumber = :checkNumber";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->execute([
                    ':customerNumber' => $customerNumber,
                    ':checkNumber' => $checkNumber
                ]);
                if ($check_stmt->rowCount() > 0) {
                    echo "<script>alert('Payment already exists.');
                window.location.href='../webpages/index.php';</script>";
                }
                $sql = "INSERT INTO payments (customerNumber, checkNumber, paymentDate, amount) VALUES (:customerNumber, :checkNumber, :paymentDate, :amount)";
                $data = [
                    ':customerNumber' => explode(" - ", $customerNumber)[0],
                    ':checkNumber' => $checkNumber,
                    ':paymentDate' => $paymentDate,
                    ':amount' => $amount
                ];
                break;
            case "productline":
                $check_sql = "SELECT * FROM productlines WHERE productLine = :productLine";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->execute([
                    ':productLine' => $productLine
                ]);
                if ($check_stmt->rowCount() > 0) {
                    echo "<script>alert('Product line already exists.');
                window.location.href='../webpages/index.php';</script>";
                }
                $sql = "INSERT INTO productlines (productLine, textDescription, htmlDescription, image) VALUES (:productLine, :textDescription, :htmlDescription, :image)";
                $data = [
                    ':productLine' => $productLine,
                    ':textDescription' => $textDescription,
                    ':htmlDescription' => $htmlDescription,
                    ':image' => $image
                ];
                break;
            case "product":
                $check_sql = "SELECT * FROM products WHERE productCode = :productCode";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->execute([
                    ':productCode' => $productCode
                ]);
                if ($check_stmt->rowCount() > 0) {
                    echo "<script>alert('Product already exists.');
                window.location.href='../webpages/index.php';</script>";
                }
                $sql = "INSERT INTO products (productName, productLine, productScale, productVendor, productDescription, quantityInStock, buyPrice, MSRP) VALUES (:productName, :productLine, :productScale, :productVendor, :productDescription, :quantityInStock, :buyPrice, :MSRP)";
                $data = [
                    ':productName' => $productName,
                    ':productLine' => $productLine,
                    ':productScale' => $productScale,
                    ':productVendor' => $productVendor,
                    ':productDescription' => $productDescription,
                    ':quantityInStock' => $quantityInStock,
                    ':buyPrice' => $buyPrice,
                    ':MSRP' => $MSRP
                ];
                break;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
        $capitalized = ucfirst($case);
        echo "<script type='text/javascript'>alert('$capitalized added succesfully.');
            window.location.href='../webpages/index.php';</script>";
    } catch (PDOException $e) {
        $type = $e->errorInfo[0];
        if ($type == '24000') {
            "<script type='text/javascript'>alert('Foreign key error.');
            window.location.href='../webpages/index.php';</script>";
        } else {
            echo $e->getMessage();
        }
    }
}
