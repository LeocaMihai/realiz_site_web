<?php
include_once "classes/Member.php";
include_once "classes/ProfilePicture.php";
include_once "classes/Database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$member = new Member($db);
$profilePicture = new ProfilePicture();


if (isset($_GET['id'])) {
    $memberId = $_GET['id'];
    $memberData = $member->getById($memberId);
}

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

    if ($member->update($memberId, $data, $profilePicturePath)) {
        if($profilePicturePath != null) {
            $profilePicture-> deleteIfExists($memberData['profile_picture']);
        }
    
        header("Location: members.php");
        exit();
    }
}
?>

<div class="container">
    <h2>Edit Member</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" value="<?php echo htmlspecialchars($memberData['first_name']); ?>"
                name="first_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" value="<?php echo htmlspecialchars($memberData['last_name']); ?>"
                name="last_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" value="<?php echo htmlspecialchars($memberData['email']); ?>"
                name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="profession">Profession</label>
            <input type="text" value="<?php echo htmlspecialchars($memberData['profession']); ?>"
                name="profession" class="form-control">
        </div>

        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" value="<?php echo htmlspecialchars($memberData['company']); ?>"
                name="company" class="form-control">
        </div>

        <div class="form-group">
            <label for="expertise">Expertise</label>
            <textarea name="expertise" class="form-control"><?php echo htmlspecialchars($memberData['expertise']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="linkedin_profile">LinkedIn Profile</label>
            <input type="url" value="<?php echo htmlspecialchars($memberData['linkedin_profile']); ?>"
                name="linkedin_profile" class="form-control">
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

    <?php
    include_once "includes/footer.php";
    ?>