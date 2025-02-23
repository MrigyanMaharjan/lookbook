
<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: ./pages/home.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="./assets/output.jpg"> 
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHARE YOUR STORY</title>
</head>
<body>
    <?php include "./components/navbar.php"?>
    <div id="landing" class="landing">
    <section class="hero">
    <div class="hero-content">
        <h1>Share Your Story, Inspire the World</h1>
        <p>Everyone has a story to tell. Whether it’s a moment of triumph, a lesson learned, or a journey of self-discovery—<strong>your words matter</strong></p>
        
       

        <a href="./pages/login.php" class="share-btn">Start Writing <i class="fa-solid fa-arrow-right"></i></a>
    </div>


    <section>
        <img  class="img" src="./assets/8e5cf638-0e15-4ca5-820a-d4286896957d.png" alt="">
    </section>
    </div>
    </section>
 

<a href="#feature"><i class="fa-solid fa-angle-down floating-btn"></i>
</a>
    <div id="feature" class="feature">This is a feature page</div>
    <?php include "./components/footer.php"?>

</body>
</html>