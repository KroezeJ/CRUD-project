<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/header.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Project3</title>
</head>

<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container-fluid">
        <div class="mb-3">
            <label for="tableFilter" class="form-label">Select Table</label>
            <select class="form-select" id="tableFilter" onchange="filterTable()">
                <option value="">All Tables</option>
                <?php
                $query = "SHOW TABLES";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $tables = $stmt->fetchAll(PDO::FETCH_NUM);

                $selectedTable = isset($_GET['table']) ? $_GET['table'] : null;

                foreach ($tables as $table) {
                    if ($table[0] == "users") {
                        continue;
                    }
                    $selected = ($selectedTable === $table[0]) ? "selected" : "";
                    echo "<option value=\"" . htmlspecialchars($table[0]) . "\" " . $selected . ">" . ucfirst(htmlspecialchars($table[0]))  . "</option>";
                }
                ?>
            </select>
        </div>
            <script>
                function filterTable() {
                    const selectedTable = document.getElementById('tableFilter').value;
                    if (selectedTable === '') {
                        window.location.href = 'index.php';
                    } else {
                        const urlParams = new URLSearchParams(window.location.search);
                        urlParams.set('table', selectedTable);
                        window.location.search = urlParams.toString();
                    }
                }
            </script>

            <div class="table-responsive">
                <?php
                $selectedTable = isset($_GET['table']) ? $_GET['table'] : null;
                foreach ($tables as $table) {
                    if ($table[0] == "users" || ($selectedTable !== null && $selectedTable !== $table[0])) {
                        continue;
                    }
                    $table_name = $table[0];

                    $query = "DESCRIBE $table_name";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $column_names = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $query = "SELECT * FROM $table_name";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    echo "<h2>" . ucfirst(htmlspecialchars($table_name)) . "</h2>";

                    echo "<table class='table table-striped table-dark'>";
                    echo "<thead>";
                    echo "<tr>";

                    foreach ($column_names as $column) {
                        if ($column['Field'] == "productCode" || $column['Field'] == "employeeNumber" || $column['Field'] == "officeCode" || $column['Field'] == "customerNumber") {
                            continue;
                        }
                        if ($column['Field'] == "salesRepEmployeeNumber") {
                            echo "<th>Sales Employee</th>";
                            continue;
                        }
                        echo "<th>" . htmlspecialchars($column['Field']) . "</th>";
                    }
                    if (isset($_SESSION['login_admin'])) {
                        echo "<th class='text-center'>Actions</th>";
                    }

                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    foreach ($rows as $row) {
                        echo "<tr>";
                        foreach ($column_names as $column) {
                            $column_name = $column['Field'];
                            if ($column_name == "username") {
                                $temp = $row[$column_name];
                            }
                            if ($column_name == "productCode" || $column_name == "employeeNumber" || $column_name == "officeCode" || $column_name == "customerNumber") {
                                continue;
                            }
                            if ($column_name == "salesRepEmployeeNumber") {
                                $query = "SELECT firstName, lastName FROM employees WHERE employeeNumber = :employeeNumber";
                                $stmt = $conn->prepare($query);
                                $stmt->bindValue(':employeeNumber', $row[$column_name]);
                                $stmt->execute();
                                $employee = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo "<td>" . htmlspecialchars($employee['firstName']) . " " . htmlspecialchars($employee['lastName']) . "</td>";
                                continue;
                            }
                            if ($column_name == "reportsTo"){
                                $query = "SELECT firstName, lastName FROM employees WHERE employeeNumber = :employeeNumber";
                                $stmt = $conn->prepare($query);
                                $stmt->bindValue(':employeeNumber', $row[$column_name]);
                                $stmt->execute();
                                $employee = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo "<td>" . htmlspecialchars($employee['firstName'] ?? null) . " " . htmlspecialchars($employee['lastName'] ?? null) . "</td>";
                                continue;
                            }
                            if ($column_name == "image") {
                                $link = htmlspecialchars($row[$column_name]);
                                echo "<td><a target='_blank' href='$link'>" . htmlspecialchars($row[$column_name]) . "</a></td>";
                            } else {
                            echo "<td>" . htmlspecialchars($row[$column_name]) . "</td>";
                            }
                        }
                        $first_column_value = reset($row);
                        $second_column_value = next($row);

                        if (isset($_SESSION['login_admin'])) {
                            if ($table_name == 'payments'){
                                    echo "<td class='text-center'> <a href='edit.php?table=$table_name&id=$second_column_value'><i class='fa-solid fa-pen-to-square'></i></a> <a href='delete.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-trash'></i></a> </td>";
                            } else {
                                if ($table_name == "users") {
                                    echo "<td class='text-center'> <a href='edit.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-pen-to-square'></i></a> <a href='delete.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-trash'></i></a> <a href='../includes/makeadmin.php?user=$temp'><i class='fa-solid fa-circle-up'></i></a> <a href='../includes/removeadmin.php?user=$temp'><i class='fa-solid fa-circle-down'></i></a></td>";
                                } else {
                                    echo "<td class='text-center'> <a href='edit.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-pen-to-square'></i></a> <a href='delete.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-trash'></i></a> </td>";
                                }
                            }
                        }
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                }
                ?>
            </div>
        </div>

        <?php include '../includes/footer.php'; ?>
</body>

</html>