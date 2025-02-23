

<?php
session_start();
$post_id = $_GET['id']; 
include "../connect.php";
include "../components/previousbt.php";
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php
    $result=$conn->query("SELECT story_title from STORIES WHERE id=$post_id");
     $name=$result->fetch_assoc();
    echo $name['story_title'];
    

    ?></title>
</head>
<style>
:root {
    --primary-color: #2c3e50;
    --secondary-color: #34495e;
    --accent-color: #3498db;
    --text-color: #333;
    --background-color: #F5EBE0;
    --card-bg: #ffffff;
}

body {
    font-family:Arial, Helvetica, sans-serif;;
    background-color: var(--background-color);
    color: var(--text-color);
    line-height: 1.6;
}

.story-description-container {
    max-width: 95vw;
    min-height: 100vh;
    margin: 2rem auto;
    overflow-wrap: break-word;
    padding: 2rem;
}

.story-header {
    margin-bottom: 2rem;
    text-align: center;
}

.story-title {
    color: var(--primary-color);
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.story-meta {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
    color: #7f8c8d;
}

.story-author {
    color: var(--accent-color);
    font-weight: 600;
}

.story-content {
    background-color: var(--card-bg);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    font-size: 1.1rem;
    line-height: 1.8;
    white-space: pre-wrap;
}

.edit-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    margin-top: 1.5rem;
    background-color: var(--accent-color);
    color: white;
    border-radius: 6px;
    text-decoration: none;
    transition: transform 0.2s, background-color 0.2s;
}

.edit-btn:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
}

.icon {
    width: 1.2rem;
    height: 1.2rem;
}

@media (max-width: 768px) {
    .story-description-container {
        padding: 1rem;
        margin: 1rem auto;
    }

    .story-title {
        font-size: 2rem;
    }

    .story-content {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .story-meta {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .story-title {
        font-size: 1.75rem;
    }
}
</style>

</html>
<?php


$stmt = $conn->prepare("SELECT * FROM STORIES WHERE id = ?");
$stmt->bind_param("i", $post_id); 
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) :
?>
 <?php while($row = $result->fetch_assoc()): ?>
    <div class="story-description-container">
    <div class="story-header">
        <h1 class="story-title"><?= htmlspecialchars($row['story_title']) ?></h1>
        <div class="story-meta">
            <a href="../pages/user_stories.php?id=<?= $row['user_id'] ?>" class="story-author">@<?= htmlspecialchars($row['username']) ?></a>
            <span class="story-date"><?= date('M d, Y', strtotime($row['date'])) ?></span>
            <span class="story-genre"><?= htmlspecialchars($row['story_genre']) ?></span>
        </div>
    </div>

    <div class="story-content">
        <?=$row['story'] ?>
    </div>

    <?php if ($_SESSION["username"] == $row['username']): ?>
    <a href="edit_story.php?id=<?= $row['id'] ?>&author=<?= $row['user_id'] ?>" class="edit-btn">
        <svg aria-hidden="true" class="icon" viewBox="0 0 24 24">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
        </svg>
        Edit Story
    </a>
    <form action="./delete.php" method="POST" style="display: inline; z-index:100;">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="hidden" name="author" value="<?= $row['user_id'] ?>">
    <button class="edit-btn" style="background-color: #e63946; border:4px solid #e63946;" type="submit" class="delete-btn" onclick="return confirmDelete()">
        <svg aria-hidden="true" class="icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 6h18v2H3V6zm2 3h14v12H5V9zm5 2v8h2v-8h-2zm4 0v8h2v-8h-2z"/>
        </svg>
        Delete
    </button>
</form>
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this story? This action cannot be undone.');
}
</script>
    <?php endif; ?>
    <?php endwhile; ?>
    <?php endif; ?>
</div>
</div>
<?php
$stmt->close();
$conn->close();
?>

