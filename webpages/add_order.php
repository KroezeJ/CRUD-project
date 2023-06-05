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
    $query = "SELECT CustomerNumber FROM customers";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $customerNumbers = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>

    <div class="container mt-5">
        <h2>Add Order</h2>
        <form method="post" action="../includes/newentry.php?add=order">
            <div class="mb-3">
                <label for="orderNumber" class="form-label">Order Number</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="orderNumber" name="orderNumber" placeholder="e.g. 10100" required>
            </div>
            <div class="mb-3">
                <label for="orderDate" class="form-label">Order Date</label>
                <input type="date" class="form-control" id="orderDate" name="orderDate" required>
            </div>
            <div class="mb-3">
                <label for="requiredDate" class="form-label">Required Date</label>
                <input type="date" class="form-control" id="requiredDate" name="requiredDate" required>
            </div>
            <div class="mb-3">
                <label for="shippedDate" class="form-label">Shipped Date</label>
                <input type="date" class="form-control" id="shippedDate" name="shippedDate">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" placeholder="e.g. Shipped"
                    maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="comments" class="form-label">Comments</label>
                <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="customerNumber" class="form-label">Customer Number</label>
                <input type="text" class="form-control"
                    id="customerNumber" name="customerNumber" placeholder="e.g. 103" list="CustomerList" 
                    onfocusout="CheckValid('customerNumber','CustomerList')" required>
                <datalist id="CustomerList">
                    <?php foreach ($customerNumbers as $number):
                        $query = "SELECT customerName FROM customers WHERE customerNumber = $number";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $customerName = $stmt->fetch(PDO::FETCH_COLUMN);
                        ?>
                        <option value="<?php echo $number . " - " . $customerName; ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <?php include '../includes/footer.php'; ?>

</body>

</html>