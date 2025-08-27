<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$enterprise_id = $_GET['enterprise'] ?? null;
if (!$enterprise_id) {
    die("Entreprise manquante");
}

$db = Database::get();
$enterpriseStmt = $db->prepare("SELECT * FROM enterprises WHERE id=?");
$enterpriseStmt->execute([$enterprise_id]);
$enterprise = $enterpriseStmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CSRF::check($_POST['_csrf'] ?? '')) {
        die("Token CSRF invalide");
    }

    $type = $_POST['type'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    $stmt = $db->prepare("INSERT INTO transactions (enterprise_id, type, description, amount, created_at) VALUES (?,?,?,?,NOW())");
    $stmt->execute([$enterprise_id, $type, $description, $amount]);

    header("Location: index.php?enterprise=" . $enterprise_id);
    exit;
}

$title = "Nouvelle transaction - " . htmlspecialchars($enterprise['name']);
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1><?= $title ?></h1>
<form method="POST">
    <?= CSRF::input() ?>
    <label>Type :</label><br>
    <select name="type" required>
        <option value="VENTE">VENTE</option>
        <option value="ACHAT">ACHAT</option>
    </select><br><br>

    <label>Description :</label><br>
    <input type="text" name="description" required><br><br>

    <label>Montant ($) :</label><br>
    <input type="number" step="0.01" name="amount" required><br><br>

    <button type="submit">💾 Sauvegarder</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
