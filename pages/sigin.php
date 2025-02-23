
<?php
include "../connect.php";
$error="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    if (trim($username) && trim($password) && trim($firstname) && trim($lastname)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error= "User already exists. Please choose a different username.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (firstname,lastname,username, password) VALUES (?,?,?, ?)");
            $stmt->bind_param("ssss",$firstname,$lastname, $username, $hashed_password);
            
            if ($stmt->execute()) {
                echo "<script>window.location.href = './login.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        
        $stmt->close();
    } else {
        $error= "Enter valid username and password or names.";
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
    <title>LOOKBOOK | SIGN UP</title>
</head>

<div class="container">
    <?php include "../components/previousbt.php"?>
    <form class="login-form" method="post">
        <section>SIGN UP</section>
        <section style="display:flex ;">
            <section>First name:<input placeholder="Enter First name " name="firstname" type="text" required class="input-form"></section>
            <section>Last name:<input placeholder="Enter Last name " name="lastname" type="text" required class="input-form"></section>
        </section>
        Username:<input class="input-form" placeholder="Enter your name username"name="username" placeholder="Enter your username" type="text" required>
        Password:<input class="input-form" placeholder="Enter your name password"name="password" placeholder="Enter your password" type="password" required>
        <input class="submit" type="submit" name="submit" value="Sign up">
        <?=$error?"<span class='warning'>$error</span>":"";?>
        <section>Already have an account?  <a style="text-decoration: none;" href="../pages/login.php">Log in</a></section>
    </form>
</div>

</html>
