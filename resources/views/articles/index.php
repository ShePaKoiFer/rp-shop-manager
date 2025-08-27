<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$db = Database::get();

// Récupération des articles avec leur catégorie
$stmt = $db->query("
    SELECT a.*, c.name AS category_name 
    FROM articles a 
    LEFT JOIN categories c ON a.category_id = c.id
    ORDER BY a.id DESC
");
$articles = $stmt->fetchAll();

$title = "Articles";
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Articles</h1>
<a href="form.php">➕ Nouvel article</a>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $a): ?>
            <tr>
                <td><?= $a['id'] ?></td>
                <td><?= htmlspecialchars($a['name']) ?></td>
                <td><?= htmlspecialchars($a['category_name']) ?></td>
                <td>$<?= number_format($a['price'], 2) ?></td>
                <td>
                    <a href="form.php?id=<?= $a['id'] ?>">✏️ Éditer</a> | 
                    <a href="delete.php?id=<?= $a['id'] ?>" onclick="return confirm('Supprimer cet article ?')">🗑 Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
