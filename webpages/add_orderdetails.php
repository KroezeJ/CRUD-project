<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include '../includes/header.php';
    include '../includes/admincheck.php';
    ?>
    <title>Project3</title>
</head>

<body>
    <?php include '../includes/navbar.php';
    ?>

    <?php
    include '../includes/config.php';
    $query = "SELECT orderNumber FROM orders";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $orderNumbers = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $query = "SELECT productCode FROM products";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $productCodes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>

    <div class="container mt-5">
        <h2>Add Order Details</h2>
        <form method="post" action="../includes/newentry.php?add=orderdetails">
            <div class="mb-3">
                <label for="orderNumber" class="form-label">Order Number</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="orderNumber" name="orderNumber" placeholder="e.g. 10100" list="orderNumbersList"
                    onfocusout='CheckValid("orderNumber", "orderNumbersList")' required>
                <datalist id="orderNumbersList">
                    <?php foreach ($orderNumbers as $number): ?>
                    <option value="<?php echo $number; ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>
            <div class="mb-3">
                <label for="productCode" class="form-label">Product Code</label>
                <input type="text" class="form-control" id="productCode" name="productCode" placeholder="e.g. S18_1749"
                    list="productCodesList" onfocusout='CheckValid("productCode", "productCodesList")' required>
                <datalist id="productCodesList">
                    <?php foreach ($productCodes as $number2): 
                        $query = "SELECT productName FROM products WHERE productCode = $number2";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $productName = $stmt->fetch(PDO::FETCH_COLUMN);
                        ?>
                    <option value="<?php echo $number2 . " - " . $productName; ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>
            <div class="mb-3">
                <label for="quantityOrdered" class="form-label">Quantity Ordered</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="quantityOrdered" name="quantityOrdered" placeholder="e.g. 30" required>
            </div>
            <div class="mb-3">
                <label for="priceEach" class="form-label">Price Each</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="priceEach" name="priceEach" placeholder="e.g. 136.00" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="orderLineNumber" class="form-label">Order Line Number</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="orderLineNumber" name="orderLineNumber" placeholder="e.g. 3" required>
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <?php include '../includes/footer.php'; ?>

</body>

</html>