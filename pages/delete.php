<?php
session_start();
include "../connect.php"; 

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Changed from $_GET to $_POST
$story_id = $_POST["id"];
$author_id = $_POST["author"];
$current_user_id = $_SESSION["user_id"];

if ($current_user_id != $author_id) {
    $_SESSION["error"] = "Unauthorized action!";
    header("Location: ../pages/stories.php"); 
    exit();
}

$stmt = $conn->prepare("DELETE FROM STORIES WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $story_id, $author_id);

if ($stmt->execute()) {
    $_SESSION["success"] = "Story deleted successfully.";
} else {
    $_SESSION["error"] = "Failed to delete the story.";
}

$stmt->close();
$conn->close();

header("Location: ../pages/stories.php");
exit();
?>