<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$db = Database::get();
$categories = $db->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();

$title = "Catégories";
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1>Catégories</h1>
<a href="form.php">➕ Nouvelle catégorie</a>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
