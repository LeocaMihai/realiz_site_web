<?php

include_once "classes/Member.php";
include_once "classes/Notification.php";
include_once "includes/header.php";
include_once "classes/Database.php";

$database = new Database();
$db = $database->getConnection();

$member = new Member($db);
$notification = new Notification($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profilePicture = 'uploads/default.png';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['profile_picture']['name']);
        $targetFilePath = $uploadDir . uniqid() . "_" . $fileName;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFilePath)) {
            $profilePicture = $targetFilePath;
        }
    }

    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'profession' => $_POST['profession'],
        'company' => $_POST['company'],
        'expertise' => $_POST['expertise'],
        'linkedin_profile' => $_POST['linkedin_profile']
    ];

    if ($member->create($data, $profilePicture)) {
        $lastId = $db->lastInsertId();
        $notification->create($lastId, "Welcome " . $_POST['first_name'] . "! You have successfully joined Women in FinTech.");
        header("Location: members.php");
        exit();
    }
}
?>

<div class="form-container">
    <h2>Add New Member</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Profession</label>
            <input type="text" name="profession" class="form-control">
        </div>

        <div class="form-group">
            <label>Company</label>
            <input type="text" name="company" class="form-control">
        </div>

        <div class="form-group">
            <label>Expertise</label>
            <textarea name="expertise" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>LinkedIn Profile</label>
            <input type="url" name="linkedin_profile" class="form-control">
        </div>

        <div class="form-group">
            <label>Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-success">Add Member</button>
    </form>
</div>
<?php
include_once "includes/footer.php";
?>
