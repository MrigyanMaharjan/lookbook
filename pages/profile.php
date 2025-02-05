
<?php
session_start();
var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFILE</title>
</head>
<body>
<h2>Welcome, <?php echo $_SESSION["firstname"]; ?>!</h2>
    <p>You are now logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>