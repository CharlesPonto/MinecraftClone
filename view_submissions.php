<?php
session_start();
require_once 'config.php';

// Generate a session ID if not exists
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = session_id();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Only delete if the message belongs to the current session
    $sql = "DELETE FROM submissions WHERE id = ? AND session_id = ?";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$id, $_SESSION['user_id']]);
        if ($stmt->rowCount() > 0) {
            $success_message = "Message deleted successfully!";
        } else {
            $error_message = "You can only delete your own messages.";
        }
    } catch(PDOException $e) {
        $error_message = "Error deleting message: " . $e->getMessage();
    }
}

// Fetch only submissions from current session
$sql = "SELECT * FROM submissions WHERE session_id = ? ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Your Messages</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <a href="index.php"><img src="assets/logo.svg" alt="Minecraft Logo" class="logo"></a>
            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="section">
        <h2>Your Messages</h2>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (empty($submissions)): ?>
            <p>You haven't submitted any messages yet.</p>
            <p><a href="index.php#contact" class="btn">Submit a Message</a></p>
        <?php else: ?>
            <div id="messages-container">
                <?php foreach ($submissions as $submission): ?>
                    <div class="message-card">
                        <h3><?php echo htmlspecialchars($submission['name']); ?></h3>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($submission['email']); ?></p>
                        <p><strong>Message:</strong> <?php echo htmlspecialchars($submission['message']); ?></p>
                        <p class="meta">Sent on: <?php echo date('F j, Y, g:i a', strtotime($submission['created_at'])); ?></p>
                        <div class="message-actions">
                            <a href="edit_submission.php?id=<?php echo $submission['id']; ?>" class="btnEdit">Edit</a>
                            <a href="view_submissions.php?delete=<?php echo $submission['id']; ?>" class="btnDelete" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2004 Minecraft Adventures. All rights reserved.</p>
    </footer>
</body>
</html> 