<?php
include_once "classes/Member.php";
include_once "classes/Database.php";

$database = new Database();
$db = $database->getConnection();

$member = new Member($db);

if (isset($_GET['id'])) {
    $memberId = $_GET['id'];
    if ($member->delete($memberId)) {
        header("Location: members.php");
        exit();
    } else {
        echo "Failed to delete member.";
    }
}
?>
