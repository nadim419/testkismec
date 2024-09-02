<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <?php
    session_start();
    include("head/header.php");
    include("menu.php");
    include("db.php");
    ?>
</head>
<body>

<?php
$update_success = false;
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $batch_id = $_POST['batch_id'];
    $batch_name = $_POST['batch_name'];
    $program_code = $_POST['program_code'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $batch_status = $_POST['batch_status'];
    $category = $_POST['category'];
    $note = $_POST['note'];

    // Update batch details
    $stmt = $conn->prepare("UPDATE tblbatch SET batch_id = ?, batch_name = ?, program_code = ?, start_date = ?, end_date = ?, batch_status = ?, category = ?, note = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $batch_id, $batch_name, $program_code, $start_date, $end_date, $batch_status, $category, $note, $id);

    if ($stmt->execute()) {
        $update_success = true;
    } else {
        $error_message = "Failed to update batch. Please try again.";
    }

    $stmt->close();
}

// Fetch batch details
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT batch_id, batch_name, program_code, start_date, end_date, batch_status, category, note FROM tblbatch WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$batch = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>


<div>
    <h2>Edit Batch</h2>
    <?php if ($update_success): ?>
        <p>Batch successfully updated!</p>
        
        <table class="success-table">
            <tr>
                <th>Batch Id:</th>
                <td><?php echo htmlspecialchars($batch_id); ?></td>
                <th>Batch Name:</th>
                <td><?php echo htmlspecialchars($batch_name); ?></td>
            </tr>
            <tr>
                <th>Program Code:</th>
                <td><?php echo htmlspecialchars($program_code); ?></td>
                <th>Start Date:</th>
                <td><?php echo htmlspecialchars($start_date); ?></td>
            </tr>
            <tr>
                <th>End Date:</th>
                <td><?php echo htmlspecialchars($end_date); ?></td>
                <th>Batch Status:</th>
                <td><?php echo htmlspecialchars($batch_status); ?></td>
            </tr>
            <tr>
                <th>Category:</th>
                <td><?php echo htmlspecialchars($category); ?></td>
                <th>Note:</th>
                <td><?php echo htmlspecialchars($note); ?></td>
            </tr>
        </table>


    <?php else: ?>
        <?php if ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <table>
                <tr>        
                    <td><input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"></td>
                </tr>

                <tr>
                    <td>Batch Id</td>
                    <td><input type="text" name="batch_id" value="<?php echo htmlspecialchars($batch['batch_id']); ?>" placeholder="Batch Id" required></td>
                </tr>

                <tr>
                    <td>Batch Name</td>
                    <td><input type="text" name="batch_name" value="<?php echo htmlspecialchars($batch['batch_name']); ?>" placeholder="Batch Name" required></td>
                </tr>

                <tr>
                    <td>Program Code</td>
                    <td><input type="text" name="program_code" value="<?php echo htmlspecialchars($batch['program_code']); ?>" placeholder="Program Code" required></td>
                </tr>

                <tr>
                    <td>Start Date</td>
                    <td><input type="date" name="start_date" value="<?php echo htmlspecialchars($batch['start_date']); ?>" placeholder="Start Date" required></td>
                </tr>

                <tr>
                    <td>End Date</td>
                    <td><input type="date" name="end_date" value="<?php echo htmlspecialchars($batch['end_date']); ?>" placeholder="End Date" required></td>
                </tr>

                <tr>
                    <td>Batch Status</td>
                    <td><input type="text" name="batch_status" value="<?php echo htmlspecialchars($batch['batch_status']); ?>" placeholder="Batch Status" required></td>
                </tr>

                <tr>
                    <td>Category</td>
                    <td><input type="text" name="category" value="<?php echo htmlspecialchars($batch['category']); ?>" placeholder="Category" required></td>
                </tr>

                <tr>
                    <td>Note</td>
                    <td><textarea name="note" placeholder="Note"><?php echo htmlspecialchars($batch['note']); ?></textarea></td>
                </tr>

                <td><button type="green" value="Update Batch">Update</td>
            </table>

        </form>
    <?php endif; ?>
</div>

</body>
</html>