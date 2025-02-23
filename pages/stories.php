<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Hub</title>
    <link rel="stylesheet" href="../stories.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .search-section {
            max-width: 100%;
            margin: 0 0 2rem 0;
            padding: 1rem;
            border-radius: 12px;
            background:#EFEFEF;
        }

        .search-container {
            display: flex;

            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-group {
            flex: 1;
            min-width: 200px;
        }

        .search-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--secondary-color);
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            color: var(--text-color);
            transition: all var(--transition-speed) ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(227, 213, 202, 0.2);
        }

        .search-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--secondary-color);
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            color: var(--text-color);
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23575757'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.5em;
            padding-right: 2.5rem;
        }

        .search-button {
            padding: 0.75rem 1.5rem;
            background: var(--secondary-color);
            border: none;
            border-radius: 8px;
            color: var(--text-color);
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            align-self: flex-end;
        }

        .search-button:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }

        .reset-button {
            padding: 0.75rem 1.5rem;
            background: var(--accent-color);
            border: none;
            border-radius: 8px;
            color: var(--text-color);
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            align-self: flex-end;
        }

        .reset-button:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .search-container {
                flex-direction: column;
            }

            .search-group {
                min-width: 100%;
            }

            .search-button,
            .reset-button {
                width: 100%;
            }
        }
    </style>
    <?php
    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    include "../connect.php";

    $search_title = isset($_GET['search_title']) ? $_GET['search_title'] : '';
    $search_genre = isset($_GET['search_genre']) ? $_GET['search_genre'] : '';

    $query = "SELECT id, user_id, username, story_title, story_genre,description, story, date FROM STORIES";

    $conditions = [];
    $params = [];
    $types = "";

    if (!empty($search_title)) {
        $conditions[] = "story_title LIKE ?";
        $params[] = "%$search_title%";
        $types .= "s";
    }

    if (!empty($search_genre)) {
        $conditions[] = "story_genre = ?";
        $params[] = $search_genre;
        $types .= "s";
    }

    // Combine conditions if any exist
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " ORDER BY date DESC";

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    include "../components/previousbt.php";
    ?>
</head>
<body>
    <div class="cont">
        <h1 class="page-title">Stories</h1>
        
        <!-- Search Section -->
        <div class="search-section">
            <form method="GET" class="search-container">
                <div class="search-group">
                    <label class="search-label" for="search_title">Search by Title</label>
                    <input 
                        type="text" 
                        id="search_title" 
                        name="search_title" 
                        class="search-input"
                        placeholder="Enter story title..."
                        value="<?= htmlspecialchars($search_title) ?>"
                    >
                </div>
                
                <div class="search-group">
                    <label class="search-label" for="search_genre">Filter by Genre</label>
                    <select class="search-select" id="search_genre" name="search_genre">
                        <option value="">All Genres</option>
                        <option value="adventure" <?= $search_genre === 'adventure' ? 'selected' : '' ?>>Adventure</option>
                        <option value="comedy" <?= $search_genre === 'comedy' ? 'selected' : '' ?>>Comedy</option>
                        <option value="crime" <?= $search_genre === 'crime' ? 'selected' : '' ?>>Crime</option>
                        <option value="drama" <?= $search_genre === 'drama' ? 'selected' : '' ?>>Drama</option>
                        <option value="fantasy" <?= $search_genre === 'fantasy' ? 'selected' : '' ?>>Fantasy</option>
                        <option value="historical" <?= $search_genre === 'historical' ? 'selected' : '' ?>>Historical</option>
                        <option value="horror" <?= $search_genre === 'horror' ? 'selected' : '' ?>>Horror</option>
                        <option value="mystery" <?= $search_genre === 'mystery' ? 'selected' : '' ?>>Mystery</option>
                        <option value="mythology" <?= $search_genre === 'mythology' ? 'selected' : '' ?>>Mythology</option>
                        <option value="romance" <?= $search_genre === 'romance' ? 'selected' : '' ?>>Romance</option>
                        <option value="sci-fi" <?= $search_genre === 'sci-fi' ? 'selected' : '' ?>>Science Fiction</option>
                        <option value="thriller" <?= $search_genre === 'thriller' ? 'selected' : '' ?>>Thriller</option>
                        <option value="tragedy" <?= $search_genre === 'tragedy' ? 'selected' : '' ?>>Tragedy</option>
                        <option value="western" <?= $search_genre === 'western' ? 'selected' : '' ?>>Western</option>
                    </select>
                </div>

                <button type="submit" class="search-button">Search</button>
                <?php if (!empty($search_title) || !empty($search_genre)): ?>
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" class="reset-button">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Stories Grid -->
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
    <div class="story-actions">
        <a href="edit_story.php?id=<?= $row['id'] ?>&author=<?= $row['user_id'] ?>" class="edit-btn">
            <svg aria-hidden="true" class="icon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
            </svg>
            Edit
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
    </div>
<?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-stories">
                    No stories found. Try different search criteria or be the first to share!
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

