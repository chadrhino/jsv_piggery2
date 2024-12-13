<?php
session_start();

$servername = "127.0.0.1";
$username = "u510162695_pig";
$password = "1Pigdatabase";
$dbname = "u510162695_pig";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch all table names
function getTables($conn) {
    $tables = [];
    $query = "SHOW TABLES";
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_array()) {
            $tables[] = $row[0];
        }
    }
    return $tables;
}

// Function to fetch all rows from a table
function getTableData($conn, $table) {
    $query = "SELECT * FROM `$table`";
    $result = $conn->query($query);
    if ($result) {
        return $result;
    }
    return null;
}

// Fetch all tables
$tables = getTables($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Tables</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .table-title {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Database Tables</h1>

    <?php foreach ($tables as $table): ?>
        <div class="table-title">Table: <?php echo htmlspecialchars($table); ?></div>
        <table>
            <thead>
                <?php
                $data = getTableData($conn, $table);
                if ($data && $data->num_rows > 0): 
                    $columns = $data->fetch_fields();
                ?>
                <tr>
                    <?php foreach ($columns as $column): ?>
                        <th><?php echo htmlspecialchars($column->name); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $data->fetch_assoc()): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
                <?php else: ?>
                    <tr>
                        <td colspan="100%">No data found</td>
                    </tr>
                <?php endif; ?>
        </table>
    <?php endforeach; ?>

</body>
</html>

<?php
$conn->close();
?>
