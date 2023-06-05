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

    <div class="container mt-5">
        <h2>Add Product Line</h2>
        <form method="post" action="../includes/newentry.php?add=productline">
            <div class="mb-3">
                <label for="productLine" class="form-label">Product Line</label>
                <input type="text" class="form-control" id="productLine" name="productLine" placeholder="e.g. Classic Cars" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="textDescription" class="form-label">Text Description</label>
                <input type="text" class="form-control" id="textDescription" name="textDescription" placeholde  r="e.g. Attention to detail...">
            </div>
            <div class="mb-3">
                <label for="htmlDescription" class="form-label">HTML Description</label>
                <textarea class="form-control" id="htmlDescription" name="htmlDescription" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="text" class="form-control" id="image" name="image" placeholder="e.g. /images/classic_cars.jpg">
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <?php include '../includes/footer.php'; ?>

</body>

</html>