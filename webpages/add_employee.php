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
    $query = "SELECT employeeNumber FROM employees";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $employeeNumbers = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $query = "SELECT officeCode FROM offices";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $officeCodes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>


    <div class="container mt-5">
        <h2>Add Employee</h2>
        <form method="post" action="../includes/newentry.php?add=employee">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="e.g. Mark"
                    maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="e.g. Zuckerberg"
                    maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="extension" class="form-label">Extension</label>
                <input type="text" class="form-control" id="extension" name="extension" placeholder="e.g. 123"
                    maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="e.g. john.doe@hotmail.com"
                    maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="officeCode" class="form-label">Office Code</label>
                <input type="text" class="form-control" id="officeCode" name="officeCode" placeholder="e.g. 2"
                    list="officeCodes" onfocusout="CheckValid('officeCode', 'officeCodes')" required>
                <datalist id="officeCodes">
                    <?php foreach ($officeCodes as $number):
                        $query = "SELECT city FROM offices WHERE officeCode = $number";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $city = $stmt->fetch(PDO::FETCH_COLUMN);
                        $query2 = "SELECT addressLine1 FROM offices WHERE officeCode = $number";
                        $stmt2 = $conn->prepare($query2);
                        $stmt2->execute();
                        $address = $stmt2->fetch(PDO::FETCH_COLUMN);
                        ?>
                        <option value="<?php echo $number . " - " . $city . ", " . $address ?>"></option>
                    <?php endforeach; ?>
                </datalist>

            </div>
            <div class="mb-3">
                <label for="reportsTo" class="form-label">Reports To (Employee Number)</label>
                <input type="text" class="form-control"
                    id="reportsTo" name="reportsTo" list="employeeList" placeholder="e.g. 1"
                    onfocusout="CheckValid('reportsTo', 'employeeList')">
                <datalist id="employeeList">
                    <?php foreach ($employeeNumbers as $number1):
                        $query = "SELECT lastName FROM employees WHERE employeeNumber = $number1";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $lastName = $stmt->fetch(PDO::FETCH_COLUMN);
                        $query2 = "SELECT firstName FROM employees WHERE employeeNumber = $number1";
                        $stmt2 = $conn->prepare($query2);
                        $stmt2->execute();
                        $firstName = $stmt2->fetch(PDO::FETCH_COLUMN);
                        ?>
                        <option value="<?php echo $number1 . " - " . $firstName . " " . $lastName; ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
            <div class="mb-3">
                <label for="jobTitle" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="jobTitle" name="jobTitle" placeholder="e.g. IT manager"
                    maxlength="255" required>
            </div>
            <button type="submit" id='submit' class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <?php include '../includes/footer.php'; ?>

</body>

</html>