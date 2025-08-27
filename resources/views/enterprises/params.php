<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$enterprise_id = $_GET['enterprise'] ?? null;
if (!$enterprise_id) die("Entreprise manquante");

$db = Database::get();
$stmt = $db->prepare("SELECT * FROM enterprises WHERE id=?");
$stmt->execute([$enterprise_id]);
$enterprise = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CSRF::check($_POST['_csrf'] ?? '')) die("Token CSRF invalide");

    $capital = $_POST['capital'];
    $tax_rate = $_POST['tax_rate'];
    $rp_year = $_POST['rp_year'];

    $stmt = $db->prepare("UPDATE enterprises SET capital=?, tax_rate=?, rp_year=? WHERE id=?");
    $stmt->execute([$capital, $tax_rate, $rp_year, $enterprise_id]);

    echo "<script>showToast('Paramètres sauvegardés','success');</script>";
    $enterprise['capital'] = $capital;
    $enterprise['tax_rate'] = $tax_rate;
    $enterprise['rp_year'] = $rp_year;
}

$title = "Paramètres - " . htmlspecialchars($enterprise['name']);
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Paramètres financiers - <?= htmlspecialchars($enterprise['name']) ?></h1>
<form method="POST">
    <?= CSRF::input() ?>

    <label>Capital exercice précédent ($) :</label><br>
    <input type="number" step="0.01" name="capital" value="<?= $enterprise['capital'] ?>" required><br><br>

    <label>Taux d’imposition :</label><br>
    <input type="number" step="0.01" name="tax_rate" value="<?= $enterprise['tax_rate'] ?>" required><br><br>

    <label>Année RP :</label><br>
    <input type="number" name="rp_year" value="<?= $enterprise['rp_year'] ?>" required><br><br>

    <button type="submit">💾 Sauvegarder</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
