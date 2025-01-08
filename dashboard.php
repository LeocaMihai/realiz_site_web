<?php
include_once "classes/Database.php";
include_once "classes/Member.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$member = new Member($db);


$totalMembersQuery = "SELECT COUNT(*) as total FROM members";
$totalMembersStmt = $db->prepare($totalMembersQuery);
$totalMembersStmt->execute();
$totalMembers = $totalMembersStmt->fetch(PDO::FETCH_ASSOC)['total'];


$professionDistributionQuery = "SELECT profession, COUNT(*) as count FROM members GROUP BY profession";
$professionDistributionStmt = $db->prepare($professionDistributionQuery);
$professionDistributionStmt->execute();
$professionDistribution = $professionDistributionStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Dashboard</h2>
<div>
    <h3>Total Members: <?php echo $totalMembers; ?></h3>
    <h3>Profession Distribution:</h3>
    <ul>
        <?php foreach ($professionDistribution as $profession): ?>
            <li class="d-flex flex-column flex-sm-row gap-2 mb-4 align-middle justify-content-sm-left">
                <span><?php echo htmlspecialchars($profession['profession']); ?> : <?php echo $profession['count']; ?></span>
                <a class="btn btn-primary btn-sm" href="members.php?profession=<?php echo htmlspecialchars($profession['profession']); ?>">See all</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php
include_once "includes/footer.php";
?>