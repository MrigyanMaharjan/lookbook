<?php 
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
$user_name = $_SESSION["username"] ?? "Guest"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Basic Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
    background: #EDEDE9;
}

.hero {
    text-align: center;
    padding: 50px;
    background: #f4f4f4;
    border-radius: 10px;
    margin-bottom: 20px;
}

.hero h1 {
    font-size: 2rem;
    margin-bottom: 10px;
}

.hero p {
    font-size: 1.1rem;
    color: #555;
}

.btn {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.btn:hover {
    background: #0056b3;
}



    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Your Story | Homepage</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <?php include "../components/navbar.php"; ?>

    <div class="container">
        <header class="hero">
            <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <p>Share your journey, inspire others, and connect with a community of storytellers.</p>
            <a href="./create.php" class="btn">Share Your Story</a>
            <a href="./stories.php" class="btn">Read Other's Stories</a>
        </header>

     
    </div>
    <?php include "../components/footer.php"?>
</body>
</html>
