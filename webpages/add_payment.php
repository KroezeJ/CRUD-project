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
        <h2>Add Payment</h2>
        <form method="post" action="../includes/newentry.php?add=payment">
            <div class="mb-3">
                <label for="customerNumber" class="form-label">Customer Number</label>
                <input type="text" class="form-control"
                    id="customerNumber" name="customerNumber" placeholder="e.g. 103" list="CustomerList"
                    onfocusout='CheckValid("customerNumber", "CustomerList")' required>
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
            <div class="mb-3">
                <label for="checkNumber" class="form-label">Check Number</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="checkNumber" name="checkNumber" placeholder="e.g. HQ336336" required>
            </div>
            <div class="mb-3">
                <label for="paymentDate" class="form-label">Payment Date</label>
                <input type="date" class="form-control" id="paymentDate" name="paymentDate" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="amount" name="amount" placeholder="e.g. 14571.44" step="0.01" required>
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <?php include '../includes/footer.php'; ?>

</body>

</html>