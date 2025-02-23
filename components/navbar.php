
<nav>
    <img class="logo" src=" <?=$_SESSION?'../assets/output-removebg-preview.png':"./assets/output-removebg-preview.png"?>
" alt="">
    <section class="navigator"> 
        <?=$_SESSION?'<a class="nav-btn" href="./user_stories.php?id='.$_SESSION['user_id'].'">YOUR STORIES</a>':"<a class='nav-btn' href='#landing'>HOME</a>"?>
        <?=$_SESSION?'<a class="nav-btn" href="./stories.php">STORIES</a>':"<a class='nav-btn' href='./pages/stories.php'>STORIES</a>"?>
        <?=$_SESSION?'<a class="nav-btn" href="./create.php">SHARE A STORY</a>':"<a class='nav-btn' href='./pages/create.php'>SHARE A STORY</a>"?>
    </section>
    <section class="nav-signin"> 
    <?= $_SESSION ? '<a class="nav-btn" ' . htmlspecialchars($_SESSION["username"]) . '</a>' : '<a class="nav-btn" href="./pages/login.php">LOG IN</a>' ?>
    <?=$_SESSION?'<a class="nav-btn" href="./logout.php">LOG OUT</a>':'<a class="sigup-btn" href="./pages/sigin.php">SIGN UP</a>'?> 
   </section>
</nav>    
