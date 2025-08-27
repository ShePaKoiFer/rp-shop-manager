<?php
require __DIR__ . '/../../../app/bootstrap.php';
Auth::requireLogin();

$db = Database::get();

$id = $_GET['id'] ?? null;
$enterprise_id = $_GET['enterprise'] ?? null;
if (!$enterprise_id) die("Entreprise manquante");

$member = null;
if ($id) {
    $stmt = $db->prepare("SELECT * FROM members WHERE id=? AND enterprise_id=?");
    $stmt->execute([$id, $enterprise_id]);
    $member = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CSRF::check($_POST['_csrf'] ?? '')) {
        die("Token CSRF invalide");
    }

    $name = $_POST['name'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];
    $hourly_rate = $_POST['hourly_rate'];

    if ($id) {
        $stmt = $db->prepare("UPDATE members SET name=?, role=?, salary=?, hourly_rate=? WHERE id=? AND enterprise_id=?");
        $stmt->execute([$name, $role, $salary, $hourly_rate, $id, $enterprise_id]);
    } else {
        $stmt = $db->prepare("INSERT INTO members (enterprise_id, name, role, salary, hourly_rate) VALUES (?,?,?,?,?)");
        $stmt->execute([$enterprise_id, $name, $role, $salary, $hourly_rate]);
    }

    header("Location: index.php?enterprise=" . $enterprise_id);
    exit;
}

$title = $id ? "Modifier membre" : "Nouveau membre";
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1><?= $title ?></h1>
<form method="POST">
    <?= CSRF::input() ?>

    <label>Nom :</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($member['name'] ?? '') ?>" required><br><br>

    <label>Rôle :</label><br>
    <select name="role" required>
        <option value="PATRON" <?= ($member && $member['role']=="PATRON") ? 'selected' : '' ?>>Patron</option>
        <option value="CO-PATRON" <?= ($member && $member['role']=="CO-PATRON") ? 'selected' : '' ?>>Co-Patron</option>
        <option value="EMPLOYE" <?= ($member && $member['role']=="EMPLOYE") ? 'selected' : '' ?>>Employé</option>
    </select><br><br>

    <label>Salaire fixe ($/sem) :</label><br>
    <input type="number" step="0.01" name="salary" value="<?= $member['salary'] ?? 0 ?>" required><br><br>

    <label>Taux horaire ($/h) :</label><br>
    <input type="number" step="0.01" name="hourly_rate" value="<?= $member['hourly_rate'] ?? 0 ?>"><br><br>

    <button type="submit">💾 Sauvegarder</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
