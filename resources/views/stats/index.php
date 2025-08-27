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

// Stats globales : CA / Charges / Bénéfice net
$stats = $db->prepare("
    SELECT 
        SUM(CASE WHEN type='VENTE' THEN amount ELSE 0 END) AS revenus,
        SUM(CASE WHEN type='ACHAT' THEN amount ELSE 0 END) AS depenses
    FROM transactions 
    WHERE enterprise_id=?
");
$stats->execute([$enterprise_id]);
$data = $stats->fetch();

$revenus = $data['revenus'] ?? 0;
$depenses = $data['depenses'] ?? 0;
$benefice = $revenus - $depenses;

// Top 5 produits vendus (simplifié, basé sur description)
$top = $db->prepare("
    SELECT description, COUNT(*) AS ventes, SUM(amount) AS total
    FROM transactions
    WHERE enterprise_id=? AND type='VENTE'
    GROUP BY description
    ORDER BY total DESC
    LIMIT 5
");
$top->execute([$enterprise_id]);
$topProducts = $top->fetchAll();

$title = "Statistiques - " . htmlspecialchars($enterprise['name']);
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Statistiques - <?= htmlspecialchars($enterprise['name']) ?></h1>

<div class="dashboard">
    <div class="card">
        <h3>Chiffre d'affaires total</h3>
        <div class="value">$<?= number_format($revenus, 2) ?></div>
    </div>
    <div class="card">
        <h3>Total des charges</h3>
        <div class="value">$<?= number_format($depenses, 2) ?></div>
    </div>
    <div class="card">
        <h3>Bénéfice net</h3>
        <div class="value">$<?= number_format($benefice, 2) ?></div>
    </div>
</div>

<h2>Top 5 produits v
