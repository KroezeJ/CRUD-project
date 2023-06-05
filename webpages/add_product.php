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
    $query = "SELECT productLine FROM productlines";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $productLines = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>

    <div class="container mt-5">
        <h2>Add Product</h2>
        <form method="post" action="../includes/newentry.php?add=product">
            <div class="mb-3">
                <label for="productCode" class="form-label">Product Code</label>
                <input type="text" class="form-control" id="productCode" name="productCode" placeholder="e.g. S18_1749"
                    required>
            </div>
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName"
                    placeholder="e.g. 1917 Grand Touring Sedan" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="productLine" class="form-label">Product Line</label>
                <input type="text" class="form-control" id="productLine" name="productLine"
                    placeholder="e.g. Vintage Cars" maxlength="255" list="productLines"
                    onfocusout='CheckValid("productLine", "productLines")' required>
                <datalist id="productLines">
                    <?php foreach ($productLines as $number): ?>
                    <option value="<?php echo $number; ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>
            <div class="mb-3">
                <label for="productScale" class="form-label">Product Scale</label>
                <input type="text" class="form-control" id="productScale" name="productScale" placeholder="e.g. 1:18"
                    maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="productVendor" class="form-label">Product Vendor</label>
                <input type="text" class="form-control" id="productVendor" name="productVendor"
                    placeholder="e.g. Exoto Designs" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="productDescription" class="form-label">Product Description</label>
                <textarea class="form-control" id="productDescription" name="productDescription" rows="3"
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="quantityInStock" class="form-label">Quantity in Stock</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="quantityInStock" name="quantityInStock" placeholder="e.g. 21" required>
            </div>
            <div class="mb-3">
                <label for="buyPrice" class="form-label">Buy Price</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="buyPrice" name="buyPrice" placeholder="e.g. 86.70" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="MSRP" class="form-label">MSRP</label>
                <input type="text" pattern="\d{1,11}" maxlength="11" title="Max 11 digits" class="form-control"
                    id="MSRP" name="MSRP" placeholder="e.g. 170.00" step="0.01" required>
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <?php include '../includes/footer.php'; ?>

</body>

</html>