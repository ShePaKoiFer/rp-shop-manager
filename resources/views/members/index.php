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

$stmt = $db->prepare("SELECT * FROM members WHERE enterprise_id=? ORDER BY id ASC");
$stmt->execute([$enterprise_id]);
$members = $stmt->fetchAll();

$title = "Membres - " . htmlspecialchars($enterprise['name']);
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Membres - <?= htmlspecialchars($enterprise['name']) ?></h1>
<a href="form.php?enterprise=<?= $enterprise_id ?>">➕ Nouveau membre</a>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Rôle</th>
            <th>Salaire fixe ($/sem)</th>
            <th>Taux horaire ($/h)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($members as $m): ?>
            <tr>
                <td><?= htmlspecialchars($m['name']) ?></td>
                <td><?= htmlspecialchars($m['role']) ?></td>
                <td><?= number_format($m['salary'], 2) ?></td>
                <td><?= number_format($m['hourly_rate'], 2) ?></td>
                <td>
                    <a href="form.php?id=<?= $m['id'] ?>&enterprise=<?= $enterprise_id ?>">✏️ Modifier</a> | 
                    <a href="delete.php?id=<?= $m['id'] ?>&enterprise=<?= $enterprise_id ?>" onclick="return confirm('Supprimer ce membre ?')">🗑 Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
