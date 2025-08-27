<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$db = Database::get();

$id = $_GET['id'] ?? null;
$enterprise_id = $_GET['enterprise'] ?? null;
if (!$enterprise_id) die("Entreprise manquante");

$stock = null;
if ($id) {
    $stmt = $db->prepare("SELECT * FROM stock WHERE id=? AND enterprise_id=?");
    $stmt->execute([$id, $enterprise_id]);
    $stock = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CSRF::check($_POST['_csrf'] ?? '')) {
        die("Token CSRF invalide");
    }

    $name = $_POST['name'];
    $quantity = $_POST['quantity'];

    if ($id) {
        $stmt = $db->prepare("UPDATE stock SET name=?, quantity=? WHERE id=? AND enterprise_id=?");
        $stmt->execute([$name, $quantity, $id, $enterprise_id]);
    } else {
        $stmt = $db->prepare("INSERT INTO stock (enterprise_id, name, quantity) VALUES (?,?,?)");
        $stmt->execute([$enterprise_id, $name, $quantity]);
    }

    header("Location: index.php?enterprise=" . $enterprise_id);
    exit;
}

$title = $id ? "Modifier stock" : "Nouvel article stock";
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1><?= $title ?></h1>
<form method="POST">
    <?= CSRF::input() ?>
    <label>Nom :</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($stock['name'] ?? '') ?>" required><br><br>

    <label>Quantité :</label><br>
    <input type="number" name="quantity" value="<?= $stock['quantity'] ?? 0 ?>" required><br><br>

    <button type="submit">💾 Sauvegarder</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
