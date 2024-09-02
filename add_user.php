<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Management</title>
    <?php
    session_start();
    include("db.php");
    include("head/header.php");
    include("menu.php");
    include 'head/container.php';
    ?>
</head>
<body>
<?php


$add_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $level = $_POST['level'] ?? '';
    $note = $_POST['note'] ?? '';

    if ($username && $password && $full_name && $level) {
        $stmt = $conn->prepare("INSERT INTO tbluser (nama_id, password_id, nama_penuh, level_id, note) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $full_name, $level, $note);

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
    <table>
        <tr>
            <td><h2>Username: </h2></td>
            <td><?php echo htmlspecialchars($username); ?>.</td>
        </tr>
        <tr>
            <td><h2>Full Name: </h2></td>
            <td><?php echo htmlspecialchars($full_name); ?>.</td>
        </tr>
        <tr>
            <td><h2>Level: </h2></td>
            <td><?php echo htmlspecialchars($level); ?>.</td>
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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h2>Add User</h2> 
            <table type="adduser">
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Username" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Full Name" required></td>
                </tr>
                <tr>
                    <td>Level:</td>
                    <td><input type="text" name="level" placeholder="Level" required></td>
                </tr>
                <tr>
                    <td>Note:</td>
                    <td><textarea name="note" placeholder="Note"></textarea></td>
                </tr>
                
                <td><button type="green" value="Add User">Register</td>
                <td><button type="red" formaction="list_user.php" formnovalidate>Cancel</button></td>
            </table>
        </form>
    </div>
<?php
}
?>

</body>
</html>