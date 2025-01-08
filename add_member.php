<?php

include_once "classes/Member.php";
include_once "classes/ProfilePicture.php";
include_once "includes/header.php";
include_once "classes/Database.php";

$database = new Database();
$db = $database->getConnection();

$member = new Member($db);
$profilePicture = new ProfilePicture();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profilePicturePath = $profilePicture->save($_FILES['profile_picture']);

    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'profession' => $_POST['profession'],
        'company' => $_POST['company'],
        'expertise' => $_POST['expertise'],
        'linkedin_profile' => $_POST['linkedin_profile']
    ];

    if ($member->create($data, $profilePicturePath)) {
        $lastId = $db->lastInsertId();
        header("Location: members.php");
        exit();
    }
}
?>

<div class="container">
    <h2>Add New Member</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="profession">Profession</label>
            <input type="text" name="profession" class="form-control">
        </div>

        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" name="company" class="form-control">
        </div>

        <div class="form-group">
            <label for="expertise">Expertise</label>
            <textarea name="expertise" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="linkedin_profile">LinkedIn Profile</label>
            <input type="url" name="linkedin_profile" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control" aria-label="profile picture">
        </div>

        <div class="d-flex justify-content-center mt-3">
            <div class="btn-toolbar gap-3" role="toolbar" aria-label="Member form actions">
                <a onclick="history.back()" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>
<?php
include_once "includes/footer.php";
?>