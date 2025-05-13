<?php
session_start();
require_once 'config.php';

// Generate a session ID if not exists
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = session_id();
}

if (!isset($_GET['id'])) {
    header('Location: view_submissions.php');
    exit();
}

$id = $_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    $sql = "UPDATE submissions SET name = ?, email = ?, message = ? WHERE id = ? AND session_id = ?";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$name, $email, $message, $id, $_SESSION['user_id']]);
        if ($stmt->rowCount() > 0) {
            $success_message = "Message updated successfully!";
        } else {
            $error_message = "You can only edit your own messages.";
        }
    } catch(PDOException $e) {
        $error_message = "Error updating message: " . $e->getMessage();
    }
}

// Fetch the submission
$sql = "SELECT * FROM submissions WHERE id = ? AND session_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id, $_SESSION['user_id']]);
$submission = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$submission) {
    header('Location: view_submissions.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Message</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <a href="index.php"><img src="assets/logo.svg" alt="Minecraft Logo" class="logo"></a>
            <nav class="navbar">
                <ul>
                    <li><a href="view_submissions.php">Back to Messages</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="section">
        <h2>Edit Message</h2>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($submission['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($submission['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required><?php echo htmlspecialchars($submission['message']); ?></textarea>
            </div>

            <button type="submit" class="btn">Update</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2004 Minecraft Adventures. All rights reserved.</p>
    </footer>
</body>
</html> 