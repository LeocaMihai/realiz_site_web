<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$searchQuery = $_GET['query'] ?? '';

$query = "SELECT * FROM members
          WHERE first_name LIKE :search
          OR last_name LIKE :search
          OR profession LIKE :search";
$stmt = $db->prepare($query);
$stmt->bindValue(':search', "%$searchQuery%", PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Search Results</h2>
<form method="GET" class="form-inline mb-4">
    <input type="text" name="query" class="form-control mr-2" placeholder="Search..." value="<?php echo htmlspecialchars($searchQuery); ?>">
    <button type="submit" class="btn btn-primary">Search</button>
</form>
<div class="row">
    <?php foreach ($results as $result): ?>
        <div class="col-md-4">
            <div class="card member-card">
                <img src="<?php echo htmlspecialchars($result['profile_picture']); ?>" class="card-img-top" alt="Profile Picture">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($result['first_name'] . ' ' . $result['last_name']); ?></h5>
                    <p class="card-text">
                        <strong>Profession:</strong> <?php echo htmlspecialchars($result['profession']); ?><br>
                        <strong>Company:</strong> <?php echo htmlspecialchars($result['company']); ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
include_once "includes/footer.php";
?>
