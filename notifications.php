<?php
include_once "classes/Database.php";
include_once "classes/Notification.php";

$database = new Database();
$db = $database->getConnection();

$notification = new Notification($db);
$notifications = $notification->getAll();
?>

<h2>Notifications</h2>
<ul>
    <?php foreach ($notifications as $note): ?>
        <li>
            <strong><?php echo htmlspecialchars($note['first_name'] . ' ' . $note['last_name']); ?>:</strong>
            <?php echo htmlspecialchars($note['message']); ?>
            <small>(<?php echo htmlspecialchars($note['created_at']); ?>)</small>
        </li>
    <?php endforeach; ?>
</ul>
