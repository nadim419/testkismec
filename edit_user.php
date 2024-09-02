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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $level = $_POST['level'];
    $note = $_POST['note'];

    // Update user details
    $stmt = $conn->prepare("UPDATE tbluser SET nama_id = ?, password_id = ?, nama_penuh = ?, level_id = ?, note = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $username, $password, $full_name, $level, $note, $id);

    if ($stmt->execute()) {
        $update_success = true;
    } else {
        $error_message = "Failed to update user. Please try again.";
    }

    $stmt->close();
}

// Fetch user details
$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT nama_id, password_id, nama_penuh, level_id, note FROM tbluser WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<div>
    <h2>Edit User</h2>
    <?php if ($update_success): ?>
        <p>User successfully updated!</p>        
        <table class="success-table">
            <tr>
                <th>Username:</th>
                <td><?php echo htmlspecialchars($username); ?></td>
                <th>Full Name:</th>
                <td><?php echo htmlspecialchars($full_name); ?></td>
            </tr>
            <tr>
                <th>Level:</th>
                <td><?php echo htmlspecialchars($level); ?></td>
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
                            <td>Username</td>
                            <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['nama_id']); ?>" placeholder="Username" required></td>
                        </tr>

                        <tr>
                            <td>Password</td>
                            <td><input type="password" name="password" value="<?php echo htmlspecialchars($user['password_id']); ?>" placeholder="Password" required></td>
                        </tr>

                        <tr>
                            <td>Full Name</td>
                            <td><input type="text" name="full_name" value="<?php echo htmlspecialchars($user['nama_penuh']); ?>" placeholder="Full Name" required></td>
                        </tr>

                        <tr>
                            <td>Level</td>
                            <td><input type="text" name="level" value="<?php echo htmlspecialchars($user['level_id']); ?>" placeholder="Level" required></td>
                        </tr>

                        <tr>
                            <td>Note</td>
                            <td><textarea name="note" placeholder="Note"><?php echo htmlspecialchars($user['note']); ?></textarea></td>
                        </tr>

                        <td><button type="green" value="Update User">Update</td>
                        <td><button type="red" formaction="list_user.php" formnovalidate>Cancel</button></td>

                    </table>
                </form>
        <?php endif; ?>
</div>

</body>
</html>