<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">

    <h1 class="mb-4">Tableau de bord</h1>

    <!-- Raccourcis rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <a href="articles/index.php" class="card text-center bg-dark text-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Articles</h5>
                    <p class="card-text">Gérer vos produits</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="categories/index.php" class="card text-center bg-dark text-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Catégories</h5>
                    <p class="card-text">Classer vos articles</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="transactions/index.php" class="card text-center bg-dark text-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Transactions</h5>
                    <p class="card-text">Ventes et Achats</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="stock/index.php" class="card text-center bg-dark text-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Stock</h5>
                    <p class="card-text">Inventaire</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Stats rapides -->
    <h2 class="mt-5">Statistiques rapides</h2>
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card bg-dark text-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Revenus</h5>
                    <p class="card-text display-6 text-success">
                        <?= number_format($revenus ?? 0, 2, ',', ' ') ?> $
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Dépenses</h5>
                    <p class="card-text display-6 text-danger">
                        <?= number_format($depenses ?? 0, 2, ',', ' ') ?> $
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Bénéfice</h5>
                    <p class="card-text display-6 text-info">
                        <?= number_format(($revenus ?? 0) - ($depenses ?? 0), 2, ',', ' ') ?> $
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
