<?php
include_once "classes/Member.php";
include_once "classes/Database.php";

$database = new Database();
$db = $database->getConnection();

$member = new Member($db);


if (isset($_GET['id'])) {
    $memberId = $_GET['id'];
    $memberData = $member->getById($memberId);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profilePicture = $memberData['profile_picture']; 

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

    if ($member->update($memberId, $data, $profilePicture)) {
        header("Location: members.php");
        exit();
    }
}
?>

<div class="form-container">
    <h2>Edit Member</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($memberData['first_name']); ?>" required>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($memberData['last_name']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($memberData['email']); ?>" required>
        <input type="text" name="profession" value="<?php echo htmlspecialchars($memberData['profession']); ?>">
        <input type="text" name="company" value="<?php echo htmlspecialchars($memberData['company']); ?>">
        <textarea name="expertise"><?php echo htmlspecialchars($memberData['expertise']); ?></textarea>
        <input type="url" name="linkedin_profile" value="<?php echo htmlspecialchars($memberData['linkedin_profile']); ?>">
        <input type="file" name="profile_picture">
        <button type="submit">Update Member</button>
    </form>
</div>
