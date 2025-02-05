<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>
    <form method="post" class="container">
        <span style="font-size: large;">TITLE:</span>
        <input required placeholder="Enter a title for your story" class="submit" type="text" name="story_title">
        
        <label for="story-genre">GENRE:</label>
        <select class="submit" id="story-genre" required name="story_genre">
            <option value="adventure">Adventure</option>
            <option value="comedy">Comedy</option>
            <option value="crime">Crime</option>
            <option value="drama">Drama</option>
            <option value="fantasy">Fantasy</option>
            <option value="historical">Historical</option>
            <option value="horror">Horror</option>
            <option value="mystery">Mystery</option>
            <option value="mythology">Mythology</option>
            <option value="romance">Romance</option>
            <option value="sci-fi">Science Fiction</option>
            <option value="thriller">Thriller</option>
            <option value="tragedy">Tragedy</option>
            <option value="western">Western</option>
        </select>

        <textarea name="story" id="editor"></textarea>
        <script>
            CKEDITOR.replace('editor');
        </script>        

        <input type="submit" class="submit" name="submit" value="Done">
    </form>

<?php
include "../connect.php";  

if (isset($_POST['submit'])) {
    $story_title = trim($_POST['story_title']);
    $story_genre = trim($_POST['story_genre']);
    $story = trim($_POST['story']);

    if (!$story_title || !$story_genre || !$story) {
        echo "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO STORIES (story_title, story_genre, story, date,username) VALUES (?, ?, ?, NOW(),?)");

        if ($stmt) {
            $stmt->bind_param("ssss", $story_title, $story_genre, $story,$_SESSION['username']);
            $stmt->execute(); 
            
            if ($stmt->affected_rows > 0) {
                header("Location: ./home.php"); // Goes to the root home.php
            } else {

                echo "Failed to add post.";
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }

    $conn->close();
}
?>
</body>
</html>
