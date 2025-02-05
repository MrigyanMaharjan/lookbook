
<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
include "../connect.php";

// Fetch stories from the database
$query = "SELECT username,story_title, story_genre, story, date FROM STORIES ORDER BY date DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<h2>All Stories:</h2>";

    while ($row = $result->fetch_assoc()) {

        echo "<div class='story'>";
        echo "<h3>" . htmlspecialchars($row['story_title']) . "</h3>-BY ". htmlspecialchars($row['username']);
        echo "<p><strong>Genre:</strong> " . htmlspecialchars($row['story_genre']) . "</p>"; 
        echo "<p><strong>Created At:</strong> " . htmlspecialchars($row['date']) . "</p>"; 
        echo $row['story']; 
        if($_SESSION["username"]==$row['username']){
            echo"Edit button";
        }
        echo "</div><hr>";
       
        
    }
} else {
    echo "<p>No stories available.</p>";
}

// Close the database connection
$conn->close();
?>
