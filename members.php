<?php
include_once "classes/Member.php";
include_once "classes/Database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$member = new Member($db);


$filterProfession = $_GET['profession'] ?? '';
$filterCompany = $_GET['company'] ?? '';
$sortBy = $_GET['sort_by'] ?? 'created_at';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;
$offset = ($page - 1) * $perPage;


$totalMembers = $member->getTotal($filterProfession);
if (!is_int($totalMembers)) {
    echo "Error: Total members is not an integer.";
    var_dump($totalMembers);
    exit;
}

$totalPages = ceil($totalMembers / $perPage);

$members = $member->getAll($filterProfession, $sortBy, $perPage, $offset);
if (!is_array($members)) {
    echo "Error: Members data is not an array.";
    var_dump($members);
    exit;
}

?>

<h2>Members Directory</h2>

<form method="GET" class="d-flex flex-column flex-md-row gap-2 mb-4 align-middle">
    <div class="form-group mr-2">
        <input type="text" name="profession" class="form-control form-control-sm" placeholder="Profession"
            value="<?php echo htmlspecialchars($filterProfession); ?>">
    </div>
    <div class="form-group mr-2">
        <input type="text" name="company" class="form-control form-control-sm" placeholder="Company"
            value="<?php echo htmlspecialchars($filterCompany); ?>">
    </div>
    <div class="form-group">
        <select name="sort_by" class="form-control  form-control-sm">
            <option value="created_at" <?php echo $sortBy === 'created_at' ? 'selected' : ''; ?>>Newest</option>
            <option value="name" <?php echo $sortBy === 'name' ? 'selected' : ''; ?>>Full Name</option>
        </select>
    </div>
    <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
</form>

<?php if (empty($members)): ?>
    <div class="alert alert-info" role="alert">
        No members found.
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($members as $m): ?>
            <div class="col-md-4">
                <div class="card member-card">

                    <?php if ($m['profile_picture'] != null): ?>
                        <img src="<?php echo htmlspecialchars($m['profile_picture']); ?>" class="card-img-top" alt="Profile Picture">
                    <?php else: ?>
                        <img src="image/profile_default.jpg" class="card-img-top" alt="Profile Picture">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($m['first_name'] . ' ' . $m['last_name']); ?></h5>
                        <p class="card-text">
                            <strong>Profession:</strong> <?php echo htmlspecialchars($m['profession']); ?><br>
                            <strong>Company:</strong> <?php echo htmlspecialchars($m['company']); ?>
                        </p>
                        <a href="edit_member.php?id=<?php echo $m['id']; ?>" class="btn btn-success">Edit</a>
                        <a href="delete_member.php?id=<?php echo $m['id']; ?>" class="btn btn-danger"
                            onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav>
        <ul class="pagination mt-5">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&profession=<?php echo urlencode($filterProfession); ?>&sort_by=<?php echo urlencode($sortBy); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php
include_once "includes/footer.php";
?>