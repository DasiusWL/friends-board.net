<?php
session_start();
require '../databaseconnect.php';
if (!isset($_GET['id'])) {
    echo "Group not found.";
    exit();
}
$group_id = $_GET['id'];
$user_id = $_SESSION['user_id'] ?? null;
$stmt = $conn->prepare("SELECT g.*, u.username AS creator_name FROM groups g JOIN users u ON g.creator_id = u.id WHERE g.id = ?");
$stmt->execute([$group_id]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$group) {
    echo "Group not found.";
    exit();
}
$memberCheckStmt = $conn->prepare("
    SELECT * FROM groups 
    WHERE id = ? AND (
        creator_id = ? OR 
        EXISTS (SELECT 1 FROM group_memberships WHERE group_id = ? AND user_id = ?)
    )
");
$memberCheckStmt->execute([$group_id, $user_id, $group_id, $user_id]);
$userIsMemberOrCreator = $memberCheckStmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Friends-Board</title>
    <link rel="stylesheet" href="group.css"></link>
</head>
<body>

    <h1 class="name"><?= htmlspecialchars($group['name']) ?></h1>
    <p>Description: <?= htmlspecialchars($group['description']) ?></p>
    <p>Created by: <?= htmlspecialchars($group['creator_name']) ?></p>
    <a class="backbtn"href="yourgroups.php">Back to Your Groups</a>
    <hr>
    <?php if ($userIsMemberOrCreator): ?>
        <h2>Create Event</h2>
        <div id="events">
            <form action="add_event.php" method="POST">
                <input type="hidden" name="group_id" value="<?= htmlspecialchars($group_id) ?>">

                <label for="title">Event Title: </label><br>
                <input type="text" name="title" id="title" maxlength="30" required><br><br>

                <label for="description">Description: </label><br>
                <input type="text" name="description" id="description"  maxlength="144"></input><br><br>

                <label for="event_time">Event Time:</label><br>
                <input type="datetime-local" name="event_time" id="event_time" required><br><br>

                <button class="submit" type="submit">Submit Event</button>
            </form>
        </div>


    <?php else: ?>
        <p>You must be a member of this group to post events.</p>
    <?php endif; ?>

    <hr>
    <h2>Upcoming Events</h2>

    <?php
    $stmt = $conn->prepare("SELECT e.*, u.username FROM events e JOIN users u ON e.created_by = u.id WHERE e.group_id = ? ORDER BY event_time ASC");
    $stmt->execute([$group_id]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($events) === 0) {
        echo "<p>No events have been posted yet.</p>";
    } else {
        foreach ($events as $event) {
            echo "<div class='event-card'>";
            echo "<h3>" . htmlspecialchars($event['title']) . "</h3>";
            echo "<p>Date & Time: " . htmlspecialchars($event['event_time']) . "</p>";
            echo "<p>Description: ". nl2br(htmlspecialchars($event['description'])) . "</p>";
            echo "<p>Posted by: " . htmlspecialchars($event['username']) . "</p>";
            echo '
            <form action="delete_event.php" method="POST">
                <input type="hidden" name="event_id" value="' . $event['id'] . '">
                <button type="submit" class="deletebtn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/>
                    </svg>
                </button>
            </form>
        ';
            echo "</div><hr>";
            
        }
    }
    ?>

</body>
</html>