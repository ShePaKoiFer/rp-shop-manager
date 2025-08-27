<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$db = Database::get();

$id = $_GET['id'] ?? null;
$category = null;

if ($id) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id=?");
    $stmt->execute([$id]);
    $category = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CSRF::check($_POST['_csrf'] ?? '')) {
        die("Token CSRF invalide");
    }

    $name = $_POST['name'];

    if ($id) {
        $stmt = $db->prepare("UPDATE categories SET name=? WHERE id=?");
        $stmt->execute([$name, $id]);
    } else {
        $stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
    }

    header("Location: index.php");
    exit;
}

$title = $id ? "Modifier une catégorie" : "Nouvelle catégorie";
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1><?= $title ?></h1>
<form method="POST">
    <?= CSRF::input() ?>
    <label>Nom :</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($category['name'] ?? '') ?>" required><br><br>

    <button type="submit">💾 Sauvegarder</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
