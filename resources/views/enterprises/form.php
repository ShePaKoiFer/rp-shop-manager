<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$db = Database::get();

$id = $_GET['id'] ?? null;
$enterprise = null;

if ($id) {
    $stmt = $db->prepare("SELECT * FROM enterprises WHERE id=?");
    $stmt->execute([$id]);
    $enterprise = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CSRF::check($_POST['_csrf'] ?? '')) {
        die("Token CSRF invalide");
    }

    $name = $_POST['name'];
    $capital = $_POST['capital'];
    $tax_rate = $_POST['tax_rate'];
    $rp_year = $_POST['rp_year'];

    if ($id) {
        $stmt = $db->prepare("UPDATE enterprises SET name=?, capital=?, tax_rate=?, rp_year=? WHERE id=?");
        $stmt->execute([$name, $capital, $tax_rate, $rp_year, $id]);
    } else {
        $stmt = $db->prepare("INSERT INTO enterprises (name, capital, tax_rate, rp_year) VALUES (?,?,?,?)");
        $stmt->execute([$name, $capital, $tax_rate, $rp_year]);
    }

    header("Location: index.php");
    exit;
}

$title = $id ? "Modifier entreprise" : "Nouvelle entreprise";
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1><?= $title ?></h1>
<form method="POST">
    <?= CSRF::input() ?>
    <label>Nom :</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($enterprise['name'] ?? '') ?>" required><br><br>

    <label>Capital initial :</label><br>
    <input type="number" step="0.01" name="capital" value="<?= $enterprise['capital'] ?? 0 ?>" required><br><br>

    <label>Taux d’imposition (ex: 0.10) :</label><br>
    <input type="number" step="0.01" name="tax_rate" value="<?= $enterprise['tax_rate'] ?? 0.10 ?>" required><br><br>

    <label>Année RP :</label><br>
    <input type="number" name="rp_year" value="<?= $enterprise['rp_year'] ?? 1899 ?>" required><br><br>

    <button type="submit">💾 Sauvegarder</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
