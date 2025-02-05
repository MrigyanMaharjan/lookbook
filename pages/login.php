<?php
session_start(); // Start session
include "../connect.php";
$error="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
   
    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, password,firstname,lastname FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row["password"])) {
                var_dump($row);
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["firstname"]=$row["firstname"];
                $_SESSION["lastname"]=$row["lastname"];
                $_SESSION["username"] = $username;
                echo "<script>window.location.href = './home.php';</script>";
            } else {
                $error= "Invalid password.";
            }
        } else {
            $error= "Invalid username.";
        }
        $stmt->close();
    } else {
        $error="Please enter a valid username and password.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<div class="container">
    <form class="login-form" method="post">
        <section>LOG IN</section>
        Username:<input class="input-form" placeholder="Enter your name username"name="username" placeholder="Enter your username" type="text" required>
        Password:<input class="input-form" placeholder="Enter your name password"name="password" placeholder="Enter your password" type="password" required>
        <input class="submit" type="submit" name="submit" value="Login">
        <?=$error?"<span class='warning'>$error</span>":"";?>
        <section>Don't have an account?  <a style="text-decoration: none;" href="../pages/sigin.php">Sign up</a></section>
    </form>
</div>
</html>
