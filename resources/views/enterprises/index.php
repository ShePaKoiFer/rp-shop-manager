<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$db = Database::get();
$enterprises = $db->query("SELECT * FROM enterprises ORDER BY id DESC")->fetchAll();

$title = "Entreprises";
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Entreprises</h1>
<a href="form.php">➕ Nouvelle entreprise</a>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Capital ($)</th>
            <th>Taux d’imposition</th>
            <th>Année RP</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($enterprises as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['name']) ?></td>
                <td><?= number_format($e['capital'], 2) ?></td>
                <td><?= $e['tax_rate'] * 100 ?>%</td>
                <td><?= $e['rp_year'] ?></td>
                <td>
                    <a href="form.php?id=<?= $e['id'] ?>">✏️ Modifier</a> | 
                    <a href="params.php?enterprise=<?= $e['id'] ?>">⚙️ Paramètres</a> | 
                    <a href="bilan.php?enterprise=<?= $e['id'] ?>">📊 Bilans</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
