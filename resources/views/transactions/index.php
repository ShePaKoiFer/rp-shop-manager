<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$enterprise_id = $_GET['enterprise'] ?? null;

$db = Database::get();
if (!$enterprise_id) {
    $enterprise_id = $db->query("SELECT id FROM enterprises ORDER BY id ASC LIMIT 1")->fetchColumn();
}

$enterpriseStmt = $db->prepare("SELECT * FROM enterprises WHERE id=?");
$enterpriseStmt->execute([$enterprise_id]);
$enterprise = $enterpriseStmt->fetch();

$stmt = $db->prepare("SELECT * FROM transactions WHERE enterprise_id=? ORDER BY created_at DESC");
$stmt->execute([$enterprise_id]);
$transactions = $stmt->fetchAll();

$title = "Transactions - " . htmlspecialchars($enterprise['name']);
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Transactions - <?= htmlspecialchars($enterprise['name']) ?></h1>
<a href="form.php?enterprise=<?= $enterprise_id ?>">➕ Nouvelle transaction</a>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Description</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?= htmlspecialchars($t['created_at']) ?></td>
                <td><?= htmlspecialchars($t['type']) ?></td>
                <td><?= htmlspecialchars($t['description']) ?></td>
                <td>$<?= number_format($t['amount'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
