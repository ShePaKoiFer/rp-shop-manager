<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$enterprise_id = $_GET['enterprise'] ?? null;
if (!$enterprise_id) die("Entreprise manquante");

$db = Database::get();
$enterpriseStmt = $db->prepare("SELECT * FROM enterprises WHERE id=?");
$enterpriseStmt->execute([$enterprise_id]);
$enterprise = $enterpriseStmt->fetch();

$stmt = $db->prepare("SELECT * FROM enterprise_reports WHERE enterprise_id=? ORDER BY start_date DESC");
$stmt->execute([$enterprise_id]);
$bilans = $stmt->fetchAll();

$title = "Bilans - " . htmlspecialchars($enterprise['name']);
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Bilans hebdomadaires - <?= htmlspecialchars($enterprise['name']) ?></h1>
<a href="new_bilan.php?enterprise=<?= $enterprise_id ?>">➕ Nouveau bilan</a>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Semaine</th>
            <th>CA</th>
            <th>Charges</th>
            <th>Bénéfice net</th>
            <th>Impôts</th>
            <th>Salaires</th>
            <th>Capital final</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bilans as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['start_date']) ?> au <?= htmlspecialchars($b['end_date']) ?></td>
                <td>$<?= number_format($b['chiffre_affaire'],2) ?></td>
                <td>$<?= number_format($b['charges'],2) ?></td>
                <td>$<?= number_format($b['benefice_net'],2) ?></td>
                <td>$<?= number_format($b['impots'],2) ?></td>
                <td>$<?= number_format($b['salaires'],2) ?></td>
                <td>$<?= number_format($b['capital_final'],2) ?></td>
                <td>
                    <a href="edit_bilan.php?id=<?= $b['id'] ?>&enterprise=<?= $enterprise_id ?>">✏️ Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
