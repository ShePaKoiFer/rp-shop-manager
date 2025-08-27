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

$stmt = $db->prepare("SELECT * FROM stock WHERE enterprise_id=? ORDER BY name ASC");
$stmt->execute([$enterprise_id]);
$stocks = $stmt->fetchAll();

$title = "Stock - " . htmlspecialchars($enterprise['name']);
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Stock - <?= htmlspecialchars($enterprise['name']) ?></h1>
<a href="form.php?enterprise=<?= $enterprise_id ?>">➕ Nouvel article stock</a>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Quantité</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stocks as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <td><?= $s['quantity'] ?></td>
                <td>
                    <a href="form.php?id=<?= $s['id'] ?>&enterprise=<?= $enterprise_id ?>">✏️ Modifier</a> | 
                    <a href="delete.php?id=<?= $s['id'] ?>&enterprise=<?= $enterprise_id ?>" onclick="return confirm('Supprimer cet article du stock ?')">🗑 Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
