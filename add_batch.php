<!DOCTYPE html>
<html lang="en">
<head>
    <title>Batch Management</title>
    <?php
    session_start();
    include("db.php");
    include("head/header.php");
    include("menu.php");
    ?>
</head>
<body>
<?php

$add_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $batch_id = $_POST['batch_id'] ?? '';
    $batch_name = $_POST['batch_name'] ?? '';
    $program_code = $_POST['program_code'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $batch_status = $_POST['batch_status'] ?? '';
    $category = $_POST['category'] ?? '';
    $note = $_POST['note'] ?? '';


    if ($batch_id && $batch_name && $program_code && $start_date && $end_date && $batch_status && $category && $note) {
        $stmt = $conn->prepare("INSERT INTO tblbatch (batch_id, batch_name, program_code, start_date, end_date, batch_status, 
        category, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $batch_id, $batch_name, $program_code, $start_date, $end_date, $batch_status, $category, $note);

        if ($stmt->execute()) {
            $add_success = true;
        }

        $stmt->close();
    }
}

if ($add_success) {
    ?>
    <div>
        <div>
            <h2>Thank you!</h2>
        </div>
    </div>
    <table class="success-table">
        <tr>
            <td><h2>Batch Id: </h2></td>
            <td><?php echo htmlspecialchars($batch_id); ?>.</td>
        </tr>
        <tr>
            <td><h2>Batch Name: </h2></td>
            <td><?php echo htmlspecialchars($batch_name); ?>.</td>
        </tr>
        <tr>
            <td><h2>Program Code: </h2></td>
            <td><?php echo htmlspecialchars($program_code); ?>.</td>
        </tr>
        <tr>
            <td><h2>Start Date: </h2></td>
            <td><?php echo htmlspecialchars($start_date); ?>.</td>
        </tr>
        <tr>
            <td><h2>End Date: </h2></td>
            <td><?php echo htmlspecialchars($end_date); ?>.</td>
        </tr>
        <tr>
            <td><h2>Batch Status: </h2></td>
            <td><?php echo htmlspecialchars($batch_status); ?>.</td>
        </tr>
        <tr>
            <td><h2>Category: </h2></td>
            <td><?php echo htmlspecialchars($category); ?>.</td>
        </tr>
        <tr>
            <td><h2>Note: </h2></td>
            <td><?php echo htmlspecialchars($note); ?>.</td>
        </tr>
    </table>
    <?php
} else {
    ?>
    <div>
        <h2>Add Batch</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <table>
                <tr>
                    <td><label>Batch Id:</label></td>
                    <td><input type="text" name="batch_id" placeholder="Batch Id" required></td>
                </tr>

                <tr>
                    <td><label>Batch Name:</label></td>
                    <td><input type="text" name="batch_name" placeholder="Batch Name" required></td>
                </tr>

                <tr>
                    <td><label>Program Code:</label></td>
                    <td><input type="text" name="program_code" placeholder="Program Code" required></td>
                </tr>

                <tr>
                    <td><label>Start Date:</label></td>
                    <td><input type="date" name="start_date" placeholder="Start Date" required></td>
                </tr>

                <tr>
                    <td><label>End Date:</label></td>
                    <td><input type="date" name="end_date" placeholder="End Date" required></td>
                </tr>

                <tr>
                    <td><label>Batch Status:</label></td>
                    <td><input type="text" name="batch_status" placeholder="Batch Status" required></td>
                </tr>

                <tr>
                    <td><label>Category:</label></td>
                    <td><input type="text" name="category" placeholder="Category" required></td>
                </tr>

                <tr>
                    <td><label>Note:</label></td>
                    <td><textarea name="note" placeholder="Note"></textarea></td>
                </tr>

                <td><button type="green" value="Add Batch">Register</td>
            </table>
        </form>
    </div>
    <?php
    }
    ?>

</body>
</html>