<?php
session_start(); // Start session
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row["password"])) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["username"] = $username;
                echo "<script>window.location.href = './home.php';</script>";
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "Invalid username.";
        }
        $stmt->close();
    } else {
        echo "Please enter a valid username and password.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        <input name="username" placeholder="Enter your username" type="text" required>
        <input name="password" placeholder="Enter your password" type="password" required>
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
