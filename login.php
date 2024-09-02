<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <?php
    session_start();
    include("db.php");
    include("head/header.php");
    ?>
</head>
<body>

<?php


$login_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT nama_id, password_id, nama_penuh, level_id, note FROM tbluser WHERE nama_id = ? AND password_id = ?");
    $stmt->bind_param("ss", $username, $password);//sid

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the result
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['nama_id']; // Store username in session
        $_SESSION['user_level'] = $row['level_id']; // Store user level in session
        $_SESSION['note'] = $row['note']; // Store note in session
        
        $login_success = true;
    }

    $stmt->close();
    $conn->close();
}

if ($login_success) {
    include("menu.php"); // Include the menu if login was successful
    ?>
    <div>
        <div>
            <h2>Thank you!</h2>
        </div>
    </div>
    <table>

        <tr>
            <td>Nama Saya:</td> 
            <td><?php echo htmlspecialchars($row['nama_penuh']); ?>.</td>
        </tr>
        <tr>
            <td>Level Saya:</td>
            <td><?php echo htmlspecialchars($row['level_id']); ?>.</td>
        </tr>
        <tr>
            <td>Note:</td>
            <td><?php echo htmlspecialchars($row['note']); ?>.</td>
        </tr>
    </table>
    
    <?php
} else {
    ?>
    
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Login</h2>
                <table>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" id="username" name="username" placeholder="Username" required/></td>
                </tr>    
                <tr><td>Password: </td> 
                    <td><input type="password" id="password" name="password" placeholder="Password" required/></td>
                </tr>

                <tr>
                    <td><button type="green" name="login">Login</td>
                </tr>
                </table>
        </form>
    </div>
    <?php
}
?>

</body>
</html>