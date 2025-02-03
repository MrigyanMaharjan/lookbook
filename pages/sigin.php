<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOOKBOOK | Sign in</title>
</head>
<body>
    <form method="post">
        <input name="username" placeholder="Enter your username" type="text" required>
        <input name="password" placeholder="Enter your password" type="password" required>
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>

<?php
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "User already exists. Please choose a different username.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);
            
            if ($stmt->execute()) {
                echo "<script>window.location.href = './login.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        
        $stmt->close();
    } else {
        echo "Enter a valid username and password.";
    }
}
$conn->close();
?>
