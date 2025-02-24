<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "../connect.php";
$notification = '';

if (isset($_POST['submit'])) {
    $story_title = trim($_POST['story_title']);
    $story_genre = trim($_POST['story_genre']);
    $story = trim($_POST['story']);
    $description = trim($_POST['description']);


    if (!$story_title || !$story_genre || !$story) {
        $notification = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO STORIES (user_id, story_title, story_genre, story,description, date, username) VALUES (?, ?, ?, ?,?, NOW(), ?)");
        
        if ($stmt) {
            $stmt->bind_param("isssss", $_SESSION['user_id'], $story_title, $story_genre, $story,$description, $_SESSION['username']);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                header("Location: ./home.php");
                exit();
            } else {
                $notification = "Failed to publish story. Please try again.";
            }
            $stmt->close();
        } else {
            $notification = "Database error: " . $conn->error;
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Story</title>
    <style>
    :root {
        --primary-color: #D6CCC2;
        --secondary-color: #D5BDAF;
        --accent-color: #E3D5CA;
        --background-color: #F5EBE0;
        --text-color: #575757;
        --hover-color: #4a4a4a;
        --transition-speed: 0.3s;
        --nav-height: 15vh;
        --section-padding: 4rem 2rem;
        --max-width: 1200px;
    }

    .story-container {
        min-height: 100vh;
        background-color: var(--background-color);
        padding: 2rem 1rem;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .story-form {
        width: 100%;
        max-width: 800px;
        background: white;
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin: 2rem auto;
    }

    .form-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .form-title {
        font-size: 2.5rem;
        color: var(--text-color);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .form-subtitle {
        color: var(--text-color);
        opacity: 0.7;
        font-size: 1.1rem;
    }

    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-color);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-control {
        width: 100%;
        padding: 1rem;
        border: 2px solid var(--primary-color);
        border-radius: 12px;
        font-size: 1rem;
        color: var(--text-color);
        background-color: white;
        transition: all var(--transition-speed) ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 4px var(--accent-color);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23575757'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.5em;
        padding-right: 2.5rem;
    }

    .editor-container {
        border: 2px solid var(--primary-color);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 3rem;
    }

    .btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all var(--transition-speed) ease;
        border: none;
        min-width: 120px;
        text-align: center;
        text-decoration: none;
    }

    .btn-primary {
        background-color: var(--secondary-color);
        color: var(--text-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: var(--accent-color);
        color: var(--text-color);
    }

    .btn-secondary:hover {
        background-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: var(--accent-color);
        color: var(--text-color);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: slideIn 0.3s ease;
        z-index: 1000;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @media (max-width: 768px) {
        .story-container { padding: 1rem 0.5rem; }
        .story-form { padding: 1.5rem; margin: 1rem auto; }
        .form-title { font-size: 2rem; }
        .form-subtitle { font-size: 1rem; }
        .form-actions { flex-direction: column; }
        .btn { width: 100%; }
    }

    @media (max-width: 480px) {
        .story-form { padding: 1.25rem; }
        .form-title { font-size: 1.75rem; }
        .form-control { padding: 0.875rem; }
        .form-group { margin-bottom: 1.5rem; }
    }
    </style>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>
    <?php if (!empty($notification)): ?>
    <div class="notification"><?= $notification ?></div>
    <?php endif; ?>
        <?php include "../components/previousbt.php"?>
    <div class="story-container">
        <form method="POST" class="story-form">
            <div class="form-header">
                <h1 class="form-title">Create Your Story</h1>
                <p class="form-subtitle">Share your creative writing with the world</p>
            </div>

            <div class="form-group">
                <label class="form-label" for="story_title">Story Title</label>
                <input 
                    id="story_title"
                    required 
                    placeholder="Enter an engaging title for your story" 
                    class="form-control" 
                    type="text" 
                    name="story_title"
                >
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <input 
                    id="description"
                    required 
                    placeholder="Enter an catchy description for your story" 
                    class="form-control" 
                    type="text" 
                    name="description"
                >
            </div>
            
            <div class="form-group">
                <label class="form-label" for="story-genre">Genre</label>
                <select class="form-control form-select" id="story-genre" required name="story_genre">
                    <option value="" disabled selected>Choose a genre for your story</option>
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
            </div>

            <div class="form-group">
                <label class="form-label" for="editor">Your Story</label>
                <div class="editor-container">
                    <textarea name="story" id="editor"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="./home.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary" name="submit">Publish Story</button>
            </div>
        </form>
    </div>

    <script>
    CKEDITOR.replace('editor', {
        height: 400,
        toolbar: [
            ['Bold', 'Italic', 'Underline', 'Strike'],
            ['NumberedList', 'BulletedList'],
            ['Link', 'Image'],
            ['Undo', 'Redo']
        ],
        removePlugins: 'elementspath,resize,about',
        contentsCss: [
            'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial; font-size: 16px; color: #575757; }'
        ]
    });

    CKEDITOR.on('dialogDefinition', function(ev) {
        if (ev.data.name === 'image') {
            var dialog = ev.data.definition;
            dialog.minWidth = 400;
            
            dialog.removeContents('advanced');
            dialog.removeContents('upload');
            
            var infoTab = dialog.getContents('info');
            infoTab.remove('txtAlt');
            infoTab.remove('txtWidth');
            infoTab.remove('txtHeight');
            infoTab.remove('txtBorder');
            infoTab.remove('ratioLock');
        }
    });
</script>
</body>
</html>