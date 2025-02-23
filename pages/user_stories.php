

<?php
session_start();
$user_id = $_GET['id']; 
include "../connect.php";
include "../components/previousbt.php";
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../stories.css">
    <title><?php
    $result=$conn->query("SELECT firstname,lastname from USERS WHERE id=$user_id");
     $name=$result->fetch_assoc();
    echo $name['firstname']." ".$name['lastname'];
    

    ?></title>
</head>

</html>
<?php


$stmt = $conn->prepare("SELECT * FROM STORIES WHERE user_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) :
?>
    <div class="cont">
        <h1 class="page-title">Stories-By <?=$name['firstname'].' '. $name['lastname']?></h1>
        <div class="stories-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                        <div onclick="window.location='../pages/description.php?id=<?=$row['id']?>'" class="story-card">
                    <div class="story-header">
                            <h3 class="story-title"><?= htmlspecialchars($row['story_title']) ?></h3>
                            <div class="story-meta">
                                <a href='../pages/user_stories.php?id=<?= $row['user_id'] ?>' class="story-author">@<?= htmlspecialchars($row['username']) ?></a>
                                <span class="story-date"><?= date('M d, Y', strtotime($row['date'])) ?></span>
                                <span class="story-genre"><?= htmlspecialchars($row['story_genre']) ?></span>
                            </div>
                        </div>
                        <div class="story-content">
                        <?php
                            echo $row['description'];

                            ?>

                        </div>
                        <?php if ($_SESSION["username"] == $row['username']): ?>
                            <a href="edit_story.php?id=<?= $row['id'] ?>&author=<?= $row['user_id'] ?>" class="edit-btn">
                                <svg aria-hidden="true" class="icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
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
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-stories">
                    No stories found. Be the first to share!
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif;
$stmt->close();
$conn->close();
?>

