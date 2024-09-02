<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Funder</title>
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
    $funder = $_POST['funder'];
    $note = $_POST['note'];

    // Update user details
    $stmt = $conn->prepare("UPDATE tblfunder SET funder = ?, note = ? WHERE id = ?");
    $stmt->bind_param("ssi", $funder, $note, $id);

    if ($stmt->execute()) {
        $update_success = true;
    } else {
        $error_message = "Failed to update user. Please try again.";
    }

    $stmt->close();
}

// Fetch user details
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT funder, note FROM tblfunder WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$funders = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<div>
    <h2>Edit User</h2>

    <?php if ($update_success): ?>
        
        <p>User successfully updated!</p>
        <table class="success-table">
            <tr>
                <td>Funder:</td>
                <td><?php echo htmlspecialchars($funder); ?></td>
            </tr>
            <tr>
                <td>Note:</td>
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
                    <td>Funder</td>
                    <td><input type="text" name="funder" value="<?php echo htmlspecialchars($funders['funder']); ?>" placeholder="Funder" required></td>
                </tr>

                <tr>        
                    <td>Note</td>
                    <td><textarea name="note" placeholder="Note"><?php echo htmlspecialchars($funders['note']); ?></textarea></td>
                <tr>
            
        
                <td><button type="green" value="Update Funder">Update</td>
                <td><button type="red" formaction="list_funder.php" formnovalidate>Cancel</button></td>

            </table>

        </form>

    <?php endif; ?>
</div>

</body>
</html>
