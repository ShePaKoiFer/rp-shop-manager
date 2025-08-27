<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$db = Database::get();

// Liste des catégories
$cats = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll();

$id = $_GET['id'] ?? null;
$article = null;

if ($id) {
    $stmt = $db->prepare("SELECT * FROM articles WHERE id=?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CSRF::check($_POST['_csrf'] ?? '')) {
        die("Token CSRF invalide");
    }

    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    if ($id) {
        $stmt = $db->prepare("UPDATE articles SET name=?, price=?, category_id=? WHERE id=?");
        $stmt->execute([$name, $price, $category_id, $id]);
    } else {
        $stmt = $db->prepare("INSERT INTO articles (name, price, category_id) VALUES (?,?,?)");
        $stmt->execute([$name, $price, $category_id]);
    }

    header("Location: index.php");
    exit;
}

$title = $id ? "Modifier un article" : "Nouvel article";
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1><?= $title ?></h1>
<form method="POST">
    <?= CSRF::input() ?>
    <label>Nom :</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($article['name'] ?? '') ?>" required><br><br>

    <label>Prix :</label><br>
    <input type="number" step="0.01" name="price" value="<?= $article['price'] ?? '' ?>" required><br><br>

    <label>Catégorie :</label><br>
    <select name="category_id" required>
        <?php foreach ($cats as $c): ?>
            <option value="<?= $c['id'] ?>" <?= ($article && $article['category_id'] == $c['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">💾 Sauvegarder</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
